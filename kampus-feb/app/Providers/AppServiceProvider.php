<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // PERBAIKAN: Hanya paksa HTTPS jika di Production (Hosting Asli)
        // Kita HAPUS "app()->environment('local')" dari kondisi ini.
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Jika kamu butuh ngrok nanti, biarkan ngrok yang mengatur HTTPS-nya,
        // Laravel lokal tetap HTTP saja biar tidak error.

        // Composer lama kamu tetap
        View::composer('admin.layouts.app', function ($view) {
            $archives = DB::table('news')
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

            $view->with('archives', $archives);
        });
    }
}