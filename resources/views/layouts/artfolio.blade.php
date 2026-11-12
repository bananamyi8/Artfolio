
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Artfolio')</title>

    <link rel="stylesheet" href="{{ asset('css/artfolio.css') }}">
</head>
<body>

    <header class="navbar">
        <a href="{{ route('artfolio.home') }}" class="logo">
            Artfolio<span>.</span>
        </a>

        <nav class="nav-links">
            <a href="{{ route('artfolio.home') }}">Home</a>
            <a href="{{ route('artfolio.home') }}#discover">Discover</a>
            <a href="{{ route('artfolio.home') }}#about">About</a>
        </nav>

        <div class="nav-actions">
            @auth
                @if (auth()->user()->role === 'artist')
                    <a href="{{ route('artist.dashboard') }}"
                       class="button button-primary">
                        Dashboard
                    </a>

                @elseif (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="button button-primary">
                        Dashboard
                    </a>

                @elseif (auth()->user()->role === 'visitor')
                    <a href="{{ route('visitor.dashboard') }}"
                       class="button button-primary">
                        Dashboard
                    </a>

                @else
                    <a href="{{ route('role.show') }}"
                       class="button button-primary">
                        Choose Role
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="login-link">
                        Log Out
                    </button>
                </form>

            @else
                <a href="{{ route('login') }}" class="login-link">
                    Log In
                </a>

                <a href="{{ route('register') }}"
                   class="button button-primary">
                    Join Artfolio
                </a>
            @endauth
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <h2>Artfolio.</h2>
        <p>A creative space for artists and art lovers.</p>
        <p>© {{ date('Y') }} Artfolio. All rights reserved.</p>
    </footer>

</body>
</html>
