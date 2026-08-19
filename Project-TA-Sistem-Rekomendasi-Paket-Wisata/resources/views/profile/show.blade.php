@extends('template')

@section('content')
<div class="min-h-screen relative flex items-center justify-center py-8 px-4 font-outfit overflow-hidden pt-24 bg-[#f8f9fa]">
    <div class="container mx-auto max-w-4xl relative z-10">
        
        <!-- Main Card - Smaller & Compact Light Mode -->
        <div class="bg-white border border-gray-150 shadow-xl rounded-[2rem] overflow-hidden flex flex-col md:flex-row mx-auto w-full">
            
            <!-- Left Sidebar - Clean Light Background -->
            <aside class="w-full md:w-64 bg-gray-50 border-r border-gray-150 p-6 flex flex-col items-center">
                <div class="relative mb-4">
                    <div class="w-20 h-20 bg-gradient-to-tr from-[#57c9d1] to-[#3ca7af] rounded-2xl flex items-center justify-center text-white text-4xl font-bold shadow-xl transform rotate-2 hover:rotate-0 transition-all duration-500">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                </div>
                
                <h2 class="text-lg font-bold text-gray-800 mb-0.5 text-center px-2">{{ $user->name }}</h2>
                <p class="text-gray-400 text-[10px] mb-6 uppercase tracking-widest">{{ __('messages.profile_premium_member') }}</p>

                <nav class="w-full space-y-2">
                    <button id="tab-akun" onclick="showTab('akun')" class="w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 bg-[#57c9d1] text-white shadow-lg shadow-[#57c9d1]/20">
                        <i class="fa fa-user text-lg"></i>
                        <span class="text-xs font-semibold">{{ __('messages.profile_my_account') }}</span>
                    </button>
                    <button id="tab-pesanan" onclick="showTab('pesanan')" class="w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 text-gray-600 hover:bg-gray-100 hover:text-[#57c9d1]">
                        <i class="fa fa-ticket text-lg"></i>
                        <span class="text-xs font-semibold">{{ __('messages.profile_my_orders') }}</span>
                    </button>
                    <div class="h-px bg-gray-200 my-3 mx-4"></div>
                    <form action="{{ lroute('logout') }}" method="POST" class="hidden" id="profile-logout-form">@csrf</form>
                    <button onclick="event.preventDefault(); showLogoutModal();" class="w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 text-red-500 hover:bg-red-50">
                        <i class="fa fa-sign-out text-lg"></i>
                        <span class="text-xs font-semibold">{{ __('messages.profile_logout') }}</span>
                    </button>
                </nav>
            </aside>

            <!-- Right Content Area - More Compact -->
            <main class="flex-1 p-5 md:p-8 relative bg-white">
                
                <!-- Alerts Inside Content Area -->
                @if (session('success'))
                <div id="success-alert" class="absolute top-6 right-6 md:top-10 md:right-10 bg-green-500/20 border border-green-500/50 text-green-500 px-4 py-2 rounded-xl shadow-xl animate-fadeIn transition-all duration-500 z-50 flex items-center gap-2">
                    <i class="ion-ios-checkmark-circle text-lg"></i>
                    <span class="text-xs font-bold">{{ session('success') }}</span>
                </div>
                @endif

                <!-- Tab: Akun Saya -->
                <div id="content-akun" class="space-y-6 animate-fadeIn">
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                            <span class="w-1 h-6 bg-[#57c9d1] rounded-full shadow-[0_0_10px_#57c9d1]"></span>
                            {{ __('messages.profile_account_info') }}
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="group">
                                <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_username') }}</label>
                                <div class="bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium group-hover:border-[#57c9d1]/40 transition-colors shadow-inner">
                                    {{ $user->name }}
                                </div>
                            </div>

                            <div class="group">
                                <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_full_name') }}</label>
                                <div class="bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium group-hover:border-[#57c9d1]/40 transition-colors shadow-inner">
                                    {{ $user->name }}
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_registered_email') }}</label>
                            <div class="bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium group-hover:border-[#57c9d1]/40 transition-colors shadow-inner">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="group">
                            <label class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1.5 block ml-1">{{ __('messages.profile_phone') }}</label>
                            <div class="bg-gray-50 border border-gray-200 px-4 py-3 rounded-xl text-gray-800 text-sm font-medium group-hover:border-[#57c9d1]/40 transition-colors shadow-inner">
                                {{ $user->phone ?? __('messages.profile_phone_empty') }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ lroute('profile.edit') }}" class="text-white text-sm font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:-translate-y-0.5 inline-block" style="background-color: rgb(87, 201, 209); box-shadow: 0 4px 15px rgba(87, 201, 209, 0.3);">
                            {{ __('messages.profile_edit_btn') }}
                        </a>
                        <a href="{{ lroute('profile.edit') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-3 px-8 rounded-xl border border-gray-200 transition-all duration-300 inline-block">
                            {{ __('messages.profile_change_password') }}
                        </a>
                    </div>
                </div>

                <!-- Tab: Pemesanan Saya -->
                <div id="content-pesanan" class="hidden space-y-6 animate-fadeIn">
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <h3 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                            <span class="w-1 h-6 bg-[#57c9d1] rounded-full shadow-[0_0_10px_#57c9d1]"></span>
                            {{ __('messages.profile_order_history') }}
                        </h3>
                    </div>

                    <div class="space-y-4 max-h-[360px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($bookings as $booking)
                        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 hover:border-[#57c9d1]/30 transition-all duration-300">
                            <div class="flex flex-col md:flex-row justify-between gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-[10px] font-bold text-[#57c9d1] uppercase tracking-tighter bg-[#57c9d1]/10 px-2 py-0.5 rounded-md">#{{ $booking->booking_code }}</span>
                                        <span class="text-gray-400 text-[10px]">&bull; {{ $booking->booking_date->translatedFormat('d M Y') }}</span>
                                    </div>
                                    <h4 class="text-gray-800 font-bold text-sm">{{ $booking->tourPackage->package_name ?? 'Paket Wisata' }}</h4>
                                    @if($booking->tourPackage && ($booking->tourPackage->category || $booking->tourPackage->packageType))
                                    <div class="flex flex-wrap gap-1.5 mt-1.5">
                                        @if($booking->tourPackage->category)
                                        <span class="text-[9px] font-bold text-[#57c9d1] uppercase tracking-wider bg-[#57c9d1]/10 px-2 py-0.5 rounded-md">
                                            {{ $booking->tourPackage->category->getTranslation('category_name') }}
                                        </span>
                                        @endif
                                        @if($booking->tourPackage->packageType)
                                        <span class="text-[9px] font-bold text-gray-500 uppercase tracking-wider bg-gray-100 px-2 py-0.5 rounded-md">
                                            {{ $booking->tourPackage->packageType->getTranslation('type_name') }}
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                    <p class="text-gray-500 text-[10px] mt-2 flex items-center gap-1">
                                        <i class="fa fa-calendar"></i> {{ __('messages.profile_schedule') }}: {{ $booking->trip_date->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                                <div class="flex flex-col md:items-end gap-2 text-right w-full md:w-auto mt-4 md:mt-0">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider inline-block w-max self-start md:self-end {{ $booking->booking_status == 'confirmed' ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-600' }}">
                                        {{ $booking->booking_status }}
                                    </span>
                                    
                                    <div class="mt-2 bg-white border border-gray-150 rounded-lg p-3 text-xs w-full min-w-[260px] text-left md:text-right">
                                        <div class="flex justify-between gap-4 mb-1">
                                            <span class="text-gray-500">{{ __('messages.total_price') }}:</span>
                                            <span class="text-gray-800 font-semibold whitespace-nowrap">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        </div>
                                        
                                        @if($booking->booking_status === 'pending' || $booking->payment_status === 'pending')
                                        <div class="flex justify-between gap-4 mb-1">
                                            <span class="text-gray-400">{{ __('messages.amount_paid_profile') }}</span>
                                            <span class="text-gray-400 font-bold whitespace-nowrap">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between gap-4 pt-1 mt-1 border-t border-gray-100">
                                            <span class="text-red-500 font-bold">{{ __('messages.must_be_paid_label') }}</span>
                                            <span class="text-red-500 font-bold whitespace-nowrap">Rp {{ number_format($booking->dp_amount > 0 ? $booking->dp_amount : $booking->total_price, 0, ',', '.') }}</span>
                                        </div>
                                        @else
                                            @if($booking->dp_amount > 0)
                                            <div class="flex justify-between gap-4 mb-1">
                                                <span class="text-[#57c9d1]">{{ __('messages.amount_paid_dp_profile') }}</span>
                                                <span class="text-[#57c9d1] font-bold whitespace-nowrap">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                                            </div>
                                            <div class="flex justify-between gap-4 pt-1 mt-1 border-t border-gray-100">
                                                <span class="text-gray-500">{{ __('messages.remaining_balance_label') }}</span>
                                                <span class="text-red-500 font-bold whitespace-nowrap">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</span>
                                            </div>
                                            @else
                                            <div class="flex justify-between gap-4 pt-1 mt-1 border-t border-gray-100">
                                                <span class="text-[#57c9d1]">{{ __('messages.amount_paid_full_profile') }}</span>
                                                <span class="text-[#57c9d1] font-bold whitespace-nowrap">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                            </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol Toggle Detail Pemesanan -->
                            <div class="mt-4 pt-3 border-t border-gray-200/60 flex justify-between items-center flex-wrap gap-2">
                                <button onclick="toggleBookingDetail('detail-{{ $booking->id }}')" class="text-[11px] font-bold text-gray-500 hover:text-[#57c9d1] transition-all flex items-center gap-1.5 focus:outline-none">
                                    <i class="fa fa-info-circle"></i>
                                    {{ __('messages.booking_detail_btn') }}
                                    <i class="fa fa-chevron-down text-[8px] transition-transform duration-300" id="icon-detail-{{ $booking->id }}"></i>
                                </button>
                                
                                @if($booking->booking_status == 'pending' && $booking->snap_token)
                                <div class="flex items-center gap-2">
                                    <a href="javascript:void(0)" 
                                       onclick="showCancelBookingModal('{{ $booking->id }}')"
                                       class="text-[10px] font-bold text-white transition-all duration-300 hover:-translate-y-0.5 shadow-sm hover:shadow-md" 
                                       style="display: inline-flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; background-color: rgb(239, 68, 68) !important; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); border: 1px solid transparent !important; border-radius: 30px !important; height: 32px !important; padding: 0 16px !important; text-decoration: none !important; line-height: 1 !important; margin: 0 !important;">
                                        <i class="fa fa-ban text-[10px]"></i>
                                        {{ __('messages.cancel_booking_btn') }}
                                    </a>
                                    <form id="cancel-form-{{ $booking->id }}" action="{{ route('booking.cancel', ['locale' => app()->getLocale(), 'booking' => $booking->booking_code]) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a href="{{ route('checkout.payment', ['locale' => app()->getLocale(), 'booking' => $booking->booking_code]) }}" 
                                       class="text-[10px] font-bold text-white transition-all duration-300 hover:-translate-y-0.5 shadow-sm hover:shadow-md" 
                                       style="display: inline-flex !important; align-items: center !important; justify-content: center !important; gap: 6px !important; background-color: rgb(87, 201, 209) !important; box-shadow: 0 4px 10px rgba(87, 201, 209, 0.2); border: 1px solid transparent !important; border-radius: 30px !important; height: 32px !important; padding: 0 16px !important; text-decoration: none !important; line-height: 1 !important; margin: 0 !important;">
                                        <i class="fa fa-credit-card text-[10px]"></i>
                                        {{ __('messages.pay_now_btn') }}
                                    </a>
                                </div>
                                @elseif($booking->booking_status == 'confirmed' || $booking->payment_status == 'paid' || $booking->payment_status == 'success')
                                <a href="{{ route('checkout.invoice', ['locale' => app()->getLocale(), 'booking' => $booking->booking_code]) }}" class="text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all shadow-sm flex items-center gap-1.5 inline-block" style="color: rgb(87, 201, 209) !important; border: 1px solid rgba(87, 201, 209, 0.4) !important;">
                                    <i class="fa fa-file-text-o"></i> {{ __('messages.print_invoice_btn') }}
                                </a>
                                @endif
                            </div>

                             <!-- Panel Detail Konten (Hidden) -->
                             <div id="detail-{{ $booking->id }}" class="hidden mt-3 p-5 bg-white border border-gray-150 rounded-xl space-y-4 text-xs md:text-sm text-gray-700 shadow-inner animate-fadeIn">
                                 <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                     <div>
                                         <p class="text-[10px] md:text-xs uppercase font-bold text-gray-400 tracking-wider mb-2">{{ __('messages.booker_contact_header') }}</p>
                                         <div class="space-y-1.5">
                                             <p><span class="font-medium text-gray-500">{{ __('messages.name_label') }}:</span> <strong class="text-gray-800">{{ $booking->customer_name }}</strong></p>
                                             <p><span class="font-medium text-gray-500">{{ __('messages.email_label') }}:</span> <strong class="text-gray-800">{{ $booking->customer_email }}</strong></p>
                                             <p><span class="font-medium text-gray-500">{{ __('messages.phone_label') }}:</span> <strong class="text-gray-800">{{ $booking->customer_phone }}</strong></p>
                                         </div>
                                     </div>
                                     <div>
                                         <p class="text-[10px] md:text-xs uppercase font-bold text-gray-400 tracking-wider mb-2">{{ __('messages.tour_details_header') }}</p>
                                         <div class="space-y-1.5">
                                             @if($booking->tourPackage && $booking->tourPackage->category)
                                             <p><span class="font-medium text-gray-500">{{ __('messages.package_category_label') }}</span> <strong class="text-[#57c9d1]">{{ $booking->tourPackage->category->getTranslation('category_name') }}</strong></p>
                                             @endif
                                             @if($booking->tourPackage && $booking->tourPackage->packageType)
                                             <p><span class="font-medium text-gray-500">{{ __('messages.trip_type_label') }}</span> <strong class="text-gray-700 font-semibold">{{ $booking->tourPackage->packageType->getTranslation('type_name') }}</strong></p>
                                             @endif
                                             <p><span class="font-medium text-gray-500">{{ __('messages.num_participants_label') }}:</span> <strong class="text-gray-800">{{ $booking->num_participants }} Pax ({{ trans_choice('messages.pax_count', $booking->num_participants, ['count' => $booking->num_participants]) }})</strong></p>
                                             <p><span class="font-medium text-gray-500">{{ __('messages.trip_date_label') }}:</span> <strong class="text-gray-800">{{ $booking->trip_date->translatedFormat('d M Y') }}</strong></p>
                                         </div>
                                     </div>
                                 </div>
                                 @if($booking->notes)
                                 <div class="border-t border-gray-100 pt-3">
                                     <p class="text-[10px] md:text-xs uppercase font-bold text-gray-400 tracking-wider mb-1.5">{{ __('messages.booking_notes_header') }}</p>
                                     <p class="text-gray-700 whitespace-pre-line leading-relaxed bg-gray-50 p-3 rounded-lg border border-gray-100 font-medium">{{ $booking->notes }}</p>
                                 </div>
                                 @endif
                             </div>
                         </div>
                        @empty
                        <div class="text-center py-12 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                            <i class="ion-ios-paper text-4xl text-gray-300 mb-3 block"></i>
                            <p class="text-gray-400 text-sm">{{ __('messages.profile_no_orders') }}</p>
                            <a href="{{ lroute('home') }}" class="text-[#57c9d1] text-xs font-bold mt-4 inline-block hover:underline">{{ __('messages.profile_explore_packages') }}</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
        
        <!-- Footer Info -->
        <p class="text-center text-gray-300 text-[10px] mt-6 tracking-wide">
            {{ __('messages.profile_footer') }}
        </p>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div id="logout-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4">
    <!-- Soft Backdrop (Light tint with very subtle blur) -->
    <div class="fixed inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity duration-300" onclick="hideLogoutModal()"></div>
    
    <!-- Modal Box (Compact & Balanced Width) -->
    <div class="relative bg-white border border-gray-100 shadow-2xl rounded-3xl max-w-[300px] w-full p-5 text-center transform scale-95 opacity-0 transition-all duration-300 z-10" id="logout-modal-content">
        <!-- Icon: Minimal Soft Teal Circle -->
        <div class="w-12 h-12 bg-[#57c9d1]/10 rounded-full flex items-center justify-center text-[#57c9d1] text-lg mx-auto mb-3">
            <i class="fa fa-sign-out"></i>
        </div>
        
        <!-- Text -->
        <h3 class="text-sm font-bold text-gray-800 mb-1">{{ __('messages.logout_modal_title') }}</h3>
        <p class="text-[11px] text-gray-400 leading-normal mb-5">{{ __('messages.logout_modal_message') }}</p>
        
        <!-- Buttons -->
        <div class="flex gap-3">
            <button onclick="hideLogoutModal()" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-500 text-[10px] font-bold transition-all duration-300 focus:outline-none" style="border: 1px solid #e5e7eb !important; border-radius: 30px !important; padding: 6px 16px !important;">
                {{ __('messages.cancel_btn') }}
            </button>
            <button onclick="submitLogout()" class="flex-1 text-white text-[10px] font-bold transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none" style="background-color: rgb(87, 201, 209); box-shadow: 0 3px 10px rgba(87, 201, 209, 0.2); border-radius: 30px !important; border: none !important; padding: 6px 16px !important;">
                {{ __('messages.yes_logout_btn') }}
            </button>
        </div>
    </div>
</div>

@include('profile.cancel-modal')

<script>
    function showLogoutModal() {
        const modal = document.getElementById('logout-modal');
        const content = document.getElementById('logout-modal-content');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function hideLogoutModal() {
        const modal = document.getElementById('logout-modal');
        const content = document.getElementById('logout-modal-content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function submitLogout() {
        document.getElementById('profile-logout-form').submit();
    }

    let cancelFormIdToSubmit = null;

    function showCancelBookingModal(bookingId) {
        cancelFormIdToSubmit = 'cancel-form-' + bookingId;
        const modal = document.getElementById('cancel-booking-modal');
        const content = document.getElementById('cancel-booking-modal-content');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function hideCancelBookingModal() {
        const modal = document.getElementById('cancel-booking-modal');
        const content = document.getElementById('cancel-booking-modal-content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            cancelFormIdToSubmit = null;
        }, 300);
    }

    function submitCancelBooking() {
        if (cancelFormIdToSubmit) {
            document.getElementById(cancelFormIdToSubmit).submit();
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide success alert after 5 seconds
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }

        // Buka tab otomatis jika ada parameter ?tab= di URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('tab')) {
            showTab(urlParams.get('tab'));
        }
    });

    function showTab(tabId) {
        // Hide all tabs
        document.getElementById('content-akun').classList.add('hidden');
        document.getElementById('content-pesanan').classList.add('hidden');
        
        // Show target tab
        document.getElementById('content-' + tabId).classList.remove('hidden');
        
        // Update active state in sidebar buttons
        const btnAkun = document.getElementById('tab-akun');
        const btnPesanan = document.getElementById('tab-pesanan');
        
        if (tabId === 'akun') {
            btnAkun.className = "w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 bg-[#57c9d1] text-white shadow-lg shadow-[#57c9d1]/20";
            btnPesanan.className = "w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 text-gray-600 hover:bg-gray-100 hover:text-[#57c9d1]";
        } else {
            btnPesanan.className = "w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 bg-[#57c9d1] text-white shadow-lg shadow-[#57c9d1]/20";
            btnAkun.className = "w-full flex items-center gap-3 px-5 py-3 rounded-xl transition-all duration-300 text-gray-600 hover:bg-gray-100 hover:text-[#57c9d1]";
        }
    }

    function toggleBookingDetail(detailId) {
        const detailEl = document.getElementById(detailId);
        const iconEl = document.getElementById('icon-' + detailId);
        if (detailEl.classList.contains('hidden')) {
            detailEl.classList.remove('hidden');
            if (iconEl) iconEl.style.transform = 'rotate(180deg)';
        } else {
            detailEl.classList.add('hidden');
            if (iconEl) iconEl.style.transform = 'rotate(0deg)';
        }
    }
</script>

@push('styles')
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    /* Ubah warna teks navbar menjadi hitam di halaman ini (sebelum di-scroll) agar terlihat di background putih */
    #ftco-navbar:not(.scrolled) .nav-link,
    #ftco-navbar:not(.scrolled) .dropdown-item {
        color: #222222 !important;
    }
    #ftco-navbar .nav-item.active .nav-link,
    #ftco-navbar .nav-link:hover {
        color: rgb(87, 201, 209) !important;
    }
    #ftco-navbar .nav-link i {
        color: inherit !important;
    }
    #ftco-navbar:not(.scrolled) .navbar-toggler {
        color: #222222 !important;
    }

    .backdrop-blur-md {
        -webkit-backdrop-filter: blur(8px);
    }
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Scrollbar Kustom untuk Riwayat Pemesanan */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.03);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(87, 201, 209, 0.3);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(87, 201, 209, 0.6);
    }
</style>
@endpush
@endsection
