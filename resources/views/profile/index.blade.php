<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — SajiRasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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

        @keyframes floatLogo {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
                filter: drop-shadow(0 10px 20px rgba(249, 115, 22, 0.4));
            }

            50% {
                transform: translateY(-6px) rotate(1.5deg);
                filter: drop-shadow(0 15px 25px rgba(249, 115, 22, 0.6));
            }
        }

        .animate-float-logo {
            animation: floatLogo 4s ease-in-out infinite;
        }
    </style>
</head>

<body
    class="bg-stone-950 text-stone-100 min-h-screen flex flex-col justify-between relative antialiased selection:bg-orange-500 selection:text-stone-950">

    <!-- BACKGROUND SUSHI -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-stone-950">
        <img src="{{ asset('images/bg-sushi.jpg') }}" alt="Background SajiRasa"
            class="w-full h-full object-cover object-right-top scale-105 filter blur-[0.5px] opacity-90 absolute inset-0">
        <div class="absolute inset-0 bg-stone-950/40"></div>
    </div>

    <!-- NAVBAR -->
    <header
        class="bg-stone-900/85 backdrop-blur-2xl border-b border-orange-500/20 sticky top-0 z-50 shadow-2xl shadow-orange-950/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- LOGO NAVBAR SAJIRASA DENGAN UKURAN TEKS PRESISI & ANIMASI MELAYANG -->
            <!-- LOGO NAVBAR SAJIRASA -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer shrink-0 group">
                <div
                    class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl overflow-hidden bg-gradient-to-br from-white to-orange-50 p-1.5 border-2 border-orange-500/60 shadow-xl flex items-center justify-center shrink-0 animate-float-logo">
                    <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa"
                        class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col justify-center gap-0.5">
                    <span
                        class="text-lg sm:text-2xl font-extrabold tracking-tight text-white leading-none group-hover:text-orange-400 transition-colors">SajiRasa</span>
                    <span class="text-[9px] sm:text-[10px] font-bold tracking-widest text-orange-500 uppercase">DAPUR
                        RUMAHAN</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ url('/') }}"
                    class="px-4 py-2 bg-stone-800 hover:bg-stone-700 text-stone-200 rounded-xl text-xs font-bold transition-all border border-stone-700 shadow-sm">
                    ← Kembali ke Katalog
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full relative z-10 space-y-8">

        @if (session('success'))
            <div
                class="p-4 bg-emerald-950/60 border border-emerald-800/60 text-emerald-300 text-xs rounded-2xl font-medium shadow-sm backdrop-blur-md">
                ✨ {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="p-4 bg-rose-950/60 border border-rose-800/60 text-rose-300 text-xs rounded-2xl font-medium shadow-sm backdrop-blur-md">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                class="p-4 bg-rose-950/60 border border-rose-800/60 text-rose-300 text-xs rounded-2xl font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- HEADER PROFIL DENGAN FOTO -->
        <div
            class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 sm:p-8 shadow-2xl flex items-center gap-5">
            <div
                class="w-16 h-16 sm:w-20 sm:h-20 bg-orange-600/30 border-2 border-orange-500 rounded-3xl overflow-hidden flex items-center justify-center shadow-lg flex-shrink-0">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                        class="w-full h-full object-cover">
                @else
                    <span class="text-3xl font-black text-orange-400">👤</span>
                @endif
            </div>
            <div>
                <h1 class="text-xl sm:text-3xl font-black text-stone-100">{{ $user->name }}</h1>
                <p class="text-xs sm:text-sm text-stone-400 mt-1">{{ $user->email }} • <span
                        class="text-orange-400 font-bold uppercase">{{ str_replace('_', ' ', $user->role) }}</span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- KOLOM KIRI: EDIT PROFIL & FOTO & PASSWORD -->
            <div class="lg:col-span-5 space-y-6">

                <!-- FORM UBAH IDENTITAS & FOTO -->
                <div
                    class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 shadow-2xl space-y-4">
                    <h3
                        class="text-sm font-extrabold text-stone-100 pb-3 border-b border-stone-800 flex items-center gap-2">
                        <img src="{{ asset('images/icons/pen.png') }}" alt="Edit" class="w-4 h-4 object-contain">
                        <span>Ubah Informasi & Foto Profil</span>
                    </h3>

                    <form action="{{ route('profile.update-info') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-xs focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-xs focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Foto Profil Baru
                                (Opsional)</label>
                            <input type="file" name="avatar" accept="image/*"
                                class="w-full px-3 py-2 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-400 text-xs file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-orange-600 file:text-white hover:file:bg-orange-500 cursor-pointer">
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 bg-orange-600 hover:bg-orange-500 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                            Simpan Perubahan Profil
                        </button>
                    </form>
                </div>

                <!-- FORM UBAH PASSWORD -->
                <div
                    class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 shadow-2xl space-y-4">
                    <h3
                        class="text-sm font-extrabold text-stone-100 pb-3 border-b border-stone-800 flex items-center gap-2">
                        <img src="{{ asset('images/icons/padlock.png') }}" alt="Password"
                            class="w-4 h-4 object-contain">
                        <span>Ubah Kata Sandi</span>
                    </h3>

                    <form action="{{ route('profile.update-password') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" required
                                class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-xs focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Kata Sandi Baru</label>
                            <input type="password" name="new_password" required placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-xs focus:outline-none focus:border-orange-500">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-stone-300 mb-1">Konfirmasi Kata Sandi
                                Baru</label>
                            <input type="password" name="new_password_confirmation" required
                                class="w-full px-4 py-2.5 bg-stone-950/80 border border-stone-800 rounded-xl text-stone-100 text-xs focus:outline-none focus:border-orange-500">
                        </div>

                        <button type="submit"
                            class="w-full py-2.5 bg-amber-600 hover:bg-amber-500 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                            Perbarui Kata Sandi
                        </button>
                    </form>
                </div>

            </div>

            <!-- KOLOM KANAN: DAFTAR RESEP SAYA -->
            <div class="lg:col-span-7">
                <div
                    class="bg-stone-900/70 backdrop-blur-xl border border-stone-800/80 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-stone-800">
                        <h3 class="text-base font-extrabold text-stone-100 flex items-center gap-2">
                            <img src="{{ asset('images/icons/book.png') }}" alt="Resep"
                                class="w-4 h-4 object-contain">
                            <span>Resep Yang Pernah Saya Unggah</span>
                        </h3>
                        <span
                            class="text-xs font-bold px-2.5 py-1 bg-orange-950 text-orange-300 border border-orange-800/50 rounded-lg">
                            {{ count($myRecipes) }} Resep
                        </span>
                    </div>

                    <div class="space-y-4">
                        @forelse($myRecipes as $recipe)
                            <div
                                class="flex items-center gap-4 p-3 bg-stone-950/50 rounded-2xl border border-stone-800 hover:border-orange-500/40 transition-all">
                                @php
                                    $imgSource = $recipe->image;
                                    $finalImageUrl = filter_var($imgSource, FILTER_VALIDATE_URL)
                                        ? $imgSource
                                        : asset('storage/' . $imgSource);
                                @endphp
                                <img src="{{ $finalImageUrl }}" alt="{{ $recipe->title }}"
                                    class="w-16 h-16 rounded-xl object-cover border border-stone-700">

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-xs sm:text-sm font-bold text-stone-100 truncate">
                                        {{ $recipe->title }}</h4>
                                    <p class="text-[11px] text-stone-400 mt-0.5">⏱️ {{ $recipe->cooking_time }} Mnt •
                                        👁️ {{ $recipe->views ?? 0 }} Views</p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('recipes.show', $recipe->id) }}"
                                        class="p-2 bg-stone-800 hover:bg-stone-700 text-stone-200 rounded-xl text-xs font-bold transition-all flex items-center justify-center"
                                        title="Lihat">
                                        <img src="{{ asset('images/icons/views.png') }}" alt="Lihat"
                                            class="w-4 h-4 object-contain">
                                    </a>
                                    <a href="{{ route('recipes.edit', $recipe->id) }}"
                                        class="p-2 bg-amber-600/30 hover:bg-amber-600 text-amber-300 hover:text-white rounded-xl text-xs font-bold transition-all flex items-center justify-center"
                                        title="Edit">
                                        <img src="{{ asset('images/icons/pen.png') }}" alt="Edit"
                                            class="w-4 h-4 object-contain">
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-stone-500">
                                <span class="text-3xl block mb-2">🍳</span>
                                <p class="text-xs">Kamu belum pernah mengunggah resep apa pun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- FOOTER -->
    <footer
        class="relative z-10 bg-stone-950/90 backdrop-blur-md text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs">
        <p>© 2026 SajiRasa — Dapur Rumahan</p>
    </footer>

</body>

</html>
