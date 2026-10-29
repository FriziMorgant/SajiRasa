<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $recipe->title }} — SajiRasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @view-transition {
            navigation: auto;
        }

        ::view-transition-old(root) {
            animation: 0.2s cubic-bezier(0.4, 0, 1, 1) both fade-out;
        }

        ::view-transition-new(root) {
            animation: 0.3s cubic-bezier(0, 0, 0.2, 1) 0.1s both fade-in;
        }

        @keyframes fade-out {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .print-card {
                background: white !important;
                border: none !important;
                box-shadow: none !important;
                color: black !important;
            }
        }

        .glow-hover:hover {
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.4);
        }
    </style>
</head>

<body
    class="bg-stone-950 text-stone-100 min-h-screen flex flex-col justify-between relative antialiased selection:bg-orange-500 selection:text-stone-950">

    <!-- TOMBOL KEMBALI KE KATALOG -->
    <div class="fixed top-5 right-5 z-50 pointer-events-auto no-print">
        <a href="{{ url('/') }}"
            class="px-4 py-2.5 bg-stone-800/90 hover:bg-orange-600 text-stone-200 hover:text-white rounded-2xl text-xs font-black transition-all border border-stone-700 shadow-2xl backdrop-blur-md flex items-center gap-2 cursor-pointer active:scale-95">
            <span>←</span> Kembali ke Katalog
        </a>
    </div>

    <!-- BACKGROUND SUSHI PERMANEN -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-stone-950 no-print">
        <img src="{{ asset('images/bg-sushi.jpg') }}" alt="Background Kuliner SajiRasa"
            class="w-full h-full object-cover object-right-top scale-105 filter blur-[0.5px] opacity-90 absolute inset-0">
        <div class="absolute inset-0 bg-stone-950/40"></div>
    </div>

    <!-- NOTIFIKASI TOAST FLOATING -->
    <div id="toast-notification"
        class="fixed top-24 right-5 z-50 transform translate-x-full opacity-0 transition-all duration-500 pointer-events-none">
        <div
            class="bg-stone-900/95 backdrop-blur-2xl border border-orange-500/80 text-orange-400 px-6 py-4 rounded-2xl shadow-2xl shadow-orange-950/50 flex items-center gap-4 border-l-4 border-l-orange-500">
            <span class="text-2xl animate-bounce">✨</span>
            <div>
                <p class="text-xs font-black text-stone-100 tracking-wide uppercase">Tautan Berhasil Disalin!</p>
                <p class="text-[11px] text-stone-300 mt-0.5">Siap dibagikan ke teman-temanmu.</p>
            </div>
        </div>
    </div>

    <!-- NAVBAR UTAMA -->
    <header class="bg-stone-900/70 backdrop-blur-md border-b border-stone-800/80 sticky top-0 z-40 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- LOGO NAVBAR SAJIRASA (UKURAN PRESISI & RESPONSIF) -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer shrink-0">
                    <div
                        class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl overflow-hidden bg-white p-1 border border-orange-500/40 shadow-md flex items-center justify-center shrink-0">
                        <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa"
                            class="w-full h-full object-contain">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span
                            class="text-lg sm:text-xl font-black tracking-tight text-stone-100 leading-none">SajiRasa</span>
                        <span
                            class="text-[9px] sm:text-[10px] font-bold tracking-widest text-orange-400 uppercase mt-1">Dapur
                            Rumahan</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-3 pr-40">
                @auth
                    @if (in_array(Auth::user()->role, ['admin', 'penambah_resep']))
                        <a href="{{ route('recipes.my-recipes') }}"
                            class="hidden md:inline-block px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-200 rounded-xl text-xs font-bold transition-all border border-stone-700">
                            📋 Resep Saya
                        </a>
                        <a href="{{ route('recipes.create') }}"
                            class="hidden md:inline-block px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                            + Kirim Resep
                        </a>
                    @endif

                    <span
                        class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-stone-900/80 rounded-xl border border-stone-800 text-xs font-bold text-stone-300">
                        👤 {{ Auth::user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="px-3.5 py-2 bg-stone-800 hover:bg-rose-600 text-stone-300 hover:text-white rounded-xl text-xs font-bold transition-all cursor-pointer">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-bold text-stone-300 hover:text-orange-400 px-3 py-2">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-orange-600 text-white rounded-xl text-xs font-bold">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full space-y-8">

        @if (session('success'))
            <div
                class="p-4 bg-emerald-950/60 border border-emerald-800/60 text-emerald-300 text-xs rounded-2xl font-medium shadow-sm backdrop-blur-md no-print">
                ✨ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="p-4 bg-rose-950/60 border border-rose-800/60 text-rose-300 text-xs rounded-2xl font-medium shadow-sm backdrop-blur-md no-print">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- 1. HERO HEADER RESEP -->
        <div
            class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 sm:p-10 shadow-2xl print-card">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                <div
                    class="lg:col-span-5 relative overflow-hidden rounded-2xl shadow-2xl border border-stone-700/50 h-72 sm:h-88 bg-stone-900 group">
                    <div id="skeleton-detail-img"
                        class="absolute inset-0 bg-stone-800 animate-pulse flex items-center justify-center">
                        <span class="text-3xl opacity-40">🍳</span>
                    </div>

                    @php
                        $imgSource = $recipe->image ?? '';
                        // Pastikan mengecek apakah string benar-benar URL http/https
                        $finalImageUrl = filter_var($imgSource, FILTER_VALIDATE_URL)
                            ? $imgSource
                            : 'https://upload.wikimedia.org/wikipedia/commons/2/23/Seblak_Bandung.jpg';
                    @endphp

                    <img src="{{ $finalImageUrl }}" alt="{{ $recipe->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-all duration-700">

                    <span
                        class="absolute top-4 left-4 px-3.5 py-1.5 bg-stone-950/80 backdrop-blur-md rounded-xl text-xs font-bold text-orange-300 border border-stone-800 shadow-lg z-10">
                        {{ optional($recipe->category)->name ?? 'Kuliner' }}
                    </span>
                </div>

                <div class="lg:col-span-7 space-y-5">
                    <div>
                        <span class="text-xs font-bold text-orange-400 uppercase tracking-widest block mb-1">Resep Oleh:
                            {{ optional($recipe->user)->name ?? 'Kontributor SajiRasa' }}</span>
                        <h1 class="text-2xl sm:text-4xl font-black text-stone-100 leading-tight tracking-tight">
                            {{ $recipe->title }}
                        </h1>
                    </div>

                    <p class="text-stone-300 text-xs sm:text-sm leading-relaxed">
                        {{ $recipe->description }}
                    </p>

                    <!-- STAT CARDS DENGAN IKON REAL -->
                    <div class="grid grid-cols-4 gap-3">
                        <div
                            class="bg-stone-950/60 border border-stone-800 p-3 rounded-2xl text-center hover:border-orange-500/50 transition-all flex flex-col items-center">
                            <img src="{{ asset('images/icons/time.png') }}" class="w-5 h-5 object-contain mb-1"
                                alt="Waktu">
                            <span
                                class="text-[10px] text-stone-400 font-semibold block uppercase tracking-wider">Waktu</span>
                            <span class="text-xs font-bold text-stone-200 mt-0.5">{{ $recipe->cooking_time }}
                                Mnt</span>
                        </div>

                        <div
                            class="bg-stone-950/60 border border-stone-800 p-3 rounded-2xl text-center hover:border-orange-500/50 transition-all flex flex-col items-center">
                            <img src="{{ asset('images/icons/portion.png') }}" class="w-5 h-5 object-contain mb-1"
                                alt="Porsi">
                            <span
                                class="text-[10px] text-stone-400 font-semibold block uppercase tracking-wider">Porsi</span>
                            <span class="text-xs font-bold text-stone-200 mt-0.5"
                                id="base-servings-display">{{ $recipe->servings }} Porsi</span>
                        </div>

                        <div
                            class="bg-stone-950/60 border border-stone-800 p-3 rounded-2xl text-center hover:border-orange-500/50 transition-all flex flex-col items-center">
                            <img src="{{ asset('images/icons/star.png') }}" class="w-5 h-5 object-contain mb-1"
                                alt="Tingkat Kesulitan">
                            <span
                                class="text-[10px] text-stone-400 font-semibold block uppercase tracking-wider">Tingkat</span>
                            <span class="text-xs font-bold text-orange-300 mt-0.5">{{ $recipe->difficulty }}</span>
                        </div>

                        <!-- KOTAK STATISTIK DILIHAT -->
                        <div
                            class="bg-stone-900/60 backdrop-blur-md border border-stone-800/80 rounded-2xl p-4 text-center flex flex-col items-center justify-center shadow-lg">
                            <div class="w-6 h-6 mb-1 flex items-center justify-center">
                                <img src="{{ asset('images/icons/views.png') }}" alt="Dilihat"
                                    class="w-full h-full object-contain">
                            </div>
                            <span class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">DILIHAT</span>
                            <span class="text-sm font-extrabold text-orange-400 mt-0.5">{{ $recipe->views ?? 0 }}
                                Kali</span>
                        </div>
                    </div>

                    <!-- TOMBOL AKSI METODE LENGKAP -->
                    <div class="pt-2 no-print space-y-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <button onclick="window.print()"
                                class="px-4 py-2.5 bg-stone-800 hover:bg-stone-700 text-stone-200 rounded-xl text-xs font-bold transition-all border border-stone-700 flex items-center gap-2 cursor-pointer">
                                <img src="{{ asset('images/icons/printer.png') }}" class="w-4 h-4 object-contain"
                                    alt="Cetak">
                                <span>Cetak Resep</span>
                            </button>

                            @auth
                                <form action="{{ route('favorites.toggle', $recipe->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="px-4 py-2.5 bg-rose-950/60 hover:bg-rose-900 text-rose-300 border border-rose-800/50 rounded-xl text-xs font-bold transition-all flex items-center gap-2 cursor-pointer">
                                        <img src="{{ asset('images/icons/heart.png') }}" class="w-4 h-4 object-contain"
                                            alt="Favorit">
                                        <span>Simpan Favorit</span>
                                    </button>
                                </form>

                                @if (Auth::user()->role === 'admin' || Auth::id() === $recipe->user_id)
                                    <a href="{{ route('recipes.edit', $recipe->id) }}"
                                        class="px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-lg">
                                        <img src="{{ asset('images/icons/edit.png') }}" alt="Edit"
                                            class="w-4 h-4 object-contain">
                                        <span>Edit Resep</span>
                                    </a>

                                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus resep ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-lg cursor-pointer">
                                            <img src="{{ asset('images/icons/delete.png') }}" alt="Hapus"
                                                class="w-4 h-4 object-contain">
                                            <span>Hapus Resep</span>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                        <!-- KOTAK BAGIKAN SOSIAL MEDIA -->
                        <div class="bg-stone-950/80 border border-stone-800 p-4 rounded-2xl space-y-3 shadow-inner">
                            <span class="text-[11px] font-extrabold text-orange-400 uppercase tracking-widest block">
                                🚀 Bagikan Resep:
                            </span>

                            @php
                                $shareUrl = urlencode(url()->current());
                                $shareText = urlencode('Yuk cobain resep ' . $recipe->title . ' di SajiRasa!');
                            @endphp

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}"
                                    target="_blank"
                                    class="flex items-center justify-center gap-2 px-4 py-2.5 bg-emerald-950/80 hover:bg-emerald-600 border border-emerald-800/80 text-emerald-300 hover:text-white rounded-xl text-xs font-bold transition-all shadow-md">
                                    <img src="{{ asset('images/icons/whatsapp.png') }}" alt="WhatsApp"
                                        class="w-4 h-4 object-contain">
                                    WhatsApp
                                </a>

                                <button onclick="copyToClipboard('{{ url()->current() }}')"
                                    class="flex items-center justify-center gap-2 px-4 py-2.5 bg-pink-950/80 hover:bg-pink-600 border border-pink-800/80 text-pink-300 hover:text-white rounded-xl text-xs font-bold transition-all shadow-md cursor-pointer">
                                    <img src="{{ asset('images/icons/instagram.png') }}" alt="Instagram"
                                        class="w-4 h-4 object-contain">
                                    Instagram
                                </button>

                                <a href="https://pinterest.com/pin/create/button/?url={{ $shareUrl }}&media={{ urlencode($finalImageUrl) }}&description={{ $shareText }}"
                                    target="_blank"
                                    class="flex items-center justify-center gap-2 px-4 py-2.5 bg-rose-950/80 hover:bg-rose-600 border border-rose-800/80 text-rose-300 hover:text-white rounded-xl text-xs font-bold transition-all shadow-md">
                                    <img src="{{ asset('images/icons/pinterest.png') }}" alt="Pinterest"
                                        class="w-4 h-4 object-contain">
                                    Pinterest
                                </a>

                                <button onclick="copyToClipboard('{{ url()->current() }}')"
                                    class="flex items-center justify-center gap-2 px-4 py-2.5 bg-orange-600/30 hover:bg-orange-600 border border-orange-500/60 text-orange-300 hover:text-white rounded-xl text-xs font-bold transition-all shadow-lg glow-hover cursor-pointer">
                                    <span>🔗</span>
                                    Salin Link
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- 2. KONTEN DUA KOLOM -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- KOLOM KIRI: KALKULATOR & BAHAN -->
            <div class="lg:col-span-5 space-y-6">

                <!-- KALKULATOR PORSI -->
                <div
                    class="bg-stone-900/70 backdrop-blur-xl border border-orange-500/30 rounded-3xl p-6 shadow-2xl print-card">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-sm font-extrabold text-stone-100 flex items-center gap-2">🧮 Kalkulator
                                Porsi</h3>
                            <p class="text-[11px] text-stone-400 mt-0.5">Ubah porsi, takaran bahan otomatis
                                menyesuaikan.</p>
                        </div>
                        <span
                            class="text-xs font-bold px-2.5 py-1 bg-orange-950 text-orange-300 border border-orange-800/50 rounded-lg">Live</span>
                    </div>

                    <div
                        class="bg-stone-950/80 border border-stone-800 rounded-2xl p-4 flex items-center justify-between mb-4">
                        <span class="text-xs font-bold text-stone-300">Jumlah Porsi:</span>
                        <div class="flex items-center gap-3 no-print">
                            <button type="button" id="btn-min"
                                class="w-9 h-9 bg-stone-800 hover:bg-orange-600 text-white font-extrabold rounded-xl transition-all flex items-center justify-center active:scale-95 text-base border border-stone-700 cursor-pointer">−</button>
                            <span id="current-servings"
                                class="text-xl font-black text-orange-400 w-8 text-center transition-all duration-200">{{ max(1, (int) $recipe->servings) }}</span>
                            <button type="button" id="btn-plus"
                                class="w-9 h-9 bg-stone-800 hover:bg-orange-600 text-white font-extrabold rounded-xl transition-all flex items-center justify-center active:scale-95 text-base border border-stone-700 cursor-pointer">+</button>
                        </div>
                    </div>
                </div>

                <!-- DAFTAR BAHAN -->
                <div
                    class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 shadow-2xl print-card">
                    <h3
                        class="text-base font-extrabold text-stone-100 mb-4 pb-3 border-b border-stone-800 flex items-center gap-2">
                        🛒 Bahan-Bahan Masakan
                    </h3>
                    <ul class="space-y-3">
                        @php
                            $rawIngredients = $recipe->ingredients;
                            if (is_string($rawIngredients) && str_starts_with(trim($rawIngredients), '[')) {
                                $decoded = json_decode($rawIngredients, true);
                                $ingredientsList = is_array($decoded) ? $decoded : explode("\n", $rawIngredients);
                            } else {
                                $ingredientsList = explode("\n", str_replace("\r", '', $rawIngredients));
                            }
                        @endphp

                        @foreach ($ingredientsList as $item)
                            @php
                                // Membersihkan sisa format array JSON/tanda kutip yang tersisa
                                $cleanedItem = trim(str_replace(['["', '"]', '","', '"', '[\'', '\']'], '', $item));
                            @endphp

                            @if ($cleanedItem != '')
                                <li
                                    class="flex items-start gap-3 p-2.5 rounded-xl hover:bg-stone-800/40 transition-colors">
                                    <input type="checkbox"
                                        class="mt-1 w-4 h-4 accent-orange-600 bg-stone-950 border-stone-700 rounded cursor-pointer no-print">
                                    <span class="text-xs sm:text-sm text-stone-200 leading-relaxed">
                                        {!! preg_replace_callback(
                                            '/(\d+[\.,]?\d*)/',
                                            function ($matches) {
                                                $val = str_replace(',', '.', $matches[0]);
                                                return '<span class="ingredient-amount font-extrabold text-orange-400 transition-all duration-300 inline-block" data-base="' .
                                                    $val .
                                                    '">' .
                                                    $matches[0] .
                                                    '</span>';
                                            },
                                            e($cleanedItem),
                                        ) !!}
                                    </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                </div>

                <!-- KOLOM KANAN: LANGKAH MEMASAK -->
                <div class="lg:col-span-7">
                    <div
                        class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 sm:p-8 shadow-2xl print-card">
                        <h3
                            class="text-base font-extrabold text-stone-100 mb-6 pb-3 border-b border-stone-800 flex items-center gap-2">
                            👨‍🍳 Langkah Demi Langkah Memasak
                        </h3>

                        <div class="space-y-6">
                            @php
                                $rawSteps = $recipe->steps ?? ($recipe->instructions ?? '');
                                if (is_string($rawSteps) && str_starts_with(trim($rawSteps), '[')) {
                                    $decodedSteps = json_decode($rawSteps, true);
                                    $stepsList = is_array($decodedSteps) ? $decodedSteps : explode("\n", $rawSteps);
                                } else {
                                    $stepsList = explode("\n", str_replace("\r", '', $rawSteps));
                                }
                                $stepNum = 1;
                            @endphp

                            @foreach ($stepsList as $step)
                                @if (trim($step) != '')
                                    <div
                                        class="flex gap-4 group bg-stone-950/40 p-4 rounded-2xl border border-stone-800/60 hover:border-orange-500/40 transition-all">
                                        <div
                                            class="flex-shrink-0 w-8 h-8 rounded-xl bg-orange-950/80 border border-orange-800/60 text-orange-400 font-black text-xs flex items-center justify-center group-hover:scale-110 transition-transform">
                                            {{ $stepNum++ }}
                                        </div>
                                        <p class="text-xs sm:text-sm text-stone-200 leading-relaxed pt-1">
                                            {{ trim($step, '"[]') }}
                                        </p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <!-- 3. ULASAN & PENILAIAN PENGGUNA (Ditaruh penuh di bawah grid agar rapi) -->
            <div
                class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 sm:p-8 shadow-2xl print-card no-print mt-8">
                <h3
                    class="text-base font-extrabold text-stone-100 mb-6 pb-3 border-b border-stone-800 flex items-center gap-2">
                    💬 Ulasan & Penilaian Pengguna
                </h3>

                @auth
                    <form action="{{ route('reviews.store', $recipe->id) }}" method="POST"
                        class="mb-8 bg-stone-950/60 p-5 rounded-2xl border border-stone-800 space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Berikan Rating Bintang</label>
                            <select name="rating"
                                class="w-full sm:w-48 px-3 py-2 bg-stone-900 border border-stone-800 rounded-xl text-stone-200 text-xs font-bold focus:outline-none focus:border-orange-500">
                                <option value="5">⭐⭐⭐⭐⭐ (Sempurna)</option>
                                <option value="4">⭐⭐⭐⭐ (Lezat)</option>
                                <option value="3">⭐⭐⭐ (Cukup)</option>
                                <option value="2">⭐⭐ (Kurang)</option>
                                <option value="1">⭐ (Buruk)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Tulis Komentar / Pengalaman
                                Memasak</label>
                            <textarea name="comment" rows="3" required
                                placeholder="Bagikan kesan atau tips tambahan setelah mencoba resep ini..."
                                class="w-full p-3 bg-stone-900 border border-stone-800 rounded-xl text-stone-200 text-xs focus:outline-none focus:border-orange-500"></textarea>
                        </div>
                        <button type="submit"
                            class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white font-bold text-xs rounded-xl shadow-md transition-all cursor-pointer">
                            Kirim Ulasan
                        </button>
                    </form>
                @else
                    <div
                        class="mb-8 p-4 bg-stone-950/60 border border-stone-800 rounded-2xl text-center text-xs text-stone-400">
                        Silakan <a href="{{ route('login') }}" class="text-orange-400 font-bold underline">masuk</a>
                        untuk ikut memberikan ulasan dan rating pada resep ini.
                    </div>
                @endauth

                <div class="space-y-4">
                    @if (isset($recipe->reviews) && count($recipe->reviews) > 0)
                        @foreach ($recipe->reviews as $review)
                            <div class="bg-stone-950/40 border border-stone-800/80 p-4 rounded-2xl space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-stone-200">👤
                                        {{ optional($review->user)->name ?? 'Pengguna' }}</span>
                                    <span class="text-xs text-orange-400 font-extrabold flex items-center gap-1">
                                        <img src="{{ asset('images/icons/star.png') }}"
                                            class="w-3.5 h-3.5 object-contain" alt="Rating">
                                        {{ $review->rating }}/5
                                    </span>
                                </div>
                                <p class="text-xs text-stone-300 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-xs text-stone-500 text-center py-4">Belum ada ulasan untuk resep ini. Jadilah
                            yang pertama memberikan ulasan!</p>
                    @endif
                </div>
            </div>

    </main>

    <!-- FOOTER -->
    <footer
        class="relative z-10 bg-stone-950/90 backdrop-blur-md text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs no-print">
        <p>© 2026 SajiRasa — Dapur Rumahan</p>
    </footer>

    <!-- SCRIPT JAVASCRIPT -->
    <script>
        function removeSkeleton(skeletonId, imgElement) {
            const skeleton = document.getElementById(skeletonId);
            if (skeleton) {
                skeleton.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => {
                    if (skeleton.parentNode) skeleton.parentNode.removeChild(skeleton);
                }, 500);
            }
            if (imgElement) {
                imgElement.classList.remove('opacity-0');
                imgElement.classList.add('opacity-100');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const baseServingsValue = {{ max(1, (int) $recipe->servings) }};
            let currentServingsCount = baseServingsValue;

            const servingsDisplay = document.getElementById('current-servings');
            const baseServingsDisplay = document.getElementById('base-servings-display');
            const btnMin = document.getElementById('btn-min');
            const btnPlus = document.getElementById('btn-plus');

            if (btnMin && btnPlus) {
                function updateIngredientsList() {
                    if (servingsDisplay) servingsDisplay.innerText = currentServingsCount;
                    if (baseServingsDisplay) baseServingsDisplay.innerText = currentServingsCount + ' Porsi';

                    document.querySelectorAll('.ingredient-amount').forEach(el => {
                        const baseVal = parseFloat(el.getAttribute('data-base'));
                        if (!isNaN(baseVal)) {
                            let newVal = (baseVal * currentServingsCount) / baseServingsValue;
                            el.innerText = Number.isInteger(newVal) ? newVal : newVal.toFixed(1).replace(
                                '.0', '');
                        }
                    });
                }

                btnMin.addEventListener('click', () => {
                    if (currentServingsCount > 1) {
                        currentServingsCount--;
                        updateIngredientsList();
                    }
                });

                btnPlus.addEventListener('click', () => {
                    if (currentServingsCount < 50) {
                        currentServingsCount++;
                        updateIngredientsList();
                    }
                });
            }
        });

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('toast-notification');
                if (toast) {
                    toast.classList.remove('translate-x-full', 'opacity-0');
                    toast.classList.add('translate-x-0', 'opacity-100');
                    setTimeout(() => {
                        toast.classList.remove('translate-x-0', 'opacity-100');
                        toast.classList.add('translate-x-full', 'opacity-0');
                    }, 3000);
                }
            });
        }
    </script>

</body>

</html>
