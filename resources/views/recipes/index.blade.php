<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SajiRasa — Dapur Rumahan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* VIEW TRANSITIONS API UNTUK PERPINDAHAN HALAMAN MULUS TANPA BLACKSCREEN */
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
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px) rotate(0deg); filter: drop-shadow(0 10px 20px rgba(249, 115, 22, 0.4)); }
            50% { transform: translateY(-6px) rotate(1.5deg); filter: drop-shadow(0 15px 25px rgba(249, 115, 22, 0.6)); }
        }

        .animate-float-logo {
            animation: floatLogo 4s ease-in-out infinite;
        }

        @keyframes ultraShimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .shimmer-loader-ultra {
            background: linear-gradient(90deg, #1c1917 20%, #3b82f6 50%, #1c1917 80%);
            background-size: 250% 100%;
            animation: ultraShimmer 1.2s infinite linear;
        }
    </style>
</head>

<body
    class="bg-stone-950 text-stone-100 min-h-screen flex flex-col justify-between relative antialiased selection:bg-orange-500 selection:text-stone-950">

    <!-- BACKGROUND SUSHI PERMANEN -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-stone-950">
        <img src="{{ asset('images/bg-sushi.jpg') }}" alt="Background Kuliner SajiRasa"
            class="w-full h-full object-cover object-right-top scale-105 filter blur-[0.5px] opacity-90 absolute inset-0">
        <div class="absolute inset-0 bg-stone-950/20"></div>
    </div>

    <!-- NAVBAR UTAMA -->
    <header class="bg-stone-900/70 backdrop-blur-md border-b border-stone-800/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- LOGO SAJIRASA DENGAN ANIMASI MELAYANG -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer shrink-0 group">
                <div
                    class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl overflow-hidden bg-gradient-to-br from-white to-orange-50 p-1.5 border-2 border-orange-500/60 shadow-xl flex items-center justify-center shrink-0 animate-float-logo">
                    <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa"
                        class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col justify-center">
                    <span
                        class="text-lg sm:text-xl font-black tracking-tight text-stone-100 leading-none group-hover:text-orange-400 transition-colors">SajiRasa</span>
                    <span
                        class="text-[9px] sm:text-[10px] font-bold tracking-widest text-orange-400 uppercase mt-1">Dapur
                        Rumahan</span>
                </div>
            </a>

            <!-- OTENTIKASI & MENU NAVBAR -->
            <div class="flex items-center gap-3">
                @auth
                    @if (in_array(Auth::user()->role, ['admin', 'penambah_resep']))
                        <a href="{{ route('recipes.my-recipes') }}"
                            class="hidden md:flex items-center gap-2 px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-200 rounded-xl text-xs font-bold transition-all border border-stone-700 shadow-sm">
                            <img src="{{ asset('images/icons/recipe.png') }}" alt="Resep Saya"
                                class="w-4 h-4 object-contain">
                            <span>Resep Saya</span>
                        </a>

                        <a href="{{ route('recipes.create') }}"
                            class="hidden md:flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                            <img src="{{ asset('images/icons/foods.png') }}" alt="Kirim Resep"
                                class="w-4 h-4 object-contain">
                            <span>Kirim Resep</span>
                        </a>
                    @endif

                    <!-- MENU FAVORIT SAYA DI NAVBAR -->
                    <a href="{{ route('favorites.index') }}"
                        class="hidden sm:flex items-center gap-1.5 px-3.5 py-2 bg-stone-800 hover:bg-stone-700 text-stone-200 rounded-xl text-xs font-bold transition-all border border-stone-700 shadow-sm">
                        <img src="{{ asset('images/icons/heart.png') }}" alt="Favorit" class="w-4 h-4 object-contain">
                        <span>Favorit</span>
                    </a>

                    <a href="{{ route('profile.index') }}"
                        class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-stone-900/80 hover:bg-stone-800 rounded-xl border border-stone-800 transition-all">
                        @if (Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                                class="w-6 h-6 rounded-full object-cover border border-orange-500/50">
                        @else
                            <div
                                class="w-6 h-6 rounded-full bg-stone-800 flex items-center justify-center border border-orange-500/50 text-[10px]">
                                👤</div>
                        @endif
                        <span class="text-xs font-bold text-stone-300">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] font-extrabold px-2 py-0.5 bg-orange-600 text-white rounded-md uppercase">
                            {{ str_replace('_', ' ', Auth::user()->role) }}
                        </span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-1.5 px-3.5 py-2 bg-stone-800 hover:bg-rose-600 hover:text-white text-stone-300 rounded-xl text-xs font-bold transition-all shadow-sm cursor-pointer">
                            <img src="{{ asset('images/icons/logout.png') }}" alt="Keluar"
                                class="w-4 h-4 object-contain">
                            <span>Keluar</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-xs font-bold text-stone-300 hover:text-orange-400 px-3 py-2 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-orange-600/20 transition-all">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full relative z-10">

        @if (session('success'))
            <div
                class="mb-8 p-4 bg-emerald-950/80 border border-emerald-500/30 text-emerald-300 text-xs rounded-2xl font-semibold shadow-lg backdrop-blur-md tracking-wide flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <span
                    class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest bg-emerald-900/50 px-2.5 py-1 rounded-lg border border-emerald-600/30">Sukses</span>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-8 p-4 bg-rose-950/80 border border-rose-500/30 text-rose-300 text-xs rounded-2xl font-semibold shadow-lg backdrop-blur-md tracking-wide flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <span
                    class="text-[10px] font-bold text-rose-400 uppercase tracking-widest bg-rose-900/50 px-2.5 py-1 rounded-lg border border-rose-600/30">Perhatian</span>
            </div>
        @endif

        <!-- HERO BANNER -->
        <div
            class="relative bg-stone-900/70 backdrop-blur-md text-white rounded-3xl overflow-hidden mb-12 shadow-2xl border border-stone-800/80 p-8 sm:p-14">
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-orange-100 mb-4">Temukan Kehangatan
                Masakan Rumahan</h1>
            <p class="text-stone-300 text-base sm:text-lg mb-8 max-w-xl">Jelajahi racikan resep lezat, hemat waktu, dan
                mudah dipraktikkan langsung di dapur Anda.</p>

            <form method="GET" action="{{ url('/') }}"
                class="flex gap-2 max-w-lg bg-stone-950/80 p-2 rounded-2xl border border-stone-800 shadow-inner">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari resep nasi goreng, sate, seblak..."
                    class="w-full px-4 py-2 bg-transparent text-white placeholder-stone-500 focus:outline-none text-sm">
                <button type="submit"
                    class="px-6 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold transition-all cursor-pointer">Cari</button>
            </form>
        </div>

        <!-- KATEGORI -->
        <div class="mb-10 flex gap-3 overflow-x-auto pb-2 scrollbar-none">
            <a href="{{ url('/') }}"
                class="flex items-center gap-2.5 px-5 py-3 rounded-2xl border font-medium text-sm whitespace-nowrap transition-all shadow-sm backdrop-blur-md {{ !request('category') ? 'bg-orange-600 text-white border-orange-600 shadow-orange-600/20' : 'bg-stone-900/60 text-stone-300 border-stone-800 hover:border-orange-500/50' }}">
                <img src="{{ asset('images/icons/all.png') }}" alt="Semua Resep" class="w-5 h-5 object-contain">
                <span>Semua Resep</span>
            </a>

            @foreach ($categories as $cat)
                @php
                    $catSlug = Str::slug($cat->name);
                    $iconFile = 'all.png';

                    if (Str::contains($catSlug, ['makanan', 'utama', 'main', 'berat'])) {
                        $iconFile = 'main-dish.png';
                    } elseif (Str::contains($catSlug, ['sarapan', 'breakfast', 'pagi'])) {
                        $iconFile = 'breakfast.png';
                    } elseif (Str::contains($catSlug, ['camilan', 'snack', 'gorengan', 'kue'])) {
                        $iconFile = 'snack.png';
                    } elseif (Str::contains($catSlug, ['minuman', 'beverage', 'segar', 'es', 'kopi'])) {
                        $iconFile = 'beverage.png';
                    }
                @endphp

                <a href="{{ url('/?category=' . $cat->id) }}"
                    class="flex items-center gap-2.5 px-5 py-3 rounded-2xl border font-medium text-sm whitespace-nowrap transition-all shadow-sm backdrop-blur-md {{ request('category') == $cat->id ? 'bg-orange-600 text-white border-orange-600 shadow-orange-600/20' : 'bg-stone-900/60 text-stone-300 border-stone-800 hover:border-orange-500/50' }}">
                    <img src="{{ asset('images/icons/' . $iconFile) }}" alt="{{ $cat->name }}"
                        class="w-5 h-5 object-contain">
                    <span>{{ $cat->name }}</span>
                </a>
            @endforeach
        </div>

        <!-- FORM FILTER -->
        <form action="{{ url('/') }}" method="GET"
            class="bg-stone-900/60 backdrop-blur-md p-4 sm:p-6 rounded-3xl border border-stone-800/80 shadow-2xl mb-8">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="sm:col-span-1">
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Cari
                        Resep</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Misal: Seblak, Nasi Goreng..."
                        class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-sm font-medium focus:outline-none focus:border-orange-500">
                </div>

                <div>
                    <label
                        class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Kategori</label>
                    <select name="category"
                        class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-sm font-medium focus:outline-none focus:border-orange-500">
                        <option value="" class="bg-stone-900">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" class="bg-stone-900"
                                {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Waktu
                        Memasak</label>
                    <select name="time"
                        class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-sm font-medium focus:outline-none focus:border-orange-500">
                        <option value="" class="bg-stone-900">Semua Durasi</option>
                        <option value="15" class="bg-stone-900" {{ request('time') == '15' ? 'selected' : '' }}>
                            Praktis (&le; 15 Menit)</option>
                        <option value="30" class="bg-stone-900" {{ request('time') == '30' ? 'selected' : '' }}>
                            Sedang (&le; 30 Menit)</option>
                        <option value="60" class="bg-stone-900" {{ request('time') == '60' ? 'selected' : '' }}>
                            Santai (&le; 1 Jam)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-stone-400 uppercase tracking-wider mb-1">Tingkat
                        Kesulitan</label>
                    <select name="difficulty"
                        class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-sm font-medium focus:outline-none focus:border-orange-500">
                        <option value="" class="bg-stone-900">Semua Tingkat</option>
                        <option value="Mudah" class="bg-stone-900"
                            {{ request('difficulty') == 'Mudah' ? 'selected' : '' }}>Mudah</option>
                        <option value="Sedang" class="bg-stone-900"
                            {{ request('difficulty') == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="Sulit" class="bg-stone-900"
                            {{ request('difficulty') == 'Sulit' ? 'selected' : '' }}>Sulit</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 mt-4 pt-3 border-t border-stone-800/80">
                @if (request()->hasAny(['search', 'category', 'time', 'difficulty']))
                    <a href="{{ url('/') }}"
                        class="px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-300 font-bold text-xs rounded-xl transition">Reset
                        Filter</a>
                @endif
                <button type="submit"
                    class="px-5 py-2 bg-orange-600 hover:bg-orange-500 text-white font-bold text-xs rounded-xl shadow-md transition cursor-pointer">Terapkan
                    Filter</button>
            </div>
        </form>

        <!-- GRID RESEP (4 KOLOM DENGAN JARAK YANG LEBIH LUAS/BERJARAK) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pt-4">
            @forelse($recipes as $recipe)
                <div
                    class="group relative bg-stone-900/60 backdrop-blur-md border border-stone-800/80 hover:border-orange-500/40 rounded-2xl p-4 hover:-translate-y-1.5 transition-all duration-300 hover:shadow-xl hover:shadow-orange-950/30 flex flex-col justify-between">
                    <div>
                        <div
                            class="relative -mt-8 mb-4 overflow-hidden rounded-xl shadow-lg border border-stone-700/50 bg-stone-900 h-40">
                            <div id="skeleton-img-{{ $recipe->id }}"
                                class="absolute inset-0 shimmer-loader-ultra flex items-center justify-center z-0">
                                <span
                                    class="text-[10px] uppercase tracking-widest text-stone-300 font-bold animate-pulse">Memuat...</span>
                            </div>

                            @php
                                $imgSource = $recipe->image;
                                $finalImageUrl = filter_var($imgSource, FILTER_VALIDATE_URL)
                                    ? $imgSource
                                    : asset('storage/' . $imgSource);
                            @endphp

                            <img src="{{ $finalImageUrl }}" alt="{{ $recipe->title }}"
                                onload="removeSkeleton('skeleton-img-{{ $recipe->id }}', this)"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-all duration-700 opacity-0 relative z-10">

                            <span
                                class="absolute top-2.5 left-2.5 px-2.5 py-0.5 bg-stone-950/80 backdrop-blur-md rounded-full text-[11px] font-bold text-orange-300 border border-stone-800 shadow-sm z-20">{{ optional($recipe->category)->name ?? 'Kategori' }}</span>
                        </div>

                        <div class="flex items-center gap-3 text-[11px] font-medium text-stone-400 mb-2">
                            <span class="flex items-center gap-1">
                                <img src="{{ asset('images/icons/time.png') }}" class="w-3.5 h-3.5 object-contain"
                                    alt="Waktu">
                                {{ $recipe->cooking_time }} Mnt
                            </span>
                            <span class="flex items-center gap-1">
                                <img src="{{ asset('images/icons/portion.png') }}" class="w-3.5 h-3.5 object-contain"
                                    alt="Porsi">
                                {{ $recipe->servings }} Porsi
                            </span>
                            <!-- VIEWS ICON MENGGUNAKAN VIEWS.PNG -->
                            <span class="flex items-center gap-1 text-stone-400 ml-auto">
                                <img src="{{ asset('images/icons/views.png') }}" class="w-3.5 h-3.5 object-contain" alt="Views">
                                {{ $recipe->views ?? 0 }}x
                            </span>
                        </div>

                        <h3
                            class="text-base font-bold text-stone-100 group-hover:text-orange-300 transition-colors mb-1.5 line-clamp-1">
                            {{ $recipe->title }}</h3>
                        <p class="text-stone-400 text-[11px] line-clamp-2 mb-3 leading-snug">
                            {{ $recipe->description }}</p>
                    </div>

                    <!-- TOMBOL AKSI (LIHAT RESEP & FAVORIT DENGAN LOGO HEART & EFEK VISUAL) -->
                    <div class="flex items-center gap-2 mt-2">
                        <a href="{{ route('recipes.show', $recipe->id) }}"
                            class="flex-1 block text-center py-2 bg-stone-800/80 hover:bg-orange-600 text-stone-200 hover:text-white rounded-lg font-semibold text-xs transition-colors shadow-sm border border-stone-700/50 cursor-pointer">Lihat
                            Resep</a>

                        @auth
                            <form action="{{ route('favorites.toggle', $recipe->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-2 bg-stone-800/80 hover:bg-stone-700 hover:border-orange-500/50 text-stone-200 rounded-lg border border-stone-700/50 transition-all duration-300 flex items-center gap-1.5 cursor-pointer shadow-md transform hover:scale-105 active:scale-95"
                                    title="Favorit">
                                    <img src="{{ asset('images/icons/heart.png') }}" alt="Heart" class="w-4 h-4 object-contain">
                                    <span class="text-xs font-bold
                                        @if(Auth::user()->favoriteRecipes && Auth::user()->favoriteRecipes->contains($recipe->id))
                                            text-orange-400
                                        @else
                                            text-stone-300
                                        @endif
                                    ">Favorit</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-3 py-2 bg-stone-800/80 hover:bg-stone-700 text-stone-300 rounded-lg border border-stone-700/50 transition-all duration-300 flex items-center gap-1.5 shadow-md transform hover:scale-105 active:scale-95"
                                title="Login untuk Favorit">
                                <img src="{{ asset('images/icons/heart.png') }}" alt="Heart" class="w-4 h-4 object-contain">
                                <span class="text-xs font-bold text-stone-300">Favorit</span>
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full text-center py-16 bg-stone-900/60 backdrop-blur-md rounded-3xl border border-stone-800 shadow-sm">
                    <h3 class="font-bold text-stone-200 text-base mb-1">Resep Tidak Ditemukan</h3>
                    <p class="text-stone-400 text-xs">Coba cari dengan kata kunci lain atau pilih kategori yang
                        berbeda.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- FOOTER -->
    <footer
        class="relative z-10 bg-stone-950/90 backdrop-blur-md text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs">
        <p>© 2026 SajiRasa — Dapur Rumahan</p>
    </footer>

    <!-- SCRIPT JAVASCRIPT -->
    <script>
        function removeSkeleton(skeletonId, imgElement) {
            const skeleton = document.getElementById(skeletonId);
            if (skeleton) {
                skeleton.remove();
            }
            if (imgElement) {
                imgElement.classList.remove('opacity-0');
                imgElement.classList.add('opacity-100');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('img[onload*="removeSkeleton"]').forEach(img => {
                if (img.complete && img.naturalHeight !== 0) {
                    const match = img.getAttribute('onload').match(/'([^']+)'/);
                    if (match && match[1]) {
                        removeSkeleton(match[1], img);
                    }
                }
            });
        });
    </script>

</body>

</html>
