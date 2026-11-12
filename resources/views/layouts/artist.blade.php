
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Artist Workspace | Artfolio')</title>
    <link rel="stylesheet" href="{{ asset('css/artfolio.css') }}">
</head>
<body>
<div class="artist-dashboard">

    <aside class="artist-sidebar">
        <a href="{{ route('artfolio.home') }}" class="artist-sidebar-logo">
            Artfolio<span>.</span>
        </a>

        <p class="sidebar-label">WORKSPACE</p>

        <nav class="artist-menu">
            <a href="{{ route('artist.dashboard') }}"
               class="{{ request()->routeIs('artist.dashboard') ? 'active' : '' }}">
                ⌂ Dashboard
            </a>

            <a href="{{ route('artist.profile') }}"
               class="{{ request()->routeIs('artist.profile') ? 'active' : '' }}">
                ♙ My Profile
            </a>

            <a href="{{ route('artist.artworks') }}"
               class="{{ request()->routeIs('artist.artworks') ? 'active' : '' }}">
                ▧ My Artworks
            </a>

            <a href="{{ route('artist.exhibitions') }}"
               class="{{ request()->routeIs('artist.exhibitions') ? 'active' : '' }}">
                ✧ Exhibitions
            </a>

            <a href="{{ route('artist.favorites') }}"
               class="{{ request()->routeIs('artist.favorites') ? 'active' : '' }}">
                ♡ Favorites
            </a>
        </nav>

        <p class="sidebar-label">ACCOUNT</p>

        <nav class="artist-menu">
            <a href="{{ route('artist.settings') }}"
               class="{{ request()->routeIs('artist.settings') ? 'active' : '' }}">
                ⚙ Settings
            </a>

            <a href="{{ route('artfolio.home') }}">
                ← Back to Website
            </a>
        </nav>

       <div class="sidebar-bottom">
    <div class="sidebar-avatar">
        {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
    </div>

    <div class="sidebar-user">
        <strong>{{ '@' .auth()->user()->username }}</strong>
        <span>Artist Account</span>
    </div>
</div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="artist-logout">Log Out</button>
        </form>
    </aside>

    <main class="artist-main">
        @yield('artist-content')
    </main>

</div>
</body>
</html>
