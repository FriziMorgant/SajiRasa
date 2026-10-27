<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Recipe;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // Menampilkan daftar resep favorit pengguna
    public function index()
    {
        $user = auth()->user();
        $favorites = Favorite::with('recipe.category')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('recipes.favorites', compact('favorites'));
    }

    // Toggle Favorit (Bookmark/Unbookmark)
    public function toggle($recipeId)
    {
        $user = auth()->user();
        $recipe = Recipe::findOrFail($recipeId);

        $existing = Favorite::where('user_id', $user->id)
            ->where('recipe_id', $recipe->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Resep dihapus dari favorit.');
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe->id
            ]);
            return back()->with('success', 'Resep berhasil ditambahkan ke favorit!');
        }
    }
}
