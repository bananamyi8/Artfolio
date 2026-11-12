<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleSelectionController extends Controller
{
    public function show(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user->role_selected_at !== null) {
            return $this->redirectToDashboard($user->role);
        }

        return view('auth.choose-role');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'in:artist,visitor'],
        ]);

        $user = $request->user();

        if ($user->role_selected_at !== null) {
            return $this->redirectToDashboard($user->role);
        }

        $user->forceFill([
            'role' => $validated['role'],
            'role_selected_at' => now(),
        ])->save();

        return $this->redirectToDashboard($validated['role']);
    }

    private function redirectToDashboard(string $role): RedirectResponse
    {
        return match ($role) {
            'artist' => redirect()->route('artist.dashboard'),
            'admin' => redirect()->route('admin.dashboard'),
            default => redirect()->route('visitor.dashboard'),
        };
    }
}
