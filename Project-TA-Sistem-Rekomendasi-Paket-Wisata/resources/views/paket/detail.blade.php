@extends('template')

@section('content')

<style>
    /* Paksa semua menu navbar menjadi tebal di halaman ini (baik saat scroll maupun tidak) */
    #ftco-navbar .nav-link,
    #ftco-navbar .dropdown-item,
    #ftco-navbar .cta .nav-link span {
        font-weight: 700 !important;
    }

    /* Ubah warna teks navbar menjadi hitam di halaman detail (sebelum di-scroll) agar terlihat di background putih */
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
    /* Tombol Sign Up (garis tepi) */
    #ftco-navbar:not(.scrolled) .cta .nav-link span {
        color: #222222 !important;
        border: 1px solid rgb(87, 201, 209) !important;
    }
    /* Efek hover Sign Up (Register) agar rapi */
    #ftco-navbar:not(.scrolled) .cta .nav-link:hover {
        background: transparent !important;
    }
    #ftco-navbar:not(.scrolled) .cta .nav-link span {
        transition: all 0.3s ease;
    }
    #ftco-navbar:not(.scrolled) .cta .nav-link:hover span {
        background: #70d4de !important;
        border-color: #70d4de !important;
        color: #fff !important;
    }
    /* Ikon Menu (hamburger di mobile) */
    #ftco-navbar:not(.scrolled) .navbar-toggler {
        color: #222222 !important;
    }
</style>

<section class="ftco-section bg-light" style="padding-top: 90px; padding-bottom: 80px;">
  <div class="container">
    
    <div class="row">
      <!-- Kiri: Detail Paket -->
      <div class="col-lg-8 ftco-animate">
        <div class="bg-white p-3 p-md-4 mb-5 shadow-sm" style="border-radius: 16px; border: 1px solid rgba(0,0,0,0.05);">
            
            <!-- Gambar Destinasi (Nanti diambil dari database) -->
            <div class="mb-4" style="border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <img src="{{ $package->image_url ? $package->image_url : asset('images/background/jungle-island.webp') }}" 
                     alt="{{ $package->getTranslation('package_name') }}" 
                     class="img-fluid w-100" 
                     style="object-fit: cover; max-height: 500px;" 
                     loading="lazy" 
                     width="800" 
                     height="500">
            </div>

            <!-- Title & Breadcrumbs -->
            <div class="mb-4 pb-4" style="border-bottom: 1px solid #eee;">
                <p class="breadcrumbs mb-2">
                    <span class="mr-2"><a href="{{ lroute('home') }}" style="color: #666; font-weight: 500;">{{ __('messages.home') }}</a> <span style="color: #ccc; margin: 0 5px;">/</span></span> 
                    <span class="mr-2"><a href="{{ lroute('paket-wisata') }}" style="color: #666; font-weight: 500;">{{ __('messages.tour_packages') }}</a> <span style="color: #ccc; margin: 0 5px;">/</span></span>
                    <span style="color: rgb(87, 201, 209); font-weight: 600;">{{ $package->getTranslation('package_name') }}</span>
                </p>
                <h1 class="mb-0" style="font-weight: 800; font-size: 26px; color: #222; line-height: 1.3;">{{ $package->getTranslation('package_name') }}</h1>
            </div>

            <!-- Quick Info -->
            <div class="d-flex flex-wrap mb-4 pb-3" style="border-bottom: 1px solid #eee;">
                <div class="mr-4 mb-2">
                    <span style="color: #999; font-size: 13px; font-weight: 600; display: block;">{{ __('messages.package_category') }}</span>
                    <span style="color: #222; font-weight: 700;">{{ $package->category ? $package->category->getTranslation('category_name') : __('messages.tour_packages') }}</span>
                </div>
                @if($package->tour_category)
                <div class="mr-4 mb-2">
                    <span style="color: #999; font-size: 13px; font-weight: 600; display: block;">{{ __('messages.tour_category_label') }}</span>
                    <span style="color: #222; font-weight: 700;">{{ $package->tour_category }}</span>
                </div>
                @endif
                <div class="mr-4 mb-2">
                    <span style="color: #999; font-size: 13px; font-weight: 600; display: block;">{{ __('messages.type') }}</span>
                    <span style="color: #222; font-weight: 700;">{{ $package->packageType ? $package->packageType->getTranslation('type_name') : 'Reguler' }}</span>
                </div>
                <div class="mr-4 mb-2">
                    <span style="color: #999; font-size: 13px; font-weight: 600; display: block;">{{ __('messages.duration') }}</span>
                    <span style="color: #222; font-weight: 700;"><i class="fa fa-clock-o mr-1" style="color: rgb(87, 201, 209);"></i> {{ $package->getTranslation('duration') }}</span>
                </div>
                <div class="mb-2">
                    <span style="color: #999; font-size: 13px; font-weight: 600; display: block;">{{ __('messages.city') }}</span>
                    <span style="color: #222; font-weight: 700;"><i class="fa fa-map-marker mr-1" style="color: rgb(87, 201, 209);"></i> {{ $package->city }}</span>
                </div>
            </div>

            <!-- Custom Admin Information -->
            @if($package->getTranslation('information'))
            <div class="mb-4 p-3 d-flex align-items-start" style="background-color: #e8f9fd; border-left: 4px solid rgb(87, 201, 209); border-radius: 8px; box-shadow: 0 4px 12px rgba(87, 201, 209, 0.05);">
                <i class="fa fa-info-circle mr-3 mt-1" style="color: rgb(87, 201, 209); font-size: 18px;"></i>
                <div style="width: 100%;" class="custom-admin-info">
                    <h5 class="mb-1" style="font-weight: 700; font-size: 14px; color: #17a2b8;">
                        {{ app()->getLocale() == 'id' ? 'Informasi Penting' : 'Important Information' }}
                    </h5>
                    <div style="font-size: 13px; color: #444; line-height: 1.5; font-weight: 500;">
                        {!! $package->getTranslation('information') !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Description -->
            <h3 class="mb-3" style="font-weight: 700; font-size: 22px;">{{ __('messages.description') }}</h3>
            <div style="color: #555; line-height: 1.8;">{!! $package->getTranslation('description') !!}</div>
            
            @if($package->destination)
            <div class="mt-4">
                <h3 class="mb-3" style="font-weight: 700; font-size: 20px;">{{ __('messages.destination_goal') }}</h3>
                <div style="color: #555; line-height: 1.8;">{!! $package->destination !!}</div>
            </div>
            @endif

            @if($package->meeting_point)
            <div class="mt-4 p-4" style="background-color: #f8f9fa; border-left: 4px solid rgb(87, 201, 209); border-radius: 4px;">
                <h4 style="font-weight: 700; font-size: 16px; margin-bottom: 5px;">{{ __('messages.meeting_point_title') }}</h4>
                <div style="color: #555; margin-bottom: 0;">{!! $package->getTranslation('meeting_point') !!}</div>
            </div>
            @endif

            <hr class="my-4" style="border-top: 1px solid #eee;">

            <!-- Jadwal & Itinerary -->
            @if($package->daily_schedule || $package->itinerary)
            <h3 class="mb-3" style="font-weight: 700; font-size: 20px;">{{ __('messages.itinerary') }}</h3>
            
            @if($package->daily_schedule)
            <div class="mb-4" style="color: #555; line-height: 1.8;">
                {!! $package->getTranslation('daily_schedule') !!}
            </div>
            @endif
 
            @if($package->itinerary)
            <div class="itinerary-box p-4" style="background-color: #fcfcfc; border: 1px solid #eee; border-radius: 12px; color: #555; line-height: 1.8;">
                {!! $package->getTranslation('itinerary') !!}
            </div>
            @endif
            <hr class="my-4" style="border-top: 1px solid #eee;">
            @endif

            <!-- Facilities -->
            <div class="row">
                @if($package->facilities_included)
                <div class="col-md-6 mb-4">
                    <h3 class="mb-3" style="font-weight: 700; font-size: 18px; color: #28a745;"><i class="fa fa-check-circle mr-2"></i>{{ __('messages.included') }}</h3>
                    <div style="color: #555; line-height: 1.8;">
                        {!! $package->getTranslation('facilities_included') !!}
                    </div>
                </div>
                @endif
                
                @if($package->facilities_excluded)
                <div class="col-md-6 mb-4">
                    <h3 class="mb-3" style="font-weight: 700; font-size: 18px; color: #dc3545;"><i class="fa fa-times-circle mr-2"></i>{{ __('messages.excluded') }}</h3>
                    <div style="color: #555; line-height: 1.8;">
                        {!! $package->getTranslation('facilities_excluded') !!}
                    </div>
                </div>
                @endif
            </div>

            @if($package->persyaratan)
            <hr class="my-4" style="border-top: 1px solid #eee;">
            <div class="mt-4">
                <h3 class="mb-3" style="font-weight: 700; font-size: 18px;"><i class="fa fa-info-circle mr-2" style="color: #ffc107;"></i>{{ __('messages.terms') }}</h3>
                <div style="color: #555; line-height: 1.8; font-size: 14px;">
                    {!! $package->getTranslation('persyaratan') !!}
                </div>
            </div>
            @endif

        </div>
      </div> <!-- .col-md-8 -->

      <!-- Kanan: Sidebar Harga & Booking -->
      <div class="col-lg-4 sidebar ftco-animate">
        <div class="sidebar-box p-4 shadow-sm" style="background: #fff; border-radius: 16px; border: 1px solid rgba(0,0,0,0.05); position: sticky; top: 100px;" x-data="{ priceType: 'local' }">
            <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 20px; text-align: center; color: #222;">{{ __('messages.book_now') }}</h3>
            
            <!-- Price Type Toggle -->
            <div class="d-flex p-1 bg-light rounded mb-4" style="border: 1px solid #ddd; background-color: #f0f0f0 !important;">
                <button type="button" @click="priceType = 'local'" 
                    :style="priceType === 'local' ? 'background-color: #fff; color: rgb(87, 201, 209); box-shadow: 0 4px 10px rgba(0,0,0,0.1); font-weight: 700;' : 'color: #777; font-weight: 500;'"
                    class="btn btn-sm flex-fill py-2 px-1 border-0" style="font-size: 12px; transition: all 0.3s ease-in-out; border-radius: 8px;">
                    {{ __('messages.local_tourist') }}
                </button>
                <button type="button" @click="priceType = 'foreign'" 
                    :style="priceType === 'foreign' ? 'background-color: #fff; color: rgb(87, 201, 209); box-shadow: 0 4px 10px rgba(0,0,0,0.1); font-weight: 700;' : 'color: #777; font-weight: 500;'"
                    class="btn btn-sm flex-fill py-2 px-1 border-0" style="font-size: 12px; transition: all 0.3s ease-in-out; border-radius: 8px;">
                    {{ __('messages.foreign_tourist') }}
                </button>
            </div>

            <div class="price-breakdown mb-4">
                <!-- Local Prices -->
                <template x-if="priceType === 'local'">
                    <div>
                        @foreach([1,2,3,4,5,8,10] as $pax)
                            @if($package->{'price_'.$pax.'pax'})
                            <div class="d-flex justify-content-between mb-2 pb-2" style="border-bottom: 1px dashed #eee;">
                                <span style="color: #666;">{{ __('messages.person_plural', ['count' => $pax]) }}</span>
                                <span style="font-weight: 700; color: #000;">Rp {{ number_format($package->{'price_'.$pax.'pax'}, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </template>

                <!-- Foreign Prices -->
                <template x-if="priceType === 'foreign'">
                    <div>
                        @foreach([1,2,3,4,5,8,10] as $pax)
                            @if($package->{'price_'.$pax.'pax_foreign'})
                            <div class="d-flex justify-content-between mb-2 pb-2" style="border-bottom: 1px dashed #eee;">
                                <span style="color: #666;">{{ __('messages.person_plural_en', ['count' => $pax]) }}</span>
                                <span style="font-weight: 700; color: #000;">Rp {{ number_format($package->{'price_'.$pax.'pax_foreign'}, 0, ',', '.') }}</span>
                            </div>
                            @else
                                {{-- Fallback to local if foreign not set, or show notice --}}
                                @if($package->{'price_'.$pax.'pax'})
                                <div class="d-flex justify-content-between mb-2 pb-2" style="border-bottom: 1px dashed #eee;">
                                    <span style="color: #666;">{{ __('messages.person_plural_en', ['count' => $pax]) }}</span>
                                    <span style="font-weight: 700; color: #000;">Rp {{ number_format($package->{'price_'.$pax.'pax'}, 0, ',', '.') }}</span>
                                </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </template>
            </div>

            <div class="form-group mb-0">
                <a href="{{ route('checkout.index', ['locale' => app()->getLocale(), 'slug' => $package->slug]) }}" class="btn btn-primary py-3 px-4 d-block w-100" style="border-radius: 30px; font-weight: 700; background-color: rgb(87, 201, 209); border: none; box-shadow: 0 4px 15px rgba(87, 201, 209, 0.4);">{{ __('messages.book_now') }}</a>
            </div>
            
            <p class="text-center mt-3" style="font-size: 12px; color: #999;">{{ __('messages.special_offer') }}</p>
        </div>

      </div>

    </div>
  </div>
</section>

<!-- Related Packages -->
@if($relatedPackages->count() > 0)
<section class="ftco-section border-top">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section text-center ftco-animate">
                <h2 class="mb-4" style="font-weight: 800;">{{ __('messages.related_packages') }}</h2>
            </div>
        </div>
        <div class="row">
            @foreach($relatedPackages as $related)
                <div class="col-md-4 ftco-animate mb-4">
                    @include('paket.card', ['package' => $related])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
    /* Styling khusus untuk konten hasil editor */
    .itinerary-box strong, .itinerary-box b,
    .ftco-section strong, .ftco-section b {
        font-weight: 900 !important;
        color: #000 !important;
    }
    
    .itinerary-box ul, .ftco-section ul, .custom-admin-info ul {
        margin-bottom: 1.5rem;
    }
    
    .itinerary-box p, .ftco-section p, .custom-admin-info p {
        margin-bottom: 1rem;
    }
</style>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
