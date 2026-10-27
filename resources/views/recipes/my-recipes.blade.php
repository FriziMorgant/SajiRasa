<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Saya — SajiRasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* VIEW TRANSITIONS API UNTUK PERPINDAHAN HALAMAN MULUS */
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

    <!-- NAVBAR -->
    <header class="bg-stone-900/70 backdrop-blur-md border-b border-stone-800/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- LOGO NAVBAR SAJIRASA DENGAN ANIMASI MELAYANG -->
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

            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}"
                    class="px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-300 rounded-xl text-xs font-bold transition-all border border-stone-700 shadow-sm">
                    ← Kembali ke Katalog
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full relative z-10">

        <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-orange-100 tracking-tight">Kelola Resep Saya</h1>
                <p class="text-stone-400 text-xs sm:text-sm mt-1">Daftar resep lezat yang telah Anda kontribusikan ke
                    SajiRasa.</p>
            </div>
            <a href="{{ route('recipes.create') }}"
                class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-orange-600/20 transition-all">
                + Kirim Resep Baru
            </a>
        </div>

        @if (session('success'))
            <div
                class="mb-8 p-4 bg-emerald-950/80 border border-emerald-500/30 text-emerald-300 text-xs rounded-2xl font-semibold shadow-lg backdrop-blur-md tracking-wide flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <span
                    class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest bg-emerald-900/50 px-2.5 py-1 rounded-lg border border-emerald-600/30">Sukses</span>
            </div>
        @endif

        <!-- GRID RESEP SAYA (UKURAN & STYLE ASLI) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($recipes as $recipe)
                <div
                    class="group relative bg-stone-900/60 backdrop-blur-md border border-stone-800/80 hover:border-orange-500/40 rounded-3xl p-5 hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl hover:shadow-orange-950/30 flex flex-col justify-between">
                    <div>
                        <!-- FOTO MAKANAN -->
                        <div
                            class="relative mb-5 overflow-hidden rounded-2xl shadow-xl border border-stone-700/50 bg-stone-950 h-52">
                            @php
                                $imgSource = $recipe->image;
                                $finalImageUrl = filter_var($imgSource, FILTER_VALIDATE_URL)
                                    ? $imgSource
                                    : asset('storage/' . $imgSource);
                            @endphp

                            <img src="{{ $finalImageUrl }}" alt="{{ $recipe->title }}"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">

                            <span
                                class="absolute top-3 left-3 px-3 py-1 bg-stone-950/80 backdrop-blur-md rounded-full text-xs font-bold text-orange-300 border border-stone-800 shadow-sm">
                                {{ optional($recipe->category)->name ?? 'Kategori' }}
                            </span>
                        </div>

                        <!-- ATRIBUT DENGAN IKON time.png DAN portion.png -->
                        <div class="flex items-center gap-3 text-xs font-medium text-stone-400 mb-2">
                            <span class="flex items-center gap-1">
                                <img src="{{ asset('images/icons/time.png') }}" class="w-4 h-4 object-contain" alt="Waktu">
                                {{ $recipe->cooking_time }} Menit
                            </span>
                            <span class="flex items-center gap-1">
                                <img src="{{ asset('images/icons/portion.png') }}" class="w-4 h-4 object-contain" alt="Porsi">
                                {{ $recipe->servings }} Porsi
                            </span>
                            <span
                                class="px-2 py-0.5 bg-orange-950/80 text-orange-300 rounded-md font-semibold border border-orange-900/50">{{ $recipe->difficulty }}</span>
                        </div>

                        <h3
                            class="text-lg font-bold text-stone-100 group-hover:text-orange-300 transition-colors mb-2 line-clamp-1">
                            {{ $recipe->title }}
                        </h3>
                        <p class="text-stone-400 text-xs line-clamp-2 mb-4">{{ $recipe->description }}</p>
                    </div>

                    <!-- TOMBOL AKSI DENGAN IKON views.png, edit.png, delete.png -->
                    <div class="grid grid-cols-3 gap-2 pt-3 border-t border-stone-800/80">
                        <a href="{{ route('recipes.show', $recipe->id) }}"
                            class="flex items-center justify-center gap-1.5 py-2 bg-stone-800/80 hover:bg-stone-700 text-stone-200 rounded-xl font-semibold text-xs transition-colors">
                            <img src="{{ asset('images/icons/views.png') }}" alt="Lihat" class="w-4 h-4 object-contain">
                            <span>Lihat</span>
                        </a>
                        <a href="{{ route('recipes.edit', $recipe->id) }}"
                            class="flex items-center justify-center gap-1.5 py-2 bg-amber-950/60 hover:bg-amber-900 text-amber-300 border border-amber-800/50 rounded-xl font-semibold text-xs transition-colors">
                            <img src="{{ asset('images/icons/edit.png') }}" alt="Edit" class="w-4 h-4 object-contain">
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus resep ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full flex items-center justify-center gap-1.5 py-2 bg-rose-950/60 hover:bg-rose-900 text-rose-300 border border-rose-800/50 rounded-xl font-semibold text-xs transition-colors">
                                <img src="{{ asset('images/icons/delete.png') }}" alt="Hapus" class="w-4 h-4 object-contain">
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-3 text-center py-16 bg-stone-900/60 backdrop-blur-md rounded-3xl border border-stone-800 shadow-sm">
                    <span class="text-4xl block mb-3">🍳</span>
                    <h3 class="font-bold text-stone-200 text-base">Anda Belum Mengunggah Resep</h3>
                    <p class="text-stone-400 text-xs mt-1">Mulai bagikan resep masakan andalan Anda ke pengguna SajiRasa
                        sekarang!</p>
                    <a href="{{ route('recipes.create') }}"
                        class="inline-block mt-4 px-5 py-2.5 bg-orange-600 text-white font-bold text-xs rounded-xl shadow-md">
                        + Kirim Resep Sekarang
                    </a>
                </div>
            @endforelse
        </div>

    </main>

    <!-- FOOTER -->
    <footer
        class="relative z-10 bg-stone-950/90 backdrop-blur-md text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs">
        <p>© 2026 SajiRasa — Dapur Rumahan</p>
    </footer>

</body>

</html>
