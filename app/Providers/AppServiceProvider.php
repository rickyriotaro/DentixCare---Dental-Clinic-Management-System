<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        // Pagination pakai Bootstrap 5 (biar panah tidak jadi besar)
        Paginator::useBootstrapFive();

        // Membagikan data ke semua file blade yang ada di folder 'admin'
        View::composer('admin.*', function ($view) {
            $view->with('jumlahSelesai', 5); // nanti ganti query dari DB
            $view->with('jumlahProses', 1);
            $view->with('noAntrian', 3);
        });
    }
}
