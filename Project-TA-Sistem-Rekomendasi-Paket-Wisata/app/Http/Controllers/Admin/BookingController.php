<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Self-healing database correction: If a booking is paid full but has remaining payment, set remaining_amount to 0
        Booking::where('payment_status', 'paid')
               ->where('dp_amount', 0)
               ->where('remaining_amount', '>', 0)
               ->update(['remaining_amount' => 0]);

        $query = Booking::with('tourPackage');

        // Filter by Search Query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('tourPackage', function ($qp) use ($search) {
                      $qp->where('package_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Operational/Trip Status
        if ($request->filled('status')) {
            $status = $request->status;
            $today = now()->toDateString();
            
            if ($status === 'today') {
                $query->whereDate('trip_date', $today)
                      ->where('booking_status', 'confirmed');
            } elseif ($status === 'upcoming') {
                $query->whereDate('trip_date', '>', $today)
                      ->where('booking_status', 'confirmed');
            } elseif ($status === 'completed') {
                $query->whereDate('trip_date', '<', $today)
                      ->where('booking_status', 'confirmed');
            } elseif ($status === 'pending') {
                $query->where('booking_status', 'pending');
            } elseif ($status === 'cancelled') {
                $query->where('booking_status', 'cancelled');
            }
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.kelola_pemesanan.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        // Self-healing database correction: If a booking is paid full but has remaining payment, set remaining_amount to 0
        if ($booking->payment_status === 'paid' && $booking->dp_amount == 0 && $booking->remaining_amount > 0) {
            $booking->update(['remaining_amount' => 0]);
            $booking->refresh();
        }

        $booking->load('tourPackage');
        return view('admin.kelola_pemesanan.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        // Delete the identity document file if it exists
        if ($booking->identity_document_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($booking->identity_document_path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($booking->identity_document_path);
        }

        $booking->delete();

        return redirect()->route('admin.kelola-pemesanan.index')
            ->with('success', 'Data pemesanan berhasil dihapus.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'booking_status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update([
            'booking_status' => $request->booking_status,
        ]);

        return back()->with('success', 'Status perjalanan berhasil diperbarui.');
    }
}

