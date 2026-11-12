<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Artwork $artwork): RedirectResponse
    {
        abort_unless($artwork->status === 'published', 404);

        $favorite = $artwork->favorites()
            ->where('user_id', $request->user()->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        } else {
            $artwork->favorites()->create([
                'user_id' => $request->user()->id,
            ]);
        }

        return back();
    }
}
