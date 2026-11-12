
<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.artfolio-auth')] class extends Component {

    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'alpha_dash',
                'unique:users,username',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::defaults(),
            ],
        ]);

        // Normalize username to lowercase.
        $validated['username'] = strtolower(trim($validated['username']));

        // Keep the existing required name column populated.
        // The application will display username instead.
        $validated['name'] = $validated['username'];

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        event(new Registered($user));

        Auth::login($user);

        // Continue to role selection.
        $this->redirect(
            route('role.show', absolute: false),
            navigate: true
        );
    }

}; ?>

<div class="flex flex-col gap-6">

    <x-auth-header
        title="Create an account"
        description="Choose your username and enter your details to join Artfolio."
    />

    <x-auth-session-status
        class="text-center"
        :status="session('status')"
    />

    <form wire:submit="register" class="flex flex-col gap-6">

        <!-- Username -->
        <div class="grid gap-2">
            <flux:input
                wire:model="username"
                id="username"
                label="Username"
                type="text"
                name="username"
                required
                autofocus
                autocomplete="username"
                placeholder="e.g. artlover123"
            />

            <p class="text-xs text-zinc-500">
                Use 3–30 characters. Letters, numbers, hyphens, and underscores only.
            </p>
        </div>

        <!-- Email Address -->
        <div class="grid gap-2">
            <flux:input
                wire:model="email"
                id="email"
                label="Email address"
                type="email"
                name="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
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
                autocomplete="new-password"
                placeholder="Password"
            />
        </div>

        <!-- Confirm Password -->
        <div class="grid gap-2">
            <flux:input
                wire:model="password_confirmation"
                id="password_confirmation"
                label="Confirm password"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                placeholder="Confirm password"
            />
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                Create account
            </flux:button>
        </div>

    </form>

    <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
        Already have an account?
        <x-text-link href="{{ route('login') }}">
            Log in
        </x-text-link>
    </div>

</div>
