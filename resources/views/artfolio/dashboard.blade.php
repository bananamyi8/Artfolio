
@extends('layouts.artfolio')

@section('title', 'Dashboard | Artfolio')

@section('content')

<section class="dashboard">

    <span class="eyebrow">YOUR CREATIVE SPACE</span>

    <h1>
        Welcome, {{ auth()->user()->name }}!
    </h1>

    <p>
        Your Artq journey starts here.
        Manage your creative profile and explore the community.
    </p>

    <div class="dashboard-card">

        <h2>Account information</h2>

        <p>
            <strong>Name:</strong>
            {{ auth()->user()->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ auth()->user()->email }}
        </p>

        <p>
            <strong>Account role:</strong>
            {{ ucfirst(auth()->user()->role) }}
        </p>

        @if(auth()->user()->isAdmin())
            <p>You have administrator access.</p>
            <a href="{{ route('admin.dashboard') }}"
               class="button button-primary">
                Admin Dashboard
            </a>

        @elseif(auth()->user()->isArtist())
            <p>You can manage your artist account.</p>
            <a href="{{ route('artist.dashboard') }}"
               class="button button-primary">
                Artist Dashboard
            </a>

        @else
            <p>Explore artworks and discover new artists.</p>
            <a href="{{ route('visitor.dashboard') }}"
               class="button button-primary">
                Visitor Dashboard
            </a>
        @endif

    </div>

    <div style="margin-top: 25px;">
        <a href="{{ route('artfolio.home') }}"
           class="button button-light">
            Back to Home
        </a>

        <form method="POST"
              action="{{ route('logout') }}"
              style="display:inline-block; margin-left: 8px;">
            @csrf

            <button type="submit" class="button button-primary">
                Log Out
            </button>
        </form>
    </div>

</section>

@endsection
