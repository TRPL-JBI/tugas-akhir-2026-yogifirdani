@extends('template')
@section('content')

    <div class="hero-wrap" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}'); background-size: cover; background-position: center; height: 50vh; min-height: 400px;">
      <div class="overlay"></div>
      <div class="container" style="height: 100%;">
        <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 100%;" data-scrollax-parent="true">
          <div class="col-md-9 text-center" data-scrollax=" properties: { translateY: '70%' }">
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
              <span class="mr-2"><a href="{{ lroute('home') }}">{{ __('messages.home') }}</a></span>
              <span>{{ __('messages.rec_page_title') }}</span>
            </p>
            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
              {{ __('messages.rec_page_heading') }}
            </h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section bg-white">
      <div class="container">

        <!-- Notification Alerts -->
        @if(session('error'))
            <div class="row justify-content-center mb-4">
                <div class="col-md-7 col-lg-6">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 8px; font-size: 14px;">
                        <i class="fa fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Form Pencarian Rekomendasi -->
        <div class="row justify-content-center mb-4 mt-2">
          <div class="col-md-8 text-center heading-section ftco-animate">
            <h2 class="mb-4" style="font-weight: 800; color: #000; font-size: 32px;">
              {{ __('messages.rec_main_heading') }}
            </h2>
          </div>
        </div>

        <div class="row justify-content-center mb-5 pb-4" id="recommendation-form">
            <div class="col-md-10 col-lg-8 ftco-animate">
                <div class="p-4 p-md-5" style="border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 15px 35px rgba(0,0,0,0.05); border-radius: 16px; background: #fff;">
                    <form id="recForm" action="{{ lroute('recommendation.post') }}" method="POST" style="background: transparent;">
                        @csrf
                        
                        <div class="row">
                            <!-- Budget -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="budget_display" style="font-weight: 700; color: #000; font-size: 13px; margin-bottom: 8px; display: block;">
                                      {{ __('messages.rec_label_budget') }} (IDR)
                                    </label>
                                    <input type="text" id="budget_display" class="form-control @error('budget') is-invalid @enderror"
                                           value="{{ old('budget', isset($preference) ? $preference->budget : '') }}"
                                           placeholder="{{ __('messages.rec_placeholder_budget') }}"
                                           style="border-radius: 6px; font-size: 14px; height: 50px !important; border: 1px solid #ccc; background: #fff; padding-left: 15px;" required>
                                    <input type="hidden" id="budget" name="budget" value="{{ old('budget', isset($preference) ? $preference->budget : '') }}">
                                    @error('budget')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kategori Wisata -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="tour_category" style="font-weight: 700; color: #000; font-size: 13px; margin-bottom: 8px; display: block;">
                                      {{ __('messages.rec_label_category') }}
                                    </label>
                                    <select id="tour_category" name="tour_category" class="form-control @error('tour_category') is-invalid @enderror" 
                                            style="border-radius: 6px; font-size: 14px; height: 50px !important; border: 1px solid #ccc; background: #fff; padding-left: 15px;" required>
                                        <option value="">-- {{ app()->getLocale() == 'en' ? 'Select Tour Category' : 'Pilih Kategori Wisata' }} --</option>
                                        <option value="Culture Trip" {{ old('tour_category', isset($preference) ? $preference->tour_category : '') == 'Culture Trip' ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'en' ? 'Culture Trip (Cultural Tour)' : 'Culture Trip (Wisata Budaya)' }}
                                        </option>
                                        <option value="Nature Trip" {{ old('tour_category', isset($preference) ? $preference->tour_category : '') == 'Nature Trip' ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'en' ? 'Nature Trip (Nature Tour)' : 'Nature Trip (Wisata Alam)' }}
                                        </option>
                                        <option value="Culinary Trip" {{ old('tour_category', isset($preference) ? $preference->tour_category : '') == 'Culinary Trip' ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'en' ? 'Culinary Trip (Culinary Tour)' : 'Culinary Trip (Wisata Kuliner)' }}
                                        </option>
                                        <option value="Adventure Trip" {{ old('tour_category', isset($preference) ? $preference->tour_category : '') == 'Adventure Trip' ? 'selected' : '' }}>
                                            {{ app()->getLocale() == 'en' ? 'Adventure Trip (Adventure Tour)' : 'Adventure Trip (Wisata Petualangan)' }}
                                        </option>
                                    </select>
                                    @error('tour_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Fasilitas Yang Diinginkan -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="facilities" style="font-weight: 700; color: #000; font-size: 13px; margin-bottom: 8px; display: block;">
                                      {{ __('messages.rec_label_facility') }}
                                    </label>
                                    <input type="text" id="facilities" name="facilities" class="form-control @error('facilities') is-invalid @enderror"
                                           value="{{ old('facilities', isset($preference) ? $preference->preferred_facilities : '') }}"
                                           placeholder="{{ __('messages.rec_placeholder_facility') }}"
                                           style="border-radius: 6px; font-size: 14px; height: 50px !important; border: 1px solid #ccc; background: #fff; padding-left: 15px;" required>
                                    @error('facilities')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Durasi Perjalanan -->
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="duration" style="font-weight: 700; color: #000; font-size: 13px; margin-bottom: 8px; display: block;">
                                      {{ __('messages.rec_label_duration') }}
                                    </label>
                                    <input type="text" id="duration" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                           value="{{ old('duration', isset($preference) ? $preference->preferred_duration : '') }}"
                                           placeholder="{{ __('messages.rec_placeholder_duration') }}"
                                           style="border-radius: 6px; font-size: 14px; height: 50px !important; border: 1px solid #ccc; background: #fff; padding-left: 15px;" required>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Preferensi / Tambahan -->
                        <div class="form-group mb-5">
                            <label for="description" style="font-weight: 700; color: #000; font-size: 13px; margin-bottom: 8px; display: block;">
                              {{ __('messages.rec_label_description') }}
                            </label>
                            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror"
                                      placeholder="{{ __('messages.rec_placeholder_description') }}"
                                      style="border-radius: 6px; font-size: 14px; min-height: 100px; border: 1px solid #ccc; background: #fff; padding-left: 15px; padding-top: 12px; resize: vertical;">{{ old('description', isset($preference) ? $preference->description : '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group mt-3 mb-0 text-center">
                            <button id="submitBtn" type="submit" class="btn transition-all duration-300 w-100 px-5"
                                    style="background-color: rgb(87, 201, 209); color: #fff; border-radius: 6px; font-weight: 700; height: 55px; font-size: 15px; border: none; box-shadow: 0 4px 15px rgba(87, 201, 209, 0.3);">
                              <span id="btnText"><i class="fa fa-search mr-2"></i> {{ __('messages.rec_btn_search') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('styles')
        <style>
        .rec-loader {
          width: 70px;
          height: 70px;
          border-radius: 50%;
          display: inline-block;
          border-top: 5px solid rgb(87, 201, 209);
          border-right: 5px solid transparent;
          box-sizing: border-box;
          animation: rotation 1s linear infinite;
          margin-bottom: 30px;
          position: relative;
        }
        .rec-loader::after {
          content: '';  
          box-sizing: border-box;
          position: absolute;
          left: -5px;
          top: -5px;
          width: 70px;
          height: 70px;
          border-radius: 50%;
          border-left: 5px solid #ffccb3;
          border-bottom: 5px solid transparent;
          animation: rotation 0.5s linear infinite reverse;
        }
        @keyframes rotation {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }
        .fade-in-overlay {
          animation: fadeIn 0.4s ease-in-out forwards;
        }
        @keyframes fadeIn {
          0% { opacity: 0; visibility: hidden; }
          100% { opacity: 1; visibility: visible; }
        }
        </style>
        @endpush

        <!-- Fullscreen Loading Overlay -->
        <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(255, 255, 255, 0.5); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); z-index: 100000; justify-content: center; align-items: center; flex-direction: column; text-align: center;">
            <div class="rec-loader"></div>
            <h2 style="font-weight: 800; color: #222; margin-bottom: 15px; font-size: 32px; text-shadow: 0 0 10px rgba(255,255,255,0.8);">
                {{ app()->getLocale() == 'en' ? 'AI is Processing...' : 'AI Sedang Memproses...' }}
            </h2>
            <p style="color: #444; font-size: 18px; font-weight: 600; max-width: 500px; line-height: 1.6; padding: 0 20px; text-shadow: 0 0 10px rgba(255,255,255,0.8);">
                {{ app()->getLocale() == 'en' 
                    ? 'Please wait a moment while we search for the best tour packages that perfectly match your desires.' 
                    : 'Mohon tunggu sebentar, kami masih mencari paket wisata yang paling sesuai dengan keinginan Anda.' }}
            </p>
        </div>

        @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var form = document.getElementById('recForm');
                if(form) {
                    form.addEventListener('submit', function() {
                        // Tampilkan Loading Overlay Layar Penuh
                        var overlay = document.getElementById('loadingOverlay');
                        overlay.style.display = 'flex';
                        overlay.classList.add('fade-in-overlay');
                        
                        // Disable tombol submit agar tidak diklik dua kali (opsional tapi disarankan)
                        var btn = document.getElementById('submitBtn');
                        if(btn) {
                            btn.disabled = true;
                            btn.style.opacity = '0.7';
                        }
                    });
                }
            });
        </script>
        @endpush

        <!-- Hasil Rekomendasi -->
        @if(isset($packages))
            <div id="recommendation-results"></div>
            <hr class="my-5" style="border-top: 1px solid rgba(0,0,0,0.06);">
            
            <div class="row justify-content-center mb-5 pb-3">
              <div class="col-md-8 text-center heading-section ftco-animate">
                <h2 class="mb-2" style="font-weight: 800; color: #000; font-size: 30px;">
                  {{ __('messages.rec_results_heading') }}
                </h2>
                <p style="font-size: 14px; color: #777;">
                  {{ app()->getLocale() == 'en' 
                     ? 'Based on your preferences, here are the top matching tour packages found by our AI recommender:' 
                     : 'Berdasarkan preferensi Anda, berikut adalah paket wisata paling cocok yang ditemukan oleh AI rekomendasi kami:' }}
                </p>
              </div>
            </div>

            @if($packages->isEmpty())
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center py-4">
                        <div style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;">
                            <i class="fa fa-folder-open-o"></i>
                        </div>
                        <h4 style="font-weight: 600; color: #475569;">
                            {{ app()->getLocale() == 'en' ? 'No recommendations found' : 'Tidak ada rekomendasi yang ditemukan' }}
                        </h4>
                        <p style="color: #64748b; font-size: 14px;">
                            {{ app()->getLocale() == 'en' 
                               ? 'Try adjusting your search filters or budget limit to discover more tour packages.' 
                               : 'Coba sesuaikan filter pencarian atau batas budget Anda untuk menemukan lebih banyak paket wisata.' }}
                        </p>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($packages as $package)
                        <div class="col-sm-6 col-md-4 ftco-animate mb-4 d-flex align-items-stretch">
                            @include('paket.card', ['package' => $package])
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

      </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Format Rupiah untuk Input Budget
        const budgetDisplay = document.getElementById('budget_display');
        const budgetHidden = document.getElementById('budget');

        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        if (budgetDisplay && budgetHidden) {
            // Format value on load (misal setelah validasi error atau ada value lama)
            if (budgetDisplay.value) {
                budgetDisplay.value = formatRupiah(budgetDisplay.value);
            }

            budgetDisplay.addEventListener('input', function(e) {
                let formatted = formatRupiah(this.value);
                this.value = formatted;
                // Simpan angka aslinya (tanpa titik) ke input hidden untuk dikirim ke backend
                budgetHidden.value = formatted.replace(/\./g, '');
            });
        }
    });
</script>

@if(isset($packages) || $errors->any() || session('error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Jika ada hasil rekomendasi, scroll ke hasilnya.
        // Jika ada error (karena input ngawur), scroll kembali ke form.
        const targetId = "{{ $errors->any() || session('error') ? 'recommendation-form' : 'recommendation-results' }}";
        const target = document.getElementById(targetId);
        
        if (target) {
            // Memberikan sedikit jeda agar DOM benar-benar siap dan animasi navbar selesai
            setTimeout(() => {
                const y = target.getBoundingClientRect().top + window.scrollY - 100; // Offset 100px untuk navbar
                window.scrollTo({top: y, behavior: 'smooth'});
            }, 300);
        }
    });
</script>
@endif
@endpush
