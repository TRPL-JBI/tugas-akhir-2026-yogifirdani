<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\PackageType;

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

        if (config('app.env') !== 'local') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        View::composer('partials.navbar', function ($view) {
            $view->with('globalPackageTypes', PackageType::all());
        });

        View::composer(['home', 'about'], function ($view) {
            $view->with([
                'totalPackages' => \App\Models\TourPackage::count(),
                'totalDestinations' => \App\Models\Destination::where('is_active', true)->count(),
                'totalUsers' => \App\Models\User::count(),
            ]);
        });

        // Konfigurasi Global Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is3ds');
    }
}
