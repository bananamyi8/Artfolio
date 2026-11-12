
@extends('layouts.artist')

@section('title', 'Dashboard | Artfolio')

@section('artist-content')
<div class="artist-topbar">
    <div>
        <span class="artist-eyebrow">YOUR CREATIVE SPACE</span>
        <h1>Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->name }}!</p>
    </div>

    <a href="{{ route('artist.artworks') }}" class="artist-upload-button">
        + Manage Artworks
    </a>
</div>

<section class="artist-welcome">
    <div>
        <span>WELCOME TO YOUR WORKSPACE!</span>
        <h2>Keep creating, keep inspiring. 🎨</h2>
        <p>Manage your portfolio, share your creations, and connect with the Artfolio community.</p>
        <a href="{{ route('artist.profile') }}">Set up your artist profile →</a>
    </div>
    <div class="welcome-decoration">✿</div>
</section>

<section class="artist-stats">
    <div class="artist-stat-card">
        <div class="stat-icon lavender">▧</div>
        <div><span>Total Artworks</span><h3>0</h3><small>Your published creations</small></div>
    </div>

    <div class="artist-stat-card">
        <div class="stat-icon pink">♡</div>
        <div><span>Total Favorites</span><h3>0</h3><small>People who love your art</small></div>
    </div>

    <div class="artist-stat-card">
        <div class="stat-icon peach">♙</div>
        <div><span>Followers</span><h3>0</h3><small>Your community</small></div>
    </div>

    <div class="artist-stat-card">
        <div class="stat-icon cream">✧</div>
        <div><span>Exhibitions</span><h3>0</h3><small>Your exhibition entries</small></div>
    </div>
</section>

<section class="artist-section">
    <div class="artist-section-heading">
        <div>
            <span class="artist-eyebrow">GET STARTED</span>
            <h2>Your Creative Workspace</h2>
            <p>Choose what you want to work on today.</p>
        </div>
    </div>

    <div class="artist-quick-links">
        <a href="{{ route('artist.profile') }}">♙ <strong>Complete your profile</strong><span>Introduce yourself to the community.</span></a>
        <a href="{{ route('artist.artworks') }}">▧ <strong>Manage your artworks</strong><span>Build your online art portfolio.</span></a>
        <a href="{{ route('artist.exhibitions') }}">✧ <strong>Explore exhibitions</strong><span>Showcase your creative works.</span></a>
        <a href="{{ route('artist.favorites') }}">♡ <strong>View your favorites</strong><span>Revisit artworks you have saved.</span></a>
    </div>
</section>
@endsection
