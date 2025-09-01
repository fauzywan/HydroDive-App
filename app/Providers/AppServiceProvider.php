<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

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
        // Atur default locale Carbon ke bahasa Indonesia
        Carbon::setLocale('id');

        // Jika kamu ingin menggunakan translatedFormat dengan nama bulan Indonesia
        setlocale(LC_TIME, 'id_ID.utf8');

        // Optional untuk fix default string length di versi MySQL lama
        Schema::defaultStringLength(191);
    }
}
