<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Favorit Saya — SajiRasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px) rotate(0deg); filter: drop-shadow(0 10px 20px rgba(249, 115, 22, 0.4)); }
            50% { transform: translateY(-8px) rotate(1.5deg); filter: drop-shadow(0 20px 25px rgba(249, 115, 22, 0.6)); }
        }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.18); opacity: 0.85; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-float-logo { animation: floatLogo 4s ease-in-out infinite; }
        .animate-pulse-glow { animation: pulseGlow 5s ease-in-out infinite; }
        .animate-fade-in-up { animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen flex flex-col justify-between relative antialiased selection:bg-orange-500 selection:text-stone-950 overflow-x-hidden">

    <!-- BACKGROUND SUSHI PERMANEN LEBIH TERANG & BERCAHAYA -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-stone-950">
        <img src="{{ asset('images/bg-sushi.jpg') }}" alt="Background Kuliner SajiRasa"
            class="w-full h-full object-cover object-right-top scale-105 filter brightness-110 contrast-105 opacity-85 absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-tr from-stone-950/80 via-stone-950/50 to-orange-950/30"></div>
    </div>

    <!-- HEADER NAVBAR (CERAH & ELEGAN) -->
    <header class="bg-stone-900/85 backdrop-blur-2xl border-b border-orange-500/20 sticky top-0 z-50 shadow-2xl shadow-orange-950/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer shrink-0 group">
                <div class="w-12 h-12 rounded-2xl overflow-hidden bg-gradient-to-br from-white to-orange-50 p-1.5 border-2 border-orange-500/60 shadow-xl flex items-center justify-center shrink-0 animate-float-logo">
                    <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xl font-black tracking-tight text-white leading-none group-hover:text-orange-400 transition-colors">SajiRasa</span>
                    <span class="text-[10px] font-extrabold tracking-widest text-orange-400 uppercase mt-1">Dapur Rumahan</span>
                </div>
            </a>
            <a href="{{ url('/') }}" class="px-5 py-2.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-orange-600/30 border border-orange-400/40 flex items-center gap-2 transform hover:-translate-y-0.5">
                <span>←</span> Katalog Resep
            </a>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1 w-full relative z-10">

        <!-- GLOWING AMBIENT LIGHT YANG LEBIH HIDUP -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[600px] h-60 bg-gradient-to-r from-orange-500/20 to-amber-500/20 rounded-full blur-[100px] pointer-events-none animate-pulse-glow"></div>

        <div class="mb-10 animate-fade-in-up text-center sm:text-left">
            <h2 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white flex items-center justify-center sm:justify-start gap-3">
                Resep Favorit Saya <span class="text-rose-500 drop-shadow-[0_0_15px_rgba(244,63,94,0.6)]">❤️</span>
            </h2>
            <p class="text-stone-300 text-sm sm:text-base mt-2">Daftar masakan pilihan terbaik yang Anda simpan untuk dimasak spesial hari ini.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-950/90 border border-emerald-500/40 text-emerald-300 text-xs rounded-2xl font-semibold shadow-xl backdrop-blur-xl tracking-wide flex items-center justify-between animate-fade-in-up">
                <span class="flex items-center gap-2">✨ {{ session('success') }}</span>
                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest bg-emerald-900/60 px-3 py-1 rounded-xl border border-emerald-500/30">Sukses</span>
            </div>
        @endif

        @if ($favorites->isEmpty())
            <div class="bg-stone-900/85 backdrop-blur-2xl border border-orange-500/30 rounded-3xl p-12 text-center space-y-5 shadow-2xl animate-fade-in-up max-w-lg mx-auto">
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500/30 to-amber-500/20 border border-orange-500/40 rounded-3xl flex items-center justify-center mx-auto text-3xl shadow-lg shadow-orange-500/10">📌</div>
                <h3 class="text-2xl font-extrabold text-white">Belum ada resep favorit</h3>
                <p class="text-stone-300 text-sm max-w-sm mx-auto leading-relaxed">Jelajahi katalog masakan lezat kami dan tekan tombol favorit pada resep yang paling Anda sukai!</p>
                <a href="{{ url('/') }}" class="inline-block px-7 py-3.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white font-extrabold text-xs tracking-wide rounded-2xl transition shadow-xl shadow-orange-600/40 transform hover:-translate-y-1">
                    Jelajahi Resep Sekarang 🍳
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 animate-fade-in-up">
                @foreach ($favorites as $fav)
                    @php
                        $recipe = $fav->recipe;
                        if(!$recipe) continue;
                        $imgSource = $recipe->image;
                        $finalImageUrl = filter_var($imgSource, FILTER_VALIDATE_URL) ? $imgSource : asset('storage/' . $imgSource);
                    @endphp
                    <!-- CARD DENGAN EFEK HOVER MENYALA & GLASSMORPHISM -->
                    <div class="group relative bg-stone-900/80 backdrop-blur-2xl border border-stone-800/90 hover:border-orange-500/60 rounded-3xl p-4 hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl hover:shadow-orange-500/20 flex flex-col justify-between">
                        <div>
                            <!-- KONTAINER GAMBAR DENGAN ZOOM EFEK -->
                            <div class="relative mb-4 overflow-hidden rounded-2xl shadow-lg border border-stone-700/60 bg-stone-900 h-44 w-full">
                                <img src="{{ $finalImageUrl }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-stone-950/60 via-transparent to-transparent opacity-60"></div>
                                @if(optional($recipe->category)->name)
                                    <span class="absolute top-3 left-3 px-3 py-1 bg-stone-950/90 backdrop-blur-md rounded-xl text-[11px] font-extrabold text-orange-300 border border-orange-500/30 shadow-lg z-20">
                                        {{ $recipe->category->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- INFORMASI RESEP -->
                            <div class="flex items-center justify-between text-xs font-bold text-stone-300 mb-2.5 px-1">
                                <span class="flex items-center gap-1.5 bg-stone-800/80 px-2.5 py-1 rounded-lg border border-stone-700/50">⏱️ {{ $recipe->cooking_time }} Mnt</span>
                                <span class="flex items-center gap-1.5 bg-stone-800/80 px-2.5 py-1 rounded-lg border border-stone-700/50">🍽️ {{ $recipe->servings }} Porsi</span>
                                <span class="text-amber-400 bg-amber-950/40 px-2.5 py-1 rounded-lg border border-amber-500/30">⭐ {{ $recipe->difficulty }}</span>
                            </div>

                            <h3 class="text-base font-extrabold text-white group-hover:text-orange-400 transition-colors mb-1.5 line-clamp-1 px-1">
                                {{ $recipe->title }}
                            </h3>
                            <p class="text-stone-300 text-xs line-clamp-2 mb-4 leading-relaxed px-1">
                                {{ $recipe->description }}
                            </p>
                        </div>

                        <!-- TOMBOL AKSI DENGAN EFEK GLOW INTERAKTIF -->
                        <div class="flex items-center gap-2 pt-3 border-t border-stone-800/80">
                            <a href="{{ route('recipes.show', $recipe->id) }}" class="flex-1 text-center py-2.5 bg-stone-800 hover:bg-orange-600 text-stone-200 hover:text-white rounded-xl font-bold text-xs transition-all shadow-md border border-stone-700/60">
                                Lihat Detail
                            </a>
                            <form action="{{ route('favorites.toggle', $recipe->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2.5 bg-rose-950/80 hover:bg-rose-900 text-rose-300 rounded-xl border border-rose-800/60 transition-all shadow-md transform hover:scale-110 active:scale-95 flex items-center justify-center cursor-pointer" title="Hapus dari Favorit">
                                    <img src="{{ asset('images/icons/heart.png') }}" alt="Hapus" class="w-4 h-4 object-contain filter brightness-125">
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 bg-stone-950/95 backdrop-blur-xl text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs font-semibold">
        <p>© 2026 SajiRasa — Dapur Rumahan. Seluruh Hak Cipta Dilindungi.</p>
    </footer>

</body>
</html>
