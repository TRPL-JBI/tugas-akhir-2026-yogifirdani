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
</style>
@endpush

<section class="bg-light pb-5" style="padding-top: 90px;">
    <div class="container">
        @if($errors->any())
            <div class="alert alert-danger" style="border-radius: 10px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process', app()->getLocale()) }}" method="POST" enctype="multipart/form-data" x-data="checkoutForm()">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">
            <div class="row">
                <!-- Kiri: Form Data -->
                <div class="col-lg-8">
                    <div class="bg-white p-5 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid rgba(0,0,0,0.05);">
                        <h3 class="mb-4" style="font-weight: 800; font-size: 22px;">{{ __('messages.checkout_title') }}</h3>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #555;">{{ __('messages.tourist_type') }} <span class="text-danger">*</span></label>
                                    <select name="tourist_type" x-model="touristType" class="form-control" style="border-radius: 8px; height: 50px;" required @change="calculateTotal">
                                        <option value="local">{{ __('messages.tourist_local') }}</option>
                                        <option value="foreign">{{ __('messages.tourist_foreign') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #555;">Upload KTP / Passport <span class="text-danger">*</span></label>
                                    <input type="file" name="identity_document" class="form-control" accept="image/jpeg,image/png,image/jpg,application/pdf" style="border-radius: 8px; height: 50px; padding: 10px;" required>
                                    <small class="text-muted">Max 1 MB (JPG, PNG, PDF)</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #555;">{{ __('messages.whatsapp_number') }} <span class="text-danger">*</span></label>
                                    <input type="text" name="customer_phone" class="form-control" placeholder="{{ __('messages.whatsapp_placeholder') }}" style="border-radius: 8px; height: 50px;" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #555;">{{ __('messages.trip_date') }} <span class="text-danger">*</span></label>
                                    <input type="date" name="trip_date" class="form-control" min="{{ date('Y-m-d', strtotime('+1 day')) }}" style="border-radius: 8px; height: 50px;" required>
                                </div>
                            </div>
                            
                            @if($package->packageType && (Str::contains(strtolower($package->packageType->type_name), 'open') || Str::contains(strtolower($package->packageType->slug), 'open')))
                            <div class="col-md-12 mb-3">
                                <div class="p-3 d-flex align-items-start" style="background-color: #e8f9fd; border-left: 4px solid rgb(87, 201, 209); border-radius: 8px;">
                                    <i class="fa fa-info-circle mr-2.5 mt-1" style="color: rgb(87, 201, 209); font-size: 16px;"></i>
                                    <div>
                                        <p class="mb-0" style="font-size: 12px; color: #444; line-height: 1.5; font-weight: 600;">
                                            {{ __('messages.open_trip_checkout_notice') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #555;">{{ __('messages.additional_notes') }}</label>
                                    <textarea name="notes" class="form-control" rows="3" placeholder="{{ __('messages.notes_placeholder') }}" style="border-radius: 8px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan: Ringkasan & Pembayaran -->
                <div class="col-lg-4">
                    <div class="bg-white p-4 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); position: sticky; top: 100px;">
                        <h4 class="mb-4" style="font-weight: 800; font-size: 18px; border-bottom: 2px solid #f8f9fa; padding-bottom: 15px;">{{ __('messages.order_summary') }}</h4>
                        
                        <div class="mb-3">
                            <p class="mb-1" style="font-size: 14px; color: #777;">{{ __('messages.package_name') }}</p>
                            <h5 style="font-weight: 700; color: #333; font-size: 16px;">{{ $package->getTranslation('package_name') }}</h5>
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #555; font-size: 14px;">{{ __('messages.num_participants') }} ({{ __('messages.pax') }}) <span class="text-danger">*</span></label>
                            <input type="number" name="num_participants" x-model="pax" class="form-control" style="border-radius: 8px; height: 50px;" min="1" required @input="calculateTotal">
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-weight: 600; color: #555; font-size: 14px;">{{ __('messages.payment_method') }} <span class="text-danger">*</span></label>
                            <select name="payment_type" x-model="paymentType" class="form-control" style="border-radius: 8px;" required @change="calculateTotal">
                                <option value="full">{{ __('messages.pay_full') }}</option>
                                <option value="dp">{{ __('messages.pay_dp') }}</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span style="color: #666;">{{ __('messages.price_per_pax') }}</span>
                            <span style="font-weight: 600;" x-text="formatRupiah(pricePerPax)">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 pb-3" style="border-bottom: 1px dashed #ddd;">
                            <span style="color: #666;">{{ __('messages.total_price') }} (<span x-text="pax"></span> {{ __('messages.pax') }})</span>
                            <span style="font-weight: 600;" x-text="formatRupiah(totalPrice)">Rp 0</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span style="font-weight: 800; font-size: 16px; color: #333;" x-text="paymentType === 'dp' ? '{{ __('messages.dp_to_pay_now') }}' : '{{ __('messages.total_bill') }}'">{{ __('messages.total_bill') }}</span>
                            <span style="font-weight: 800; font-size: 20px; color: rgb(87, 201, 209);" x-text="formatRupiah(amountToPay)">Rp 0</span>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-3" style="border-radius: 30px; font-weight: 700; background-color: rgb(87, 201, 209); border: none; box-shadow: 0 4px 15px rgba(87, 201, 209, 0.4);">
                            {{ __('messages.proceed_payment') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    // Prepare price data from backend
    const priceData = {
        local: {
            @foreach([1,2,3,4,5,8,10] as $p)
                {{ $p }}: {{ intval($package->{'price_'.$p.'pax'}) }},
            @endforeach
        },
        foreign: {
            @foreach([1,2,3,4,5,8,10] as $p)
                {{ $p }}: {{ intval($package->{'price_'.$p.'pax_foreign'} ?: $package->{'price_'.$p.'pax'}) }},
            @endforeach
        }
    };

    document.addEventListener('alpine:init', () => {
        Alpine.data('checkoutForm', () => ({
            touristType: 'local',
            pax: 1,
            paymentType: 'full',
            pricePerPax: 0,
            totalPrice: 0,
            amountToPay: 0,

            init() {
                this.calculateTotal();
            },

            calculateTotal() {
                // Cari harga terdekat ke bawah (fallback tier)
                let availableTiers = [10, 8, 5, 4, 3, 2, 1];
                let price = 0;
                let currentPax = parseInt(this.pax) || 1;
                
                for (let tier of availableTiers) {
                    if (currentPax >= tier && priceData[this.touristType][tier]) {
                        price = priceData[this.touristType][tier];
                        break;
                    }
                }
                
                this.pricePerPax = price;
                
                // Calculate Total
                this.totalPrice = this.pricePerPax * this.pax;
                
                // Calculate Amount to pay (DP or Full)
                if (this.paymentType === 'dp') {
                    this.amountToPay = this.totalPrice * 0.3;
                } else {
                    this.amountToPay = this.totalPrice;
                }
            },

            formatRupiah(angka) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(angka);
            }
        }))
    })
</script>
@endpush
