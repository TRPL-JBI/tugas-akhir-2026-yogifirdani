<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index($slug)
    {
        $package = TourPackage::where('slug', $slug)->firstOrFail();
        
        return view('paket.checkout', compact('package'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:tour_packages,id',
            'trip_date' => 'required|date|after:today',
            'num_participants' => 'required|integer|min:1',
            'tourist_type' => 'required|in:local,foreign',
            'payment_type' => 'required|in:full,dp',
            'customer_phone' => 'required|string',
            'identity_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024', // Max 1 MB
        ]);

        $package = TourPackage::findOrFail($request->package_id);
        $pax = $request->num_participants;
        
        // Cari harga terdekat ke bawah (fallback tier)
        $availableTiers = [10, 8, 5, 4, 3, 2, 1];
        $pricePerPax = null;
        $matchedTier = 1;

        foreach ($availableTiers as $tier) {
            if ($pax >= $tier) {
                $column = 'price_' . $tier . 'pax';
                if ($request->tourist_type === 'foreign') {
                    $column .= '_foreign';
                }
                
                $price = $package->{$column};

                // Fallback to local if foreign not set
                if (!$price && $request->tourist_type === 'foreign') {
                    $price = $package->{'price_' . $tier . 'pax'};
                }

                if ($price) {
                    $pricePerPax = $price;
                    $matchedTier = $tier;
                    break;
                }
            }
        }

        // Validasi jika jumlah pax tidak didukung (harganya kosong)
        if (!$pricePerPax) {
            return back()->withErrors(['message' => __('messages.error_price_not_found', ['count' => $pax])]);
        }

        $totalPrice = $pricePerPax * $pax;
        
        // Kalkulasi DP (misal DP 30%)
        $dpAmount = 0;
        if ($request->payment_type === 'dp') {
            $dpAmount = $totalPrice * 0.30;
        }

        $amountToPay = $request->payment_type === 'dp' ? $dpAmount : $totalPrice;

        DB::beginTransaction();
        try {
            // Upload KTP/Passport
            $identityPath = null;
            if ($request->hasFile('identity_document')) {
                $identityPath = $request->file('identity_document')->store('bookings/identity', 'public');
            }

            // Buat data pesanan (Booking)
            $booking = Booking::create([
                'booking_code' => 'TRX-' . strtoupper(uniqid()),
                'package_id' => $package->id,
                'num_participants' => $pax,
                'booking_date' => now(),
                'trip_date' => $request->trip_date,
                'total_price' => $totalPrice,
                'dp_amount' => $dpAmount,
                'remaining_amount' => $totalPrice - $dpAmount,
                'payment_status' => 'pending',
                'booking_status' => 'pending',
                'customer_name' => Auth::user()->name,
                'customer_email' => Auth::user()->email,
                'customer_phone' => $request->customer_phone,
                'identity_document_path' => $identityPath,
                'notes' => "Tipe Turis: " . ucfirst($request->tourist_type) . "\n\nCatatan Tambahan:\n" . $request->notes,
            ]);

            // Siapkan parameter Midtrans
            $paymentTitle = 'Trip ' . $package->package_name . ' (' . $pax . ' Pax)';
            if ($request->payment_type === 'dp') {
                $paymentTitle .= ' - DP 30%';
            } else {
                $paymentTitle .= ' - Lunas';
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $booking->booking_code,
                    'gross_amount' => round($amountToPay), // Midtrans expects integer
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $request->customer_phone,
                ],
                'item_details' => [
                    [
                        'id' => $package->id,
                        'price' => round($amountToPay),
                        'quantity' => 1, // Dibuat 1 agar tidak terjadi selisih perhitungan (mismatch) dengan gross_amount
                        'name' => mb_strimwidth($paymentTitle, 0, 50, '...'), // Midtrans membatasi panjang karakter name
                    ]
                ]
            ];

            // Request Token ke Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Simpan Token
            $booking->update([
                'snap_token' => $snapToken
            ]);

            DB::commit();

            // Arahkan ke halaman pembayaran
            return redirect()->route('checkout.payment', ['locale' => app()->getLocale(), 'booking' => $booking->booking_code]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => __('messages.error_payment_processing', ['error' => $e->getMessage()])]);
        }
    }

    public function payment($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
                        ->where('customer_email', Auth::user()->email)
                        ->firstOrFail();
                        
        return view('paket.pembayaran', compact('booking'));
    }

    public function success($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)
                        ->where('customer_email', Auth::user()->email)
                        ->firstOrFail();

        // Safe Local/Sandbox fallback: Update booking status directly on success callback
        if ($booking->booking_status === 'pending') {
            $updateData = [
                'booking_status' => 'confirmed',
                'payment_status' => 'paid',
            ];
            
            // If they paid full price (Lunas), remaining payment is 0
            if ($booking->dp_amount == 0) {
                $updateData['remaining_amount'] = 0;
            }
            
            $booking->update($updateData);
        }

        return redirect()->route('profile', ['locale' => app()->getLocale(), 'tab' => 'pesanan'])
                         ->with('success', __('messages.payment_success_flash'));
    }

    public function invoice($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)->firstOrFail();

        // Allow only the booking owner OR an administrator to view the invoice
        if (Auth::user()->email !== $booking->customer_email && Auth::user()->role !== 'admin') {
            abort(403, __('messages.error_unauthorized_invoice'));
        }

        return view('paket.invoice', compact('booking'));
    }
}
