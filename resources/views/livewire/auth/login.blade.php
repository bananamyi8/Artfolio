<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.artfolio-auth')] class extends Component {

    public string $login = '';
    public string $password = '';
    public bool $remember = false;

    /**
     * Handle an incoming login request.
     */
    public function login(): void
    {
        $validated = $this->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $this->ensureIsNotRateLimited();

        $login = strtolower(trim($validated['login']));

        // Allow login through either username or email.
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $field => $login,
            'password' => $validated['password'],
        ];

        if (! Auth::attempt($credentials, $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => 'The username/email or password is incorrect.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        session()->regenerate();

        $user = Auth::user();

        // Send users who have not selected a role to role selection.
        if ($user->role_selected_at === null && $user->role !== 'admin') {
            $this->redirect(route('role.show', absolute: false), navigate: true);
            return;
        }

        // Redirect according to the user's role.
        $destination = match ($user->role) {
            'artist' => route('artist.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('visitor.dashboard'),
        };

        $this->redirect($destination, navigate: true);
    }

    /**
     * Ensure the login request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->login) . '|' . request()->ip());
    }

}; ?>

<div class="flex flex-col gap-6">

    <x-auth-header
        title="Welcome back"
        description="Log in to your Artfolio account."
    />

    <x-auth-session-status
        class="text-center"
        :status="session('status')"
    />

    <form wire:submit="login" class="flex flex-col gap-6">

        <!-- Username or Email -->
        <div class="grid gap-2">
            <flux:input
                wire:model="login"
                id="login"
                label="Username or Email address"
                type="text"
                name="login"
                required
                autofocus
                autocomplete="username"
                placeholder="Enter your username or email"
            />
        </div>

        <!-- Password -->
        <div class="grid gap-2">
            <flux:input
                wire:model="password"
                id="password"
                label="Password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
            />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm">
                <input
                    type="checkbox"
                    wire:model="remember"
                    class="rounded"
                />
                Remember me
            </label>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end">
            <flux:button
                type="submit"
                variant="primary"
                class="w-full"
                wire:loading.attr="disabled"
                wire:target="login"
            >
                <span wire:loading.remove wire:target="login">Log in</span>
                <span wire:loading wire:target="login">Logging in...</span>
            </flux:button>
        </div>

    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Don't have an account?
        <x-text-link href="{{ route('register') }}">
            Create an account
        </x-text-link>
    </div>

</div>