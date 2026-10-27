<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $recipeId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'recipe_id' => $recipeId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan Anda berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        if (auth()->user()->role !== 'admin' && $review->user_id !== auth()->id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
