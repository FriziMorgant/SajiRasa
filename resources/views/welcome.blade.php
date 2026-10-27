<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SajiRasa — Resep Masakan Rumahan Lezat</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

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
            <!-- LOGO SAJIRASA DENGAN ANIMASI MELAYANG -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer shrink-0 group">
                <div
                    class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl overflow-hidden bg-gradient-to-br from-white to-orange-50 p-1.5 border-2 border-orange-500/60 shadow-xl flex items-center justify-center shrink-0 animate-float-logo">
                    <img src="{{ asset('images/icons/logosajirasa.png') }}" alt="Logo SajiRasa"
                        class="w-full h-full object-contain">
                </div>
                <div class="flex flex-col justify-center gap-0.5">
                    <span
                        class="text-lg sm:text-2xl font-extrabold tracking-tight text-white leading-none group-hover:text-orange-400 transition-colors">SajiRasa</span>
                    <span
                        class="text-[9px] sm:text-[10px] font-bold tracking-widest text-orange-500 uppercase">DAPUR
                        RUMAHAN</span>
                </div>
            </a>

            <div>
                <a href="{{ route('recipes.create') }}"
                    class="px-5 py-2.5 bg-orange-600 hover:bg-orange-500 text-white rounded-xl text-xs font-bold shadow-lg shadow-orange-600/20 transition-all">
                    + Kirim Resep
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full relative z-10">
        <livewire:recipe-catalog />
    </main>

    <!-- FOOTER -->
    <footer
        class="relative z-10 bg-stone-950/90 backdrop-blur-md text-stone-400 py-8 border-t border-stone-800/80 mt-20 text-center text-xs">
        <p>© 2026 SajiRasa — Dapur Rumahan</p>
    </footer>

    @livewireScripts
</body>

</html>
