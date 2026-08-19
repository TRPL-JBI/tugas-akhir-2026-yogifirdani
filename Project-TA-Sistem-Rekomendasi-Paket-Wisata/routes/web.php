<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KelolaPackageController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RecommendationController;

// Root: redirect ke /id/ secara default
Route::get('/', function () {
    return redirect('/id');
});

// Redirect rute publik tanpa prefix ke /id/... agar tidak 404
Route::middleware('web')->group(function () {
    $legacyRoutes = ['about', 'contact', 'recommendation', 'login', 'register', 'profile'];
    foreach ($legacyRoutes as $r) {
        Route::get('/' . $r, function() use ($r) {
            return redirect('/id/' . $r);
        });
    }

    // Handle nested legacy routes
    Route::get('/paket-wisata/{any?}', function($any = null) {
        return redirect('/id/paket-wisata' . ($any ? '/' . $any : '') . (request()->getQueryString() ? '?' . request()->getQueryString() : ''));
    })->where('any', '.*');

    Route::get('/article/{any?}', function($any = null) {
        return redirect('/id/article' . ($any ? '/' . $any : '') . (request()->getQueryString() ? '?' . request()->getQueryString() : ''));
    })->where('any', '.*');
});

// Language Switch Route (Session-based, mainly for admin or fallback)
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// ─── Semua Public Route dengan locale prefix ───────────────────────────────
Route::prefix('{locale}')
    ->where(['locale' => 'id|en'])
    ->group(function () {

        Route::get('/', [TourController::class, 'home'])->name('home');
        Route::get('/paket-wisata', [TourController::class, 'index'])->name('paket-wisata');
        Route::get('/paket-wisata/{slug}', [TourController::class, 'show'])->name('paket-wisata.show');

        Route::get('/about', function () {
            return view('about');
        })->name('about');

        Route::get('/article', [BlogController::class, 'index'])->name('article');
        Route::get('/article/{slug}', [BlogController::class, 'show'])->name('article.show');

        Route::get('/contact', function () {
            return view('contact');
        })->name('contact');
        Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

        Route::get('/recommendation', [RecommendationController::class, 'index'])->name('recommendation');
        Route::post('/recommendation', [RecommendationController::class, 'getRecommendations'])->name('recommendation.post');

        // Authentication Routes (Guest Only)
        Route::middleware('guest')->group(function () {
            Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
            Route::post('/login', [AuthController::class, 'login']);
            Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
            Route::post('/register', [AuthController::class, 'register']);
        });

        // Authenticated User Routes
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
            Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::delete('/booking/{booking}/cancel', [ProfileController::class, 'cancelBooking'])->name('booking.cancel');

            // Checkout & Payment Routes
            Route::get('/paket-wisata/{slug}/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
            Route::get('/checkout/payment/{booking}', [CheckoutController::class, 'payment'])->name('checkout.payment');
            Route::get('/checkout/success/{booking}', [CheckoutController::class, 'success'])->name('checkout.success');
            Route::get('/checkout/invoice/{booking}', [CheckoutController::class, 'invoice'])->name('checkout.invoice');
        });
    });

// ─── Admin Routes (Tanpa Locale Prefix) ───────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/kelola-paket-wisata', KelolaPackageController::class)->parameters(['kelola-paket-wisata' => 'kelolaPackage']);
    Route::resource('/kelola-artikel', ArticleController::class)->parameters(['kelola-artikel' => 'kelolaArtikel']);
    Route::get('/kelola-pemesanan', [BookingController::class, 'index'])->name('kelola-pemesanan.index');
    Route::get('/kelola-pemesanan/{booking}', [BookingController::class, 'show'])->name('kelola-pemesanan.show');
    Route::delete('/kelola-pemesanan/{booking}', [BookingController::class, 'destroy'])->name('kelola-pemesanan.destroy');
    Route::patch('/kelola-pemesanan/{booking}/status', [BookingController::class, 'updateStatus'])->name('kelola-pemesanan.update-status');
    Route::get('/kelola-user', [UserController::class, 'index'])->name('user-profile.index');
    Route::get('/kelola-user/{user}', [UserController::class, 'show'])->name('user-profile.show');
    Route::get('/kelola-user/{user}/edit', [UserController::class, 'edit'])->name('user-profile.edit');
    Route::put('/kelola-user/{user}', [UserController::class, 'update'])->name('user-profile.update');
    Route::delete('/kelola-user/{user}', [UserController::class, 'destroy'])->name('user-profile.destroy');
    Route::get('/saran-wisatawan', [\App\Http\Controllers\Admin\SuggestionController::class, 'index'])->name('saran-wisatawan.index');
    Route::delete('/saran-wisatawan/{suggestion}', [\App\Http\Controllers\Admin\SuggestionController::class, 'destroy'])->name('saran-wisatawan.destroy');
});
