<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $query = Artwork::with([
            'artist.artistProfile',
            'category',
        ])
        ->withCount('favorites')
        ->where('status', 'published')
        ->latest();

        if (auth()->check()) {
            $query->withExists([
                'favorites as is_favorited' => function ($favoriteQuery) {
                    $favoriteQuery->where('user_id', auth()->id());
                },
            ]);
        }

        $artworks = $query->get();

        return view('artfolio.home', compact('artworks'));
    }
}
