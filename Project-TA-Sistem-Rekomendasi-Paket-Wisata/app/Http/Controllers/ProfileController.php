<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $bookings = Booking::where('customer_email', $user->email)->latest()->get();
        
        return view('profile.show', compact('user', 'bookings'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('profile', ['locale' => app()->getLocale()])->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        
        $user->update([
            'password' => $request->password, // Note: the model cast 'hashed' will automatically hash it
        ]);

        return redirect()->route('profile', ['locale' => app()->getLocale()])->with('success', 'Password berhasil diubah.');
    }

    public function cancelBooking($bookingCode)
    {
        $user = Auth::user();
        
        $booking = Booking::where('booking_code', $bookingCode)
                          ->where('customer_email', $user->email)
                          ->firstOrFail();

        // Only allow cancelling if booking is still pending
        if ($booking->booking_status !== 'pending') {
            return back()->withErrors(['message' => __('messages.cannot_cancel_confirmed_booking')]);
        }

        $booking->delete();

        return redirect()->route('profile', ['locale' => app()->getLocale(), 'tab' => 'pesanan'])
                         ->with('success', __('messages.booking_cancelled_success'));
    }
}
