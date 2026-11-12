
@extends('layouts.artfolio')

@section('title', 'Artfolio | Discover Your Creative World')

@section('content')

<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">A COMMUNITY FOR CREATIVITY</span>

        <h1>
            Where imagination<br>
            becomes <span>art.</span>
        </h1>

        <p>
            Discover beautiful creations, meet talented artists,
            and share your own creative journey.
        </p>

        <div class="hero-actions">
            <a href="#discover" class="button button-primary">
                Explore Artworks
            </a>

            <a href="{{ route('register') }}"
               class="button button-light">
                Join Our Community
            </a>
        </div>
    </div>

    <div class="hero-decoration">
        <div class="art-card art-card-one">
            <div class="art-placeholder art-pink"></div>
            <span>Dream in Color</span>
            <small>Digital illustration</small>
        </div>

        <div class="art-card art-card-two">
            <div class="art-placeholder art-purple"></div>
            <span>Creative Soul</span>
            <small>Abstract artwork</small>
        </div>

        <div class="floating-star">✦</div>
        <div class="floating-circle"></div>
    </div>
</section>

<section class="section" id="discover">
    <div class="section-heading">
        <div>
            <span class="eyebrow">EXPLORE THE COMMUNITY</span>
            <h2>Discover inspiration</h2>
            <p>Find your next favorite artwork.</p>
        </div>
    </div>

    
@if ($artworks->count() > 0)
    <div class="artwork-gallery">
        @foreach ($artworks as $artwork)
            <article class="artwork-card">

                <div class="artwork-image">
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::url($artwork->image_path) }}"
                        alt="{{ $artwork->title }}"
                    >
                </div>

                <div class="artwork-details">
                    <h3>{{ $artwork->title }}</h3>

                    <p class="artwork-artist">
                        By
                        {{ $artwork->artist?->artistProfile?->display_name
                            ?? $artwork->artist?->name
                            ?? 'Unknown artist' }}
                    </p>

                    <p class="artwork-category">
                        {{ $artwork->category?->name ?? 'Uncategorized' }}
                    </p>

                    <div class="artwork-actions">
                        <span>
                            ♥ {{ $artwork->favorites_count }}
                            {{ $artwork->favorites_count === 1 ? 'Favorite' : 'Favorites' }}
                        </span>

                        @auth
                            <form
                                method="POST"
                                action="{{ route('artworks.favorite', $artwork) }}"
                            >
                                @csrf

                                <button type="submit" class="favorite-button">
                                    {{ $artwork->is_favorited ? '♥ Favorited' : '♡ Favorite' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="favorite-button">
                                ♡ Log in to favorite
                            </a>
                        @endauth
                    </div>
                </div>

            </article>
        @endforeach
    </div>
@else
    <div class="empty-gallery">
        <div class="empty-icon">✿</div>
        <h3>No published artworks yet.</h3>
        <p>
            Be the first to share your creativity with
            the Artfolio community.
        </p>

        @guest
            <a href="{{ route('register') }}" class="button button-primary">
                Become a Member
            </a>
        @endguest
    </div>
@endif

</section>

<section class="about-section" id="about">
    <span class="eyebrow">OUR CREATIVE SPACE</span>
    <h2>Every artist has a story.</h2>
    <p>
        Artfolio brings artists and art lovers together
        through creativity, expression, and inspiration.
    </p>
</section>

@endsection
