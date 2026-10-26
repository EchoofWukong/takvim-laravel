<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // BÜYÜCÜ KODU 1: URL kütüphanesini içeri aldık

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
        // BÜYÜCÜ KODU 2: Tüm sistemi ve tasarımları zorla HTTPS olarak gönder!
        if (request()->server('HTTP_X_FORWARDED_PROTO') == 'https' || app()->environment('local')) {
            URL::forceScheme('https');
        }
    }
}