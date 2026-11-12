
@extends('layouts.artist')

@section('title', 'My Profile | Artfolio')

@section('artist-content')

<div class="artist-page-heading">
    <span class="artist-eyebrow">YOUR CREATIVE IDENTITY</span>
    <h1>My Profile</h1>
    <p>Your artist identity and creative collection.</p>
</div>

{{-- Saved Artist Information --}}
<div class="artist-content-card saved-profile-card">

    <div class="saved-profile-header">

        {{-- Profile Picture --}}
        <div class="saved-profile-avatar">
            @if ($profile->avatar)
                <img
                    src="{{ \Illuminate\Support\Facades\Storage::url($profile->avatar) }}"
                    alt="{{ auth()->user()->username }}"
                >
            @else
                <span>
                    {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
                </span>
            @endif
        </div>

        {{-- Artist Account Information --}}
        <div class="saved-profile-heading">
            <span class="artist-eyebrow">ARTFOLIO ARTIST</span>

            <h2>{{ '@' . auth()->user()->username }}</h2>

            <p>Artist Account</p>
        </div>

    </div>

    <div class="saved-profile-divider"></div>

    {{-- Biography --}}
    <div class="saved-profile-section">
        <h3>About Me</h3>

        @if ($profile->bio)
            <p>{{ $profile->bio }}</p>
        @else
            <p class="profile-not-set">
                This artist hasn't added a biography yet.
            </p>
        @endif
    </div>

    {{-- Website --}}
    <div class="saved-profile-section">
        <h3>Website / Portfolio</h3>

        @if ($profile->website)
            <a
                href="{{ $profile->website }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                {{ $profile->website }}
            </a>
        @else
            <p class="profile-not-set">
                No website or portfolio link added.
            </p>
        @endif
    </div>

    {{-- Edit Profile Button --}}
    <div class="saved-profile-actions">
        <a href="{{ route('artist.settings') }}" class="button button-primary">
            Edit Profile
        </a>
    </div>

</div>


{{-- Artist Artwork Collection --}}
<section class="artist-my-collection">

    <div class="artist-page-heading collection-heading">
        <span class="artist-eyebrow">YOUR CREATIVE WORK</span>
        <h2>My Artworks</h2>
        <p>Explore the artworks you have published on Artfolio.</p>
    </div>

    @if ($artworks->count() > 0)

        <div class="artwork-gallery">

            @foreach ($artworks as $artwork)

                <article class="artwork-card">

                    {{-- Artwork Image --}}
                    <div class="artwork-image">
                        <img
                            src="{{ \Illuminate\Support\Facades\Storage::url($artwork->image_path) }}"
                            alt="{{ $artwork->title }}"
                        >
                    </div>

                    {{-- Artwork Information --}}
                    <div class="artwork-details">

                        <h3>{{ $artwork->title }}</h3>

                        <p class="artwork-category">
                            {{ $artwork->category?->name ?? 'Uncategorized' }}
                        </p>

                        @if ($artwork->description)
                            <p class="artwork-description">
                                {{ $artwork->description }}
                            </p>
                        @endif

                        {{-- Favorite Count --}}
                        <div class="artwork-actions">
                            <span>
                                ♥ {{ $artwork->favorites_count }}
                                {{ $artwork->favorites_count === 1 ? 'Favorite' : 'Favorites' }}
                            </span>
                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        {{-- Empty Artwork Collection --}}
        <div class="artist-content-card empty-gallery">

            <div class="empty-icon">✿</div>

            <h3>No published artworks yet.</h3>

            <p>
                Your published artworks will appear here once
                you start sharing your creations.
            </p>

            <a
                href="{{ route('artist.artworks') }}"
                class="button button-primary"
            >
                Go to My Artworks
            </a>

        </div>

    @endif

</section>

@endsection
