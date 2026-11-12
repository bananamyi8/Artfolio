
@extends('layouts.artfolio')

@section('title', 'Choose Your Role | Artfolio')

@section('content')
<section class="role-selection">

    <div class="role-heading">
        <span class="eyebrow">WELCOME TO ARTFOLIO</span>

        <h1>How would you like to use Artfolio?</h1>

        <p>
            Choose the role that best describes your experience.
            Start your creative journey with us!
        </p>
    </div>

    @if ($errors->any())
        <div class="role-error">
            {{ $errors->first('role') }}
        </div>
    @endif

    <form method="POST" action="{{ route('role.store') }}">
        @csrf

        <div class="role-cards">

            <label class="role-card">
                <input
                    type="radio"
                    name="role"
                    value="artist"
                    required
                    {{ old('role') === 'artist' ? 'checked' : '' }}
                >

                <div class="role-icon">🎨</div>

                <h2>I'm an Artist</h2>

                <p>
                    Share your creativity, upload artworks,
                    build your portfolio, and join exhibitions.
                </p>

                <span class="role-choice">Choose Artist</span>
            </label>

            <label class="role-card">
                <input
                    type="radio"
                    name="role"
                    value="visitor"
                    required
                    {{ old('role') === 'visitor' ? 'checked' : '' }}
                >

                <div class="role-icon">🖼️</div>

                <h2>I'm a Visitor</h2>

                <p>
                    Discover amazing artworks, follow artists,
                    save favorites, and explore exhibitions.
                </p>

                <span class="role-choice">Choose Visitor</span>
            </label>

        </div>

        <button type="submit" class="button button-primary role-submit">
            Continue to Artfolio
        </button>

    </form>
</section>
@endsection
