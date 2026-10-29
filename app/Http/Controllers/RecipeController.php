<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    /**
     * Menampilkan katalog utama resep beserta filter pencarian cerdas.
     */
    public function index(Request $request)
    {
        $query = Recipe::with(['category', 'user']);

        // Filter 1: Pencarian Kata Kunci
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter 2: Kategori Kuliner
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter 3: Waktu Memasak (dalam menit)
        if ($request->filled('time')) {
            if ($request->time == '15') {
                $query->where('cooking_time', '<=', 15);
            } elseif ($request->time == '30') {
                $query->where('cooking_time', '<=', 30);
            } elseif ($request->time == '60') {
                $query->where('cooking_time', '<=', 60);
            }
        }

        // Filter 4: Tingkat Kesulitan
        if ($request->filled('difficulty')) {
            $query->where('difficulty', $request->difficulty);
        }

        $recipes = $query->latest()->get();
        $categories = Category::all();

        return view('recipes.index', compact('recipes', 'categories'));
    }

    /**
     * Menampilkan detail resep lengkap sekaligus menambah jumlah statistik views +1.
     */
    public function show($id)
    {
        $recipe = Recipe::with(['category', 'user', 'reviews.user'])->findOrFail($id);

        // Otomatis menaikkan jumlah views resep saat halaman dibuka
        $recipe->increment('views');

        return view('recipes.show', compact('recipe'));
    }

    /**
     * Menampilkan form tambah resep baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('recipes.create', compact('categories'));
    }

    /**
     * Menyimpan resep baru ke database (mendukung Cloudinary HTTP API & URL).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'image_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'    => 'nullable|url',
            'ingredients'  => 'required|string',
            'steps'        => 'required|string',
            'cooking_time' => 'nullable|string',
            'servings'     => 'nullable|string',
            'difficulty'   => 'required|in:Mudah,Sedang,Sulit',
            'category_id'  => 'required|exists:categories,id',
        ]);

        $imagePath = 'https://upload.wikimedia.org/wikipedia/commons/2/23/Seblak_Bandung.jpg';
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');

            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            $apiKey = env('CLOUDINARY_API_KEY');
            $apiSecret = env('CLOUDINARY_API_SECRET');

            $timestamp = time();
            $signature = sha1("folder=sajirasa_recipes&timestamp={$timestamp}{$apiSecret}");

            $response = Http::attach(
                'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'folder' => 'sajirasa_recipes',
                'signature' => $signature,
            ]);

            if ($response->successful()) {
                $imagePath = $response->json('secure_url');
            }
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        Recipe::create([
            'title'        => $request->title,
            'slug'         => \Illuminate\Support\Str::slug($request->title),
            'category_id'  => $request->category_id,
            'user_id'      => Auth::id() ?? 1,
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'steps'        => $request->steps,
            'cooking_time' => $request->cooking_time,
            'servings'     => $request->servings,
            'difficulty'   => $request->difficulty,
            'image'        => $imagePath,
            'views'        => 0,
        ]);

        return redirect()->route('recipes.index')->with('success', 'Resep berhasil ditambahkan dan disimpan ke Cloudinary!');
    }

    /**
     * Menampilkan form edit resep.
     */
    public function edit($id)
    {
        $recipe = Recipe::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengedit resep ini.');
        }

        $categories = Category::all();
        return view('recipes.edit', compact('recipe', 'categories'));
    }

    /**
     * Memperbarui data resep di database.
     */
    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk memperbarui resep ini.');
        }

        $request->validate([
            'title'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'required|string',
            'ingredients'  => 'required|string',
            'steps'        => 'required|string',
            'cooking_time' => 'required|numeric',
            'servings'     => 'required|numeric',
            'difficulty'   => 'required|in:Mudah,Sedang,Sulit',
            'image_file'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_url'    => 'nullable|url',
        ]);

        $imagePath = $recipe->image;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');

            $cloudName = env('CLOUDINARY_CLOUD_NAME');
            $apiKey = env('CLOUDINARY_API_KEY');
            $apiSecret = env('CLOUDINARY_API_SECRET');

            $timestamp = time();
            $signature = sha1("folder=sajirasa_recipes&timestamp={$timestamp}{$apiSecret}");

            $response = Http::attach(
                'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
            )->post("https://api.cloudinary.com/v1_1/{$cloudName}/image/upload", [
                'api_key' => $apiKey,
                'timestamp' => $timestamp,
                'folder' => 'sajirasa_recipes',
                'signature' => $signature,
            ]);

            if ($response->successful()) {
                $imagePath = $response->json('secure_url');
            }
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->image_url;
        }

        $recipe->update([
            'title'        => $request->title,
            'slug'         => \Illuminate\Support\Str::slug($request->title),
            'category_id'  => $request->category_id,
            'description'  => $request->description,
            'ingredients'  => $request->ingredients,
            'steps'        => $request->steps,
            'cooking_time' => $request->cooking_time,
            'servings'     => $request->servings,
            'difficulty'   => $request->difficulty,
            'image'        => $imagePath,
        ]);

        return redirect()->route('recipes.show', $recipe->id)->with('success', 'Resep berhasil diperbarui!');
    }

    /**
     * Menghapus resep dari database.
     */
    public function destroy($id)
    {
        $recipe = Recipe::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus resep ini.');
        }

        $recipe->delete();

        return redirect()->route('recipes.index')->with('success', 'Resep berhasil dihapus!');
    }

    /**
     * Menampilkan daftar resep yang diunggah oleh pengguna yang sedang login.
     */
    public function myRecipes()
    {
        $recipes = Recipe::with('category')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('recipes.my-recipes', compact('recipes'));
    }
}
