@extends('template')

@section('content')

@push('styles')
<style>
    /* Paksa semua menu navbar menjadi tebal di halaman ini (baik saat scroll maupun tidak) */
    #ftco-navbar .nav-link,
    #ftco-navbar .dropdown-item,
    #ftco-navbar .cta .nav-link span {
        font-weight: 700 !important;
    }

    /* Ubah warna teks navbar menjadi hitam di halaman checkout (sebelum di-scroll) agar terlihat di background putih */
    #ftco-navbar:not(.scrolled) .nav-link,
    #ftco-navbar:not(.scrolled) .dropdown-item {
        color: #222222 !important;
    }
    /* Warna saat menu aktif atau di-hover menjadi warna brand (baik scroll maupun tidak) */
    #ftco-navbar .nav-item.active .nav-link,
    #ftco-navbar .nav-link:hover {
        color: rgb(87, 201, 209) !important;
    }
    /* Ikon panah bawah (dropdown) */
    #ftco-navbar .nav-link i {
        color: inherit !important;
    }
    /* Ikon Menu (hamburger di mobile) */
    #ftco-navbar:not(.scrolled) .navbar-toggler {
        color: #222222 !important;
    }

    /* ===== ANIMASI MODAL WA ===== */
    @keyframes fadeInBackdrop {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes slideUpCard {
        from { opacity: 0; transform: scale(0.85) translateY(30px); }
        to   { opacity: 1; transform: scale(1)   translateY(0); }
    }
    @keyframes fadeOutBackdrop {
        from { opacity: 1; }
        to   { opacity: 0; }
    }
    @keyframes slideDownCard {
        from { opacity: 1; transform: scale(1)    translateY(0); }
        to   { opacity: 0; transform: scale(0.85) translateY(30px); }
    }
    #wa-payment-modal.modal-entering {
        animation: fadeInBackdrop 0.25s ease forwards;
    }
    #wa-payment-modal.modal-entering .modal-card {
        animation: slideUpCard 0.3s cubic-bezier(0.34,1.56,0.64,1) forwards;
    }
    #wa-payment-modal.modal-leaving {
        animation: fadeOutBackdrop 0.2s ease forwards;
    }
    #wa-payment-modal.modal-leaving .modal-card {
        animation: slideDownCard 0.2s ease forwards;
    }
</style>
@endpush

<section class="bg-light pb-5" style="padding-top: 90px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="bg-white p-5 shadow-sm text-center" style="border-radius: 16px; border: 1px solid rgba(0,0,0,0.05);">
                    <div class="mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 80px; color: rgb(87, 201, 209);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    
                    <h2 class="mb-3" style="font-weight: 800;">{{ __('messages.order_created_success') }}</h2>
                    <p style="color: #666; font-size: 16px;">{{ __('messages.your_order_code') }} <strong>{{ $booking->booking_code }}</strong></p>
                    
                    <div class="bg-light p-4 mt-4 mb-4 text-left" style="border-radius: 12px; border: 1px dashed #ccc;">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <span style="color: #777; font-size: 14px;">{{ __('messages.package_name') }}</span><br>
                                <strong>{{ $booking->tourPackage->getTranslation('package_name') }}</strong>
                            </div>
                            <div class="col-6 mb-2">
                                <span style="color: #777; font-size: 14px;">{{ __('messages.trip_date_label') }}</span><br>
                                <strong>{{ \Carbon\Carbon::parse($booking->trip_date)->translatedFormat('d F Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <span style="color: #777; font-size: 14px;">{{ __('messages.num_participants_pax') }}</span><br>
                                <strong>{{ trans_choice('messages.pax_count', $booking->num_participants, ['count' => $booking->num_participants]) }}</strong>
                            </div>
                            <div class="col-6">
                                <span style="color: #777; font-size: 14px;">{{ __('messages.total_bill_label') }}</span><br>
                                <strong style="color: rgb(87, 201, 209); font-size: 18px;">Rp {{ number_format($booking->dp_amount > 0 ? $booking->dp_amount : $booking->total_price, 0, ',', '.') }}</strong>
                                @if($booking->dp_amount > 0)
                                <br><small class="text-muted">({{ __('messages.dp_payment_note') }})</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p class="mb-4 text-muted">{{ __('messages.complete_payment_instruction') }}</p>

                    {{-- =============================================
                         SAKLAR METODE PEMBAYARAN
                         Ubah kata 'whatsapp' menjadi 'midtrans' untuk 
                         mengganti sistem pembayaran secara instan!
                    ============================================== --}}
                    @php
                        $paymentMethod = 'whatsapp'; // Pilihan: 'whatsapp' atau 'midtrans'
                    @endphp

                    @if($paymentMethod == 'whatsapp')
                        {{-- Tombol Pembayaran WhatsApp --}}
                        <button id="pay-button-wa" class="btn btn-primary py-3 px-5" style="border-radius: 30px; font-weight: 700; background-color: rgb(87, 201, 209); border: none; box-shadow: 0 4px 15px rgba(87, 201, 209, 0.4); font-size: 18px;"
                            onclick="openWaModal()">
                            {{ __('messages.pay_now_btn') }} (WhatsApp)
                        </button>
                    @elseif($paymentMethod == 'midtrans')
                        {{-- Tombol Pembayaran Midtrans --}}
                        <button id="pay-button-midtrans" class="btn btn-primary py-3 px-5" style="border-radius: 30px; font-weight: 700; background-color: rgb(87, 201, 209); border: none; box-shadow: 0 4px 15px rgba(87, 201, 209, 0.4); font-size: 18px;">
                            {{ __('messages.pay_now_btn') }} 
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- =============================================
     MODAL PEMBAYARAN VIA WHATSAPP
============================================== --}}
@if($paymentMethod == 'whatsapp')
<div id="wa-payment-modal"
     style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.55); align-items:center; justify-content:center; padding:16px;">
    <div class="modal-card" style="background:#fff; border-radius:20px; max-width:440px; width:100%; padding:36px 32px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.2); position:relative;">

        {{-- Tombol tutup --}}
        <button onclick="closeWaModal()"
            style="position:absolute; top:14px; right:18px; background:none; border:none; font-size:22px; color:#999; cursor:pointer; line-height:1;">
            &times;
        </button>

        {{-- Ikon WA --}}
        <div style="margin-bottom:16px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="#25D366">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.136.562 4.14 1.541 5.878L.057 23.486a.75.75 0 00.914.914l5.607-1.484A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 01-4.942-1.35l-.355-.211-3.676.972.978-3.578-.231-.368A9.717 9.717 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
            </svg>
        </div>

        <h4 style="font-weight:800; margin-bottom:8px; color:#1a1a1a;">{{ __('messages.wa_modal_title') }}</h4>
        <p style="color:#555; font-size:14px; margin-bottom:20px; line-height:1.6;">
            {{ __('messages.wa_modal_maintenance') }}<br>
            {!! __('messages.wa_modal_desc') !!}
        </p>

        {{-- Info kode booking --}}
        <div style="background:#f0fdf4; border:1px dashed #25D366; border-radius:10px; padding:12px 16px; margin-bottom:20px;">
            <div style="font-size:12px; color:#777; margin-bottom:4px;">{{ __('messages.wa_modal_order_label') }}</div>
            <div style="font-weight:800; font-size:18px; color:#1a1a1a; letter-spacing:1px;">{{ $booking->booking_code }}</div>
            <div style="font-size:13px; color:#555; margin-top:6px;">
                Total: <strong style="color:rgb(87,201,209);">Rp {{ number_format($booking->dp_amount > 0 ? $booking->dp_amount : $booking->total_price, 0, ',', '.') }}</strong>
                @if($booking->dp_amount > 0)
                    <span style="font-size:11px; color:#888;"> (DP)</span>
                @endif
            </div>
        </div>

        {{-- Tombol WA --}}
        @php
            $waNumber  = '6282357896912';
            $totalBayar = 'Rp ' . number_format($booking->dp_amount > 0 ? $booking->dp_amount : $booking->total_price, 0, ',', '.');
            $tipeTagihan = $booking->dp_amount > 0 ? __('messages.wa_msg_dp_type') : __('messages.wa_msg_full_type');
            $tripDate    = \Carbon\Carbon::parse($booking->trip_date)->translatedFormat('d F Y');

            $waMessage = urlencode(
                __('messages.wa_msg_greeting') . " \n\n" .
                __('messages.wa_msg_intent') . "\n\n" .
                "━━━━━━━━━━━━━━━━━\n" .
                __('messages.wa_msg_header') . "\n" .
                "━━━━━━━━━━━━━━━━━\n" .
                "- " . __('messages.wa_msg_order_code') . " : *{$booking->booking_code}*\n" .
                "- " . __('messages.wa_msg_name')       . "         : *{$booking->customer_name}*\n" .
                "- " . __('messages.wa_msg_package')    . "        : {$booking->tourPackage->getTranslation('package_name')}\n" .
                "- " . __('messages.wa_msg_trip_date')  . " : {$tripDate}\n" .
                "- " . __('messages.wa_msg_pax')        . "   : {$booking->num_participants}\n" .
                "- " . __('messages.wa_msg_payment_type') . "   : {$tipeTagihan}\n" .
                "- " . __('messages.wa_msg_total')      . ": *{$totalBayar}*\n" .
                "━━━━━━━━━━━━━━━━━\n\n" .
                __('messages.wa_msg_closing')
            );
        @endphp
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank"
            style="display:inline-flex; align-items:center; gap:10px; background:#25D366; color:#fff; font-weight:700; font-size:16px; padding:14px 28px; border-radius:30px; text-decoration:none; box-shadow:0 4px 15px rgba(37,211,102,0.35); transition:all .2s;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.136.562 4.14 1.541 5.878L.057 23.486a.75.75 0 00.914.914l5.607-1.484A11.944 11.944 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.726 9.726 0 01-4.942-1.35l-.355-.211-3.676.972.978-3.578-.231-.368A9.717 9.717 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
            </svg>
            {{ __('messages.wa_modal_btn') }}
        </a>

        <div style="margin-top:14px; font-size:12px; color:#aaa;">
            {{ __('messages.wa_modal_footer') }}
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
@if($paymentMethod == 'whatsapp')
{{-- Script animasi modal WA --}}
<script>
    function openWaModal() {
        var modal = document.getElementById('wa-payment-modal');
        modal.style.display = 'flex';
        modal.classList.remove('modal-leaving');
        modal.classList.add('modal-entering');
    }

    function closeWaModal() {
        var modal = document.getElementById('wa-payment-modal');
        modal.classList.remove('modal-entering');
        modal.classList.add('modal-leaving');
        setTimeout(function() {
            modal.style.display = 'none';
            modal.classList.remove('modal-leaving');
        }, 200);
    }

    // Klik di luar modal card → tutup
    document.getElementById('wa-payment-modal').addEventListener('click', function(e) {
        if (e.target === this) closeWaModal();
    });
</script>
@elseif($paymentMethod == 'midtrans')
{{-- =============================================
     MIDTRANS SNAP SCRIPT
============================================== --}}
<script src="{{ config('midtrans.isProduction') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.clientKey') }}"></script>
<script>
    document.getElementById('pay-button-midtrans').onclick = function(){
        snap.pay('{{ $booking->snap_token }}', {
            onSuccess: function(result){
                window.location.href = "{{ route('checkout.success', ['locale' => app()->getLocale(), 'booking' => $booking->booking_code]) }}";
            },
            onPending: function(result){
                alert("{{ __('messages.waiting_payment_alert') }}");
            },
            onError: function(result){
                alert("{{ __('messages.payment_failed_alert') }}");
            }
        });
    };
</script>
@endif
@endpush
