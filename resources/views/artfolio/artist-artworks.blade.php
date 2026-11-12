
@extends('layouts.artist')

@section('title', 'My Artworks | Artfolio')

@section('artist-content')
<div class="artist-page-heading">
    <span class="artist-eyebrow">YOUR COLLECTION</span>
    <h1>My Artworks</h1>
    <p>Upload, organize, edit, and manage your creative works.</p>
</div>

<div class="artist-section-heading">
    <h2>My Gallery</h2>
    <button type="button" class="artist-upload-button"
        onclick="alert('Artwork upload form will be implemented next.')">
        + Upload Artwork
    </button>
</div>

<div class="artist-content-card">
    <div class="artist-page-icon">🎨</div>
    <h2>Your gallery is waiting!</h2>
    <p>You haven't uploaded any artworks yet. Start building your portfolio by sharing your first creation.</p>
    <p class="artist-coming-soon">Artwork upload and management will be connected to your database next.</p>
</div>
@endsection
