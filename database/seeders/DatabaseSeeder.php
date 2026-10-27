<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. SEEDER USERS (ADMIN, PENAMBAH, PEMBACA)
        // ==========================================

        // Akun Utama Admin (Pemilik Aplikasi)
        $admin = User::create([
            'name' => 'Admin SajiRasa',
            'email' => 'admin@sajirasa.com',
            'password' => Hash::make('admin123'), // Silakan ganti password ini sesuai keinginan
            'role' => 'admin',
        ]);

        // Akun Contoh Penambah Resep (Chef / Kontributor)
        $chef = User::create([
            'name' => 'Chef Budi',
            'email' => 'budi@sajirasa.com',
            'password' => Hash::make('password123'),
            'role' => 'penambah_resep',
        ]);

        // Akun Contoh Pembaca Biasa
        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@sajirasa.com',
            'password' => Hash::make('password123'),
            'role' => 'pembaca',
        ]);

        // ==========================================
        // 2. SEEDER KATEGORI MASAKAN
        // ==========================================

        $catUtama = Category::create([
            'name' => 'Makanan Utama',
            'icon' => '🍲',
            'slug' => 'makanan-utama'
        ]);

        $catSarapan = Category::create([
            'name' => 'Sarapan Praktis',
            'icon' => '🍳',
            'slug' => 'sarapan-praktis'
        ]);

        $catCamilan = Category::create([
            'name' => 'Camilan & Gorengan',
            'icon' => '🥖',
            'slug' => 'camilan-gorengan'
        ]);

        $catMinuman = Category::create([
            'name' => 'Minuman Segar',
            'icon' => '🍹',
            'slug' => 'minuman-segar'
        ]);

        // ==========================================
        // 3. SEEDER RESEP MASAKAN DUMMY
        // ==========================================

        Recipe::create([
            'user_id' => $chef->id,
            'category_id' => $catSarapan->id,
            'title' => 'Nasi Goreng Jawa Spesial',
            'slug' => 'nasi-goreng-jawa-spesial',
            'description' => 'Nasi goreng harum khas Jawa dengan bumbu racikan tradisional, telur ceplok, dan taburan bawang goreng renyah.',
            'ingredients' => json_encode([
                '2 piring nasi putih dingin',
                '2 siung bawang putih',
                '4 siung bawang merah',
                '2 buah cabai merah keriting',
                '1 sdm kecap manis',
                '1 sdt garam & penyedap',
                '1 butir telur',
                'Minyak secukupnya untuk menumis'
            ]),
            'steps' => json_encode([
                'Haluskan bawang merah, bawang putih, dan cabai merah.',
                'Panaskan minyak, tumis bumbu halus hingga wangi dan matang.',
                'Sisihkan bumbu di tepi wajan, orak-arik telur hingga matang.',
                'Masukkan nasi putih, beri kecap manis, garam, dan penyedap.',
                'Aduk rata dengan api besar hingga aroma harum keluar. Sajikan hangat.'
            ]),
            'cooking_time' => 15,
            'servings' => 2,
            'difficulty' => 'Mudah',
            'image' => 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?q=80&w=800&auto=format&fit=crop'
        ]);

        Recipe::create([
            'user_id' => $admin->id,
            'category_id' => $catUtama->id,
            'title' => 'Soto Ayam Santan Gurih',
            'slug' => 'soto-ayam-santan-gurih',
            'description' => 'Kuah soto berkaldu kaya rempah dipadu gurihnya santan segar dan irisan daging ayam empuk.',
            'ingredients' => json_encode([
                '500gr daging ayam',
                '200ml santan kental',
                '1 liter air',
                '2 batang serai (geprek)',
                '3 lembar daun jeruk',
                'Bawang goreng & seledri untuk taburan'
            ]),
            'steps' => json_encode([
                'Rebus ayam hingga empuk, tiriskan lalu suwir-suwir dagingnya.',
                'Tumis bumbu halus soto bersama serai dan daun jeruk hingga wangi.',
                'Masukkan bumbu tumis ke dalam air rebusan kaldu.',
                'Tuang santan kental pelan-pelan sambil diaduk agar tidak pecah.',
                'Sajikan kuah hangat bersama suwiran ayam dan taburan bawang goreng.'
            ]),
            'cooking_time' => 45,
            'servings' => 4,
            'difficulty' => 'Sedang',
            'image' => 'https://images.unsplash.com/photo-1541832676-9b763b0239ab?q=80&w=800&auto=format&fit=crop'
        ]);

        Recipe::create([
            'user_id' => $chef->id,
            'category_id' => $catCamilan->id,
            'title' => 'Tahu Isi Sayur Renyah',
            'slug' => 'tahu-isi-sayur-renyah',
            'description' => 'Tahu goreng renyah dengan isian wortel, tauge, dan daun bawang gurih yang cocok untuk teman teh hangat.',
            'ingredients' => json_encode([
                '10 buah tahu kulit/cokelat',
                '100gr wortel serut',
                '100gr tauge',
                '150gr tepung terigu',
                'Air & garam secukupnya'
            ]),
            'steps' => json_encode([
                'Tumis wortel dan tauge dengan sedikit garam hingga agak layu.',
                'Belah satu sisi tahu, masukkan isian sayur tumis ke dalamnya.',
                'Buat adonan tepung terigu encer yang diberi garam dan kaldu.',
                'Celupkan tahu ke dalam adonan tepung, lalu goreng dalam minyak panas hingga kuning keemasan.'
            ]),
            'cooking_time' => 25,
            'servings' => 5,
            'difficulty' => 'Mudah',
            'image' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?q=80&w=800&auto=format&fit=crop'
        ]);
    }
}
