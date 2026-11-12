
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Artfolio | Welcome</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance

    <link rel="stylesheet" href="{{ asset('css/artfolio.css') }}">
</head>
<body>

    <div class="artfolio-auth-page">

        <a href="{{ route('artfolio.home') }}" class="auth-logo">
            Artfolio<span>.</span>
        </a>

        <div class="auth-card">

            <div class="auth-brand">
                <span class="eyebrow">YOUR CREATIVE SPACE</span>
                <h1>Welcome to Artfolio</h1>
                <p>A place where creativity meets community.</p>
            </div>

            {{ $slot }}

            <div class="auth-back-home">
                <a href="{{ route('artfolio.home') }}">
                    ← Back to Artfolio homepage
                </a>
            </div>

        </div>

        <p class="auth-copyright">
            © {{ date('Y') }} Artfolio. All rights reserved.
        </p>

    </div>

    @fluxScripts
</body>
</html>
