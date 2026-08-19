<!-- Cancel Booking Confirmation Modal -->
<div id="cancel-booking-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4">
    <!-- Soft Backdrop (Light tint with very subtle blur) -->
    <div class="fixed inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity duration-300" onclick="hideCancelBookingModal()"></div>
    
    <!-- Modal Box (Wider to prevent text wrapping & keep it sleek) -->
    <div class="relative bg-white border border-gray-100 shadow-2xl rounded-3xl max-w-[340px] w-full p-6 text-center transform scale-95 opacity-0 transition-all duration-300 z-10" id="cancel-booking-modal-content">
        <!-- Icon: Minimal Soft Red Circle -->
        <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-500 text-lg mx-auto mb-3.5">
            <i class="fa fa-ban"></i>
        </div>
        
        <!-- Text -->
        <h3 class="text-sm font-bold text-gray-800 mb-1.5">{{ __('messages.cancel_booking_btn') }}</h3>
        <p class="text-[11px] text-gray-400 leading-relaxed mb-5 px-1">{{ __('messages.cancel_booking_confirm') }}</p>
        
        <!-- Buttons -->
        <div class="flex gap-3 justify-center">
            <button onclick="hideCancelBookingModal()" class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-500 text-[10px] font-bold transition-all duration-300 focus:outline-none" style="border: 1px solid #e5e7eb !important; border-radius: 30px !important; padding: 8px 16px !important; white-space: nowrap !important;">
                {{ __('messages.cancel_btn') }}
            </button>
            <button onclick="submitCancelBooking()" class="flex-1 text-white text-[10px] font-bold transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none" style="background-color: rgb(239, 68, 68); box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2); border-radius: 30px !important; border: none !important; padding: 8px 16px !important; white-space: nowrap !important;">
                {{ __('messages.cancel_booking_btn') }}
            </button>
        </div>
    </div>
</div>
