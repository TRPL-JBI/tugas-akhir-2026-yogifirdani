<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TourPackage;
use App\Models\Destination;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count(); //mengambil total semua wisatawan
        $totalPackages = TourPackage::count(); // mengambil total semua paket
        $totalDestinations = Destination::count(); // mengambil total semua destinasi
        $totalBookings = Booking::whereYear('booking_date', now()->year)->count(); // mengambil total semua booking tahun ini

        // Mengambil statistik booking berdasarkan bulan untuk tahun ini
        $bookingsPerMonth = Booking::select(
            DB::raw('MONTH(booking_date) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('booking_date', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('count', 'month')
        ->toArray();

        // Standard 12-month array (Jan - Dec)
        $monthlyBookings = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyBookings[] = $bookingsPerMonth[$m] ?? 0;
        }

        // Mengambil statistik pendapatan (uang masuk) per bulan untuk tahun ini
        $revenuesPerMonth = Booking::select(
            DB::raw('MONTH(booking_date) as month'),
            DB::raw('SUM(total_price) as total')
        )
        ->where('payment_status', 'paid')
        ->whereYear('booking_date', now()->year)
        ->groupBy('month')
        ->get()
        ->pluck('total', 'month')
        ->toArray();

        // Standard 12-month array (Jan - Dec)
        $monthlyRevenues = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyRevenues[$m] = (float)($revenuesPerMonth[$m] ?? 0);
        }

        $totalRevenueAllTime = Booking::where('payment_status', 'paid')->sum('total_price');

        return view('admin.dashboard', compact(
            'totalUsers', 
            'totalPackages', 
            'totalDestinations', 
            'totalBookings', 
            'monthlyBookings',
            'monthlyRevenues',
            'totalRevenueAllTime'
        ));
    }
}
