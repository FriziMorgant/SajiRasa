<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- 1. Tambahkan ini di bagian atas

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // <-- 2. Tambahkan baris ini agar semua asset otomatis HTTPS di Render
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
