<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resep — {{ $recipe->title }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

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
        <img src="{{ asset('images/bg-sushi.jpg') }}" alt="Background Kuliner SajiRasa" class="w-full h-full object-cover object-right-top scale-105 filter brightness-110 contrast-105 opacity-85 absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-tr from-stone-950/85 via-stone-950/50 to-orange-950/30"></div>
    </div>

    <!-- NAVBAR UTAMA -->
    <header class="bg-stone-900/85 backdrop-blur-2xl border-b border-orange-500/20 sticky top-0 z-50 shadow-2xl shadow-orange-950/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">

            <!-- LOGO SAJIRASA DENGAN ANIMASI MELAYANG -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer shrink-0 group">
                <div class="w-12 h-12 rounded-2xl overflow-hidden bg-gradient-to-br from-white to-orange-50 p-1.5 border-2 border-orange-500/60 shadow-xl flex items-center justify-center shrink-0 animate-float-logo">
                    <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa" class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col justify-center">
                    <span class="text-xl font-black tracking-tight text-white leading-none group-hover:text-orange-400 transition-colors">SajiRasa</span>
                    <span class="text-[10px] font-extrabold tracking-widest text-orange-400 uppercase mt-1">Dapur Rumahan</span>
                </div>
            </a>

            <a href="{{ route('recipes.show', $recipe->id) }}" class="px-5 py-2.5 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-orange-600/30 border border-orange-400/40 flex items-center gap-2 transform hover:-translate-y-0.5">
                <span>←</span> Batal Edit
            </a>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1 w-full relative z-10">

        <!-- GLOWING AMBIENT LIGHT -->
        <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[500px] h-60 bg-gradient-to-r from-orange-500/20 to-amber-500/20 rounded-full blur-[100px] pointer-events-none animate-pulse-glow"></div>

        <div class="bg-stone-900/85 backdrop-blur-2xl rounded-3xl p-8 sm:p-12 border border-orange-500/30 shadow-2xl animate-fade-in-up">
            <div class="mb-8 border-b border-stone-800 pb-6 flex items-center gap-4">
                <!-- IKON KUSTOM EDIT.PNG (GANTI DARI FOTO PERTAMA) -->
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500/30 to-amber-500/20 border border-orange-500/40 rounded-2xl p-2.5 flex items-center justify-center shadow-lg shrink-0">
                    <img src="{{ asset('images/icons/edit.png') }}" alt="Edit Icon" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">Edit Resep Masakan</h1>
                    <p class="text-stone-300 text-xs sm:text-sm mt-1">Perbarui informasi resep "{{ $recipe->title }}".</p>
                </div>
            </div>

            @if($errors->any())
                <div class="mb-6 p-4 bg-rose-950/90 border border-rose-500/40 text-rose-300 text-xs rounded-2xl shadow-xl backdrop-blur-xl">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('recipes.update', $recipe->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Judul Resep</label>
                    <input type="text" name="title" value="{{ old('title', $recipe->title) }}" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Kategori Masakan</label>
                        <select name="category_id" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">
                            <option value="" class="bg-stone-900">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" class="bg-stone-900" {{ old('category_id', $recipe->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->icon ?? '' }} {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Tingkat Kesulitan</label>
                        <select name="difficulty" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">
                            <option value="Mudah" class="bg-stone-900" {{ old('difficulty', $recipe->difficulty) == 'Mudah' ? 'selected' : '' }}>Mudah</option>
                            <option value="Sedang" class="bg-stone-900" {{ old('difficulty', $recipe->difficulty) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="Sulit" class="bg-stone-900" {{ old('difficulty', $recipe->difficulty) == 'Sulit' ? 'selected' : '' }}>Sulit</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Waktu Memasak (Menit)</label>
                        <input type="number" name="cooking_time" value="{{ old('cooking_time', $recipe->cooking_time) }}" min="1" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Porsi (Orang)</label>
                        <input type="number" name="servings" value="{{ old('servings', $recipe->servings) }}" min="1" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">
                    </div>
                </div>

                <!-- PRATINJAU & DUA PILIHAN EDIT FOTO -->
                <div class="space-y-4 p-5 bg-stone-950/70 rounded-2xl border border-stone-800 shadow-inner">
                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-2 uppercase tracking-wider">Foto Masakan Saat Ini</label>
                        <div class="w-36 h-24 rounded-2xl overflow-hidden border border-stone-700/60 shadow-lg bg-stone-900 mb-3">
                            @php
                                $imgSource = $recipe->image;
                                $currentImgUrl = filter_var($imgSource, FILTER_VALIDATE_URL) ? $imgSource : asset('storage/' . $imgSource);
                            @endphp
                            <img src="{{ $currentImgUrl }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Ganti Dengan Upload Foto Baru (+)</label>
                        <input type="file" name="image_file" accept="image/*" class="w-full px-4 py-3 bg-stone-900 border border-stone-800 rounded-xl text-xs text-stone-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-orange-600 file:text-white hover:file:bg-orange-500 cursor-pointer transition-all">
                    </div>

                    <div class="relative flex py-1 items-center">
                        <div class="flex-grow border-t border-stone-800"></div>
                        <span class="flex-shrink mx-4 text-[10px] font-bold text-stone-500 uppercase tracking-widest">Atau Ubah Link URL</span>
                        <div class="flex-grow border-t border-stone-800"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Ganti Dengan Link URL Foto Baru</label>
                        <input type="url" name="image_url" value="{{ old('image_url', filter_var($recipe->image, FILTER_VALIDATE_URL) ? $recipe->image : '') }}" placeholder="https://..." class="w-full px-4 py-3.5 bg-stone-900 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 placeholder-stone-600 shadow-inner">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">{{ old('description', $recipe->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Bahan-Bahan (Tuliskan satu bahan per baris)</label>
                    <textarea name="ingredients" rows="5" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">{{ old('ingredients', is_array($recipe->ingredients) ? implode("\n", $recipe->ingredients) : $recipe->ingredients) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-300 mb-1.5 uppercase tracking-wider">Langkah Memasak (Tuliskan satu langkah per baris)</label>
                    <textarea name="steps" rows="6" required class="w-full px-4 py-3.5 bg-stone-950/90 border border-stone-800 rounded-2xl text-sm focus:outline-none focus:border-orange-500 transition-all text-stone-100 shadow-inner">{{ old('steps', is_array($recipe->steps) ? implode("\n", $recipe->steps) : $recipe->steps) }}</textarea>
                </div>

                <!-- TOMBOL SUBMIT DENGAN LOGO SUBMIT.PNG -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-500 hover:to-amber-500 text-white rounded-2xl font-extrabold text-xs tracking-wider uppercase shadow-xl shadow-orange-600/40 transition-all cursor-pointer transform hover:-translate-y-0.5 flex items-center justify-center gap-2.5">
                    <img src="{{ asset('images/icons/submit.png') }}" alt="Submit Icon" class="w-4 h-4 object-contain filter brightness-200">
                    <span>Simpan Perubahan Resep</span>
                </button>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 bg-stone-950/95 backdrop-blur-xl text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs font-semibold">
        <p>© 2026 SajiRasa — Dapur Rumahan. Seluruh Hak Cipta Dilindungi.</p>
    </footer>
</body>
</html>
