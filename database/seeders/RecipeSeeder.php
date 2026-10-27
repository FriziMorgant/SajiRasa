<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $cat1 = Category::create([
            'name' => 'Masakan Nusantara',
            'slug' => 'masakan-nusantara',
            'icon' => '🍚',
            'bg_color' => 'bg-amber-100 text-amber-900 border-amber-300',
        ]);

        $cat2 = Category::create([
            'name' => 'Minuman & Segaran',
            'slug' => 'minuman-segaran',
            'icon' => '🍹',
            'bg_color' => 'bg-emerald-100 text-emerald-900 border-emerald-300',
        ]);

        $cat3 = Category::create([
            'name' => 'Camilan & Kue',
            'slug' => 'camilan-kue',
            'icon' => '🥐',
            'bg_color' => 'bg-orange-100 text-orange-900 border-orange-300',
        ]);

        Recipe::create([
            'category_id' => $cat1->id,
            'title' => 'Nasi Goreng Spesial Dapur Ibu',
            'slug' => 'nasi-goreng-spesial-dapur-ibu',
            'description' => 'Nasi goreng harum khas rumahan dengan bumbu halus racikan bawang merah, cabai keriting, dan paha ayam suwir lezat.',
            'cooking_time' => 20,
            'servings' => 2,
            'difficulty' => 'Mudah',
            'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=1000&auto=format&fit=crop',
            'ingredients' => [
                '2 piring nasi putih dingin',
                '2 siung bawang putih (cincang halus)',
                '4 siung bawang merah (iris tipis)',
                '2 butir telur ayam',
                '2 sendok makan kecap manis',
                '1 sendok makan saus tiram',
                'Garam dan merica secukupnya',
                'Minyak untuk menumis'
            ],
            'steps' => [
                'Panaskan minyak, tumis bawang putih dan bawang merah hingga harum dan berwarna keemasan.',
                'Sisihkan tumisan di pinggir wajan, masukkan telur lalu orak-arik hingga matang.',
                'Masukkan nasi putih, aduk rata bersama bumbu dan telur.',
                'Tambahkan kecap manis, saus tiram, garam, dan merica. Aduk cepat dengan api besar hingga tercium aroma sangit harum.',
                'Angkat dan sajikan hangat bersama kerupuk dan acar.'
            ],
            'is_featured' => true,
        ]);

        Recipe::create([
            'category_id' => $cat2->id,
            'title' => 'Es Cendol Dawet Khas Alami',
            'slug' => 'es-cendol-dawet-khas-alami',
            'description' => 'Segarnya es cendol pandan asli dipadu dengan gurihnya santan segar dan sirup gula merah aren pekat.',
            'cooking_time' => 15,
            'servings' => 4,
            'difficulty' => 'Mudah',
            'image' => 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?q=80&w=1000&auto=format&fit=crop',
            'ingredients' => [
                '200 gram cendol pandan',
                '200 ml santan kental matang',
                '150 gram gula merah aren (lelehkan)',
                'Es batu secukupnya',
                '1 lembar daun pandan'
            ],
            'steps' => [
                'Siapkan gelas saji, tuang sirup gula merah aren di bagian paling bawah.',
                'Masukkan cendol secukupnya ke dalam gelas.',
                'Tambahkan es batu kepruk hingga hampir penuh.',
                'Siram dengan santan gurih di bagian atasnya. Sajikan dingin!'
            ],
            'is_featured' => true,
        ]);
    }
}
