<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SajiRasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        @keyframes floatLogo {
            0%, 100% { transform: translateY(0px) rotate(0deg); filter: drop-shadow(0 10px 15px rgba(234, 88, 12, 0.25)); }
            50% { transform: translateY(-8px) rotate(1.5deg); filter: drop-shadow(0 20px 25px rgba(234, 88, 12, 0.4)); }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.15); opacity: 0.8; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .animate-float-logo {
            animation: floatLogo 4.5s ease-in-out infinite;
        }

        .animate-float-card {
            animation: floatCard 3.5s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulseGlow 6s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-400 { animation-delay: 400ms; }
    </style>
</head>
<body class="bg-stone-950 text-stone-100 min-h-screen flex items-center justify-center p-0 m-0 relative selection:bg-orange-500 selection:text-stone-950 antialiased overflow-x-hidden">

    <!-- BACKGROUND SUSHI PERMANEN DI LUAR -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none bg-stone-950">
        <img src="{{ asset('images/bg-sushi.jpg') }}" alt="Background Kuliner SajiRasa"
            class="w-full h-full object-cover object-right-top scale-105 filter blur-[2px] opacity-60 absolute inset-0">
        <div class="absolute inset-0 bg-stone-950/75"></div>
    </div>

    <!-- MAIN CONTAINER SPLIT LAYOUT -->
    <div class="w-full min-h-screen grid grid-cols-1 lg:grid-cols-12 relative z-10 shadow-2xl">

        <!-- SISI KIRI: PANEL PUTIH / BRANDING -->
        <div class="lg:col-span-6 bg-gradient-to-br from-white via-stone-50 to-orange-50/50 text-stone-900 p-8 sm:p-12 lg:p-14 flex flex-col justify-between relative overflow-hidden shadow-2xl border-r border-stone-200">
            <!-- Ambient Glow Animated Background -->
            <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-gradient-to-tr from-orange-200/60 to-amber-100/40 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>

            <!-- Header Brand (Logo Besar & Melayang - Posisi Center) -->
            <div class="flex flex-col items-center justify-center relative z-10 animate-fade-in-right">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl overflow-hidden bg-white p-2 border-2 border-orange-500/40 shadow-xl flex items-center justify-center animate-float-logo mb-3">
                    <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa" class="w-full h-full object-contain">
                </div>
                <div class="text-center">
                    <span class="text-2xl sm:text-3xl font-black tracking-tight text-stone-900 block leading-none">SajiRasa</span>
                    <span class="text-xs font-extrabold tracking-widest text-orange-600 uppercase mt-1.5 block">Dapur Rumahan</span>
                </div>
            </div>

            <!-- Konten Tengah Panel Putih (Rata Tengah) -->
            <div class="my-auto py-6 relative z-10 max-w-lg mx-auto text-center -translate-y-4">
                <!-- Badge Atas -->
                <span class="px-4 py-1.5 bg-gradient-to-r from-orange-100 to-amber-100 text-orange-900 text-xs font-extrabold rounded-full inline-block mb-3 shadow-sm border border-orange-200/80 animate-fade-in-up opacity-0 delay-100">
                    Komunitas Koki & Pecinta Kuliner
                </span>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-stone-900 leading-tight mb-3 animate-fade-in-up opacity-0 delay-200">
                    Temukan & Bagikan Resep Favoritmu
                </h1>
                <p class="text-stone-600 text-sm sm:text-base leading-relaxed mb-6 animate-fade-in-up opacity-0 delay-300">
                    Masuk ke SajiRasa untuk mengelola resep masakan rumahan, berbagi inspirasi kuliner harian, dan ciptakan momen kelezatan bersama keluarga.
                </p>

                <!-- Elemen Pemanis: Card Fitur -->
                <div class="grid grid-cols-2 gap-3 animate-fade-in-up opacity-0 delay-400 text-left">
                    <div class="p-3.5 bg-gradient-to-br from-white via-orange-50/40 to-amber-50/60 backdrop-blur-md rounded-2xl border border-orange-200/70 shadow-md shadow-orange-950/5 animate-float-card flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 p-2 shadow-sm shadow-orange-500/30 flex items-center justify-center shrink-0">
                            <img src="{{ asset('images/icons/foods.png') }}" alt="Ratusan Resep" class="w-full h-full object-contain filter brightness-0 invert">
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-stone-900">Ratusan Resep</h4>
                            <p class="text-[10px] text-stone-500">Pilihan Nusantara</p>
                        </div>
                    </div>

                    <div class="p-3.5 bg-gradient-to-br from-white via-orange-50/40 to-amber-50/60 backdrop-blur-md rounded-2xl border border-orange-200/70 shadow-md shadow-orange-950/5 animate-float-card flex items-center gap-3" style="animation-delay: 1.5s;">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 p-2 shadow-sm shadow-orange-500/30 flex items-center justify-center shrink-0">
                            <img src="{{ asset('images/icons/iconrecipes.png') }}" alt="Mudah & Cepat" class="w-full h-full object-contain filter brightness-0 invert">
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-stone-900">Mudah & Cepat</h4>
                            <p class="text-[10px] text-stone-500">Panduan Langkah</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Panel Putih -->
            <div class="text-xs text-stone-500 relative z-10 font-semibold text-center animate-fade-in-up opacity-0 delay-400">
                © 2026 SajiRasa. Seluruh Hak Cipta Dilindungi.
            </div>
        </div>

        <!-- SISI KANAN: FORM LOGIN -->
        <div class="lg:col-span-6 bg-stone-900/90 backdrop-blur-2xl p-6 sm:p-10 lg:p-12 flex flex-col justify-center border-l border-stone-800/80 relative shadow-2xl">
            <!-- Glowing Background Effect -->
            <div class="absolute top-1/2 right-10 -translate-y-1/2 w-80 h-80 bg-orange-600/10 rounded-full blur-3xl pointer-events-none animate-pulse-glow"></div>

            <div class="max-w-md w-full mx-auto relative z-10">

                <!-- HEADER TEKS DI ATAS (RATA TENGAH) -->
                <div class="mb-5 text-center animate-fade-in-up opacity-0 delay-100">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-stone-100 tracking-tight">Masuk ke Akun</h2>
                    <p class="text-stone-400 text-xs sm:text-sm mt-1">Silakan masukkan email dan password Anda untuk melanjutkan.</p>
                </div>

                @if($errors->any())
                    <div class="mb-5 p-3.5 bg-rose-950/80 border border-rose-800/60 text-rose-300 text-xs rounded-2xl font-medium backdrop-blur-md shadow-lg animate-fade-in-up">
                        ⚠️ {{ $errors->first() }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-5 p-3.5 bg-emerald-950/80 border border-emerald-800/60 text-emerald-300 text-xs rounded-2xl font-medium backdrop-blur-md shadow-lg animate-fade-in-up">
                        ✨ {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-3.5 animate-fade-in-up opacity-0 delay-200">
                    @csrf

                    <div class="group">
                        <label class="block text-xs font-bold text-stone-300 mb-1 transition-colors group-focus-within:text-orange-400">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@domain.com"
                            class="w-full px-4 py-3 bg-stone-950 border border-stone-800 rounded-2xl text-stone-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/30 transition-all duration-300 placeholder-stone-600 shadow-inner hover:border-stone-700">
                    </div>

                    <div class="group">
                        <label class="block text-xs font-bold text-stone-300 mb-1 transition-colors group-focus-within:text-orange-400">Password</label>
                        <input type="password" name="password" minlength="8" required placeholder="Minimal 8 karakter"
                            class="w-full px-4 py-3 bg-stone-950 border border-stone-800 rounded-2xl text-stone-100 text-sm focus:outline-none focus:border-orange-500 focus:ring-2 focus:ring-orange-500/30 transition-all duration-300 placeholder-stone-600 shadow-inner hover:border-stone-700">
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-orange-600 hover:bg-orange-500 text-white rounded-2xl font-bold text-xs tracking-wide shadow-xl shadow-orange-600/30 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-orange-500/40 active:scale-95 cursor-pointer mt-1">
                        Masuk Sekarang 🚀
                    </button>
                </form>

                <p class="text-center text-xs text-stone-400 mt-6 animate-fade-in-up opacity-0 delay-300">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-orange-400 font-bold hover:underline transition-all hover:text-orange-300">Daftar sekarang</a>
                </p>

                <div class="text-center mt-4 pt-4 border-t border-stone-800/80 animate-fade-in-up opacity-0 delay-400">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-stone-400 hover:text-orange-300 transition-all hover:-translate-x-1">
                        <span>←</span> Kembali ke Halaman Utama
                    </a>
                </div>

            </div>
        </div>

    </div>

</body>
</html>
