<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArtistProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = $request->user()
            ->artistProfile()
            ->firstOrCreate(
                [],
                ['display_name' => $request->user()->name]
            );

        return view('artfolio.artist-profile', compact('profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'display_name' => ['required', 'string', 'max:100'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'url', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $profile = $request->user()
            ->artistProfile()
            ->firstOrCreate(
                [],
                ['display_name' => $request->user()->name]
            );

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $validated['avatar'] = $request->file('avatar')
                ->store('artist-avatars', 'public');
        }

        $profile->update([
            'display_name' => $validated['display_name'],
            'bio' => $validated['bio'] ?? null,
            'website' => $validated['website'] ?? null,
            'avatar' => $validated['avatar'] ?? $profile->avatar,
        ]);

        return redirect()
            ->route('artist.profile')
            ->with('success', 'Your artist profile has been updated!');
    }

    public function show(Request $request): View
{
    $user = $request->user();

    $profile = $user->artistProfile()
        ->firstOrCreate(
            [],
            ['display_name' => $user->name]
        );

    $artworks = $user->artworks()
        ->with('category')
        ->withCount('favorites')
        ->where('status', 'published')
        ->latest()
        ->get();

    return view('artfolio.artist-profile', compact('profile', 'artworks'));
}

}
