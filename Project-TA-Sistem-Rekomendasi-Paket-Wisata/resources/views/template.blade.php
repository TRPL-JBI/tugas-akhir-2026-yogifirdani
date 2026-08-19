<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-gramm="false" data-gramm_editor="false" data-enable-grammarly="false">
  <head>
    <title>Kutamasya.id</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="preconnect" href="https://themewagon.github.io">

    <!-- Preload Critical Largest Contentful Paint (LCP) Hero Image -->
    @if(request()->is(app()->getLocale()) || request()->is(app()->getLocale().'/') || request()->is('/'))
    <link rel="preload" href="{{ asset('images/background/jungle-island.webp') }}" as="image" type="image/webp" fetchpriority="high">
    @endif

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Alex+Brush&display=swap" rel="stylesheet">
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Preload Critical CSS -->
    <link rel="preload" href="{{ asset('asset/css/style.min.css') }}" as="style">
    <link rel="preload" href="{{ asset('asset/css/bootstrap.min.css') }}" as="style">

    <!-- Critical CSS (Load immediately) -->
    <link rel="stylesheet" href="{{ asset('asset/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.min.css') }}">
    
    <!-- Non-Critical CSS (Deferred loading) -->
    <link rel="preload" href="{{ asset('asset/css/animate.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('asset/css/owl.carousel.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('asset/css/owl.theme.default.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('asset/css/aos.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('asset/css/ionicons.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('asset/css/flaticon.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="preload" href="{{ asset('asset/css/icomoon.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    
    <noscript>
        <link rel="stylesheet" href="{{ asset('asset/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/aos.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('asset/css/icomoon.css') }}">
    </noscript>

    <style>
      /* Override warna tombol utama (primary) Bootstrap secara global sesuai tema brand */
      .btn-primary {
        background-color: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        color: #ffffff !important;
        transition: all 0.3s ease !important;
      }
      .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
        background-color: rgb(68, 189, 199) !important;
        border-color: rgb(68, 189, 199) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(87, 201, 209, 0.4) !important;
      }
      .btn-outline-primary {
        color: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        background-color: transparent !important;
        transition: all 0.3s ease !important;
      }
      .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active {
        background-color: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        color: #ffffff !important;
      }

      /* Efek Transparan / Kaca (Glassmorphism) untuk Dropdown */
      .ftco-navbar-light .navbar-nav .nav-item .dropdown-menu {
        background-color: rgba(255, 255, 255, 0.73) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        min-width: auto;
        padding: 0.25rem 0;
      }
      .ftco-navbar-light .navbar-nav .nav-item .dropdown-menu .dropdown-item {
        color: #333333 !important;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.4rem 1.2rem;
        gap: 15px;
      }
      /* Warna saat kursor diarahkan (hover) - lebih muda */
      .ftco-navbar-light .navbar-nav .nav-item .dropdown-menu .dropdown-item:hover {
        background-color: #70d4deff !important;
        color: #ffffff !important;
      }

      /* Warna saat berada di halaman tersebut (active) - lebih tua */
      .ftco-navbar-light .navbar-nav .nav-item .dropdown-menu .dropdown-item.active {
        background-color: rgb(68, 189, 199) !important;
        color: #ffffff !important;
      }

      /* Hover warna untuk semua link menu navbar (baik saat scroll maupun tidak) */
      .ftco_navbar .navbar-nav .nav-link:hover {
        color: rgb(87, 201, 209) !important;
      }
      
      /* Pastikan warna active juga konsisten (opsional, tapi disarankan) */
      .ftco_navbar .navbar-nav .nav-item.active .nav-link {
        color: rgb(87, 201, 209) !important;
      }

      /* Gaya tombol Register (CTA) Global */
      .ftco_navbar .navbar-nav .nav-item.cta > .nav-link {
        background: transparent !important; /* Hapus background bawaan tema */
        border: none !important;
      }
      .ftco_navbar .navbar-nav .nav-item.cta > .nav-link span {
        padding: 5px 20px !important;
        border-radius: 30px !important;
        display: inline-block !important;
        transition: all 0.3s ease;
      }

      /* Saat TIDAK di-scroll (Navbar Transparan) */
      .ftco_navbar:not(.scrolled) .navbar-nav .nav-item.cta > .nav-link span {
        background: rgb(68, 189, 199) !important;
        border: 1px solid rgb(68, 189, 199) !important;
        color: #fff !important;
      }

      /* Saat DI-scroll (Navbar Putih) */
      .ftco_navbar.scrolled .navbar-nav .nav-item.cta > .nav-link span {
        background: rgb(68, 189, 199) !important;
        border: 1px solid rgb(68, 189, 199) !important;
        color: #fff !important;
      }
      
      /* Hover untuk tombol Register (Semua Kondisi) */
      .ftco_navbar .navbar-nav .nav-item.cta > .nav-link:hover span {
        background: #70d4de !important;
        border-color: #70d4de !important;
        color: #fff !important;
      }

      /* Logika untuk Nested Dropdown (Submenu) */
      .dropdown-submenu {
        position: relative;
      }
      .dropdown-submenu > .dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: -6px;
        margin-left: 0;
        display: none !important;
      }
      .dropdown-submenu:hover > .dropdown-menu {
        display: block !important;
      }

      /* Global CTA (Register) Button Styling */
      .navbar-nav .nav-item.cta .nav-link:hover {
        background: transparent !important;
      }
      .navbar-nav .nav-item.cta .nav-link:hover span {
        background: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        color: #fff !important;
      }

      /* Custom Menu Tengah (Rapet) */
      .center-nav .nav-link {
        padding-left: 12px !important;
        padding-right: 12px !important;
      }

      /* Teks Menu Putih Jelas sebelum di-scroll (Hanya Desktop) */
      @media (min-width: 992px) {
        .ftco-navbar-light:not(.scrolled) .navbar-nav > .nav-item > .nav-link {
          color: #ffffff !important;
          opacity: 1 !important;
          font-weight: 500;
        }
      }

      /* Navbar Transparan di Semua Layar (Desktop & Mobile) sebelum di-scroll */
      .ftco-navbar-light:not(.scrolled) {
        background: transparent !important;
        position: absolute !important;
        top: 0;
        left: 0;
        right: 0;
        z-index: 99;
      }

      /* Perbaikan Navbar Hitam di Mobile (di bawah 992px) */
      @media (max-width: 991.98px) {
        
        /* Perkecil ukuran logo di mobile/tablet (Disempurnakan agar sedikit lebih besar) */
        .navbar-brand img {
          height: 44px !important;
          padding: 3px !important;
        }

        /* Ukuran logo sedikit lebih besar di Tablet */
        @media (min-width: 768px) {
          .navbar-brand img {
            height: 48px !important;
            padding: 4px !important;
          }
        }

        /* Berikan background putih transparan/kaca untuk isi menu saat dibuka */
        .ftco-navbar-light .navbar-collapse {
          background: rgba(255, 255, 255, 0.95) !important;
          border-radius: 10px;
          padding: 15px;
          margin-top: 10px;
          box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        /* Ubah warna teks menu di HP jadi gelap agar terbaca di background putih */
        .ftco-navbar-light .navbar-nav > .nav-item > .nav-link {
          color: #333333 !important;
        }
        .ftco-navbar-light .navbar-nav > .nav-item.active > .nav-link {
          color: rgb(87, 201, 209) !important;
        }
        /* Pastikan dropdown menu tampil wajar di mobile (tidak tumpang tindih) */
        .ftco-navbar-light .navbar-nav .nav-item .dropdown-menu {
          position: relative !important;
          float: none !important;
          background: transparent !important;
          border: none !important;
          box-shadow: none !important;
          padding-left: 15px;
          margin-top: 0;
        }
        .ftco-navbar-light .navbar-nav .nav-item .dropdown-menu .dropdown-item {
          color: #555 !important;
          padding: 8px 15px;
        }
      }

      .ftco_navbar {
        z-index: 9999 !important;
      }

      /* Fix conflict between Tailwind and Bootstrap collapse */
      @media (max-width: 991.98px) {
        .navbar-collapse:not(.show):not(.collapsing) {
          display: none !important;
        }
        .navbar-collapse.collapsing,
        .navbar-collapse.show {
          display: block !important;
        }
      }
      @media (min-width: 992px) {
        .navbar-expand-lg .navbar-collapse {
          display: flex !important;
          visibility: visible !important;
        }
      }
      .dropdown-toggle::after {
        display: none !important;
      }

      /* Ganti global navigasi owl-carousel dengan Font Awesome & Warna Tema kita */
      .owl-carousel .owl-prev span,
      .owl-carousel .owl-next span {
        display: none !important;
      }
      .owl-carousel .owl-prev::before {
        content: "\f053" !important; /* fa-chevron-left */
        font-family: "FontAwesome" !important;
        font-size: 16px;
        color: rgb(87, 201, 209) !important;
      }
      .owl-carousel .owl-next::before {
        content: "\f054" !important; /* fa-chevron-right */
        font-family: "FontAwesome" !important;
        font-size: 16px;
        color: rgb(87, 201, 209) !important;
      }
      .owl-carousel .owl-nav .owl-prev,
      .owl-carousel .owl-nav .owl-next {
        border: 1.5px solid rgb(87, 201, 209) !important;
        background: rgba(255, 255, 255, 0.9) !important;
        border-radius: 50% !important;
        width: 40px !important;
        height: 40px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05) !important;
      }
      .owl-carousel .owl-nav .owl-prev:hover,
      .owl-carousel .owl-nav .owl-next:hover {
        background: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
      }
      .owl-carousel .owl-nav .owl-prev:hover::before,
      .owl-carousel .owl-nav .owl-next:hover::before {
        color: #fff !important;
      }
    </style>
    @stack('styles')
  </head>
  <body data-gramm="false" data-instant-intensity="viewport-all">
    
    @include('partials.navbar')
    
    @yield('content')
	

    <footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2 d-flex align-items-center">
                <img src="{{ asset('asset/images/Logo-kutamasya.webp') }}" alt="Kutamasya Logo" style="height: 40px; width: auto; margin-right: 10px; border-radius: 5px;" width="120" height="40" loading="lazy">
                <span style="color: #fff; font-weight: 700; font-size: 24px;">Kutamasya.id</span>
              </h2>
              <p>{{ __('messages.footer_desc') }}</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="https://www.instagram.com/kutamasya.id?igsh=MTZ6ZjNjbzhpamZyMA%3D%3D&utm_source=qr" aria-label="Instagram"><span class="fa fa-instagram"></span></a></li>
                <li class="ftco-animate"><a href="https://www.tiktok.com/@kutamasya.id?_r=1&_d=f2eb15cabjedbm&sec_uid=MS4wLjABAAAAMcuwe0Cs3XEXLIc6VEed7Du5ICflShyExGzWijcy5YsRohJqoHMYsq-C7D6rLA-J&share_author_id=7572947196175942674&sharer_language=id&source=h5_t&u_code=f0d08ae1k22676&item_author_type=1&utm_source=copy&tt_from=copy&enable_checksum=1&utm_medium=ios&share_link_id=6C33D439-6B51-40E2-9644-856C61AFB3B1&user_id=7572947196175942674&sec_user_id=MS4wLjABAAAAMcuwe0Cs3XEXLIc6VEed7Du5ICflShyExGzWijcy5YsRohJqoHMYsq-C7D6rLA-J&social_share_type=4&ug_btm=b0,b0&utm_campaign=client_share&share_app_id=1180" target="_blank" aria-label="TikTok" style="position: relative;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width: 20px; height: 20px; fill: white; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);"><path d="M448 209.91a210.06 210.06 0 0 1-122.77-39.25V349.38A162.55 162.55 0 1 1 162.6 186.29v86.37a76.15 76.15 0 1 0 86.37 75.39V0h86.37a122.61 122.61 0 0 0 112.66 112.66z"/></svg></a></li>
                <li class="ftco-animate"><a href="#" aria-label="YouTube"><span class="fa fa-youtube-play"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">{{ __('messages.our_services') }}</h2>
              <ul class="list-unstyled">
                <li><a href="{{ lroute('paket-wisata') }}?tipe=open-trip-banyuwangi" class="py-2 d-block">Open Trip Banyuwangi</a></li>
                <li><a href="{{ lroute('paket-wisata') }}?tipe=one-day-trip-banyuwangi" class="py-2 d-block">One Day Trip</a></li>
                <li><a href="{{ lroute('paket-wisata') }}?tipe=private-trip" class="py-2 d-block">Private Trip</a></li>
                <li><a href="{{ lroute('paket-wisata') }}?tipe=paket-kawah-ijen" class="py-2 d-block">Paket Kawah Ijen</a></li>
                <li><a href="{{ lroute('paket-wisata') }}?tipe=paket-menjangan" class="py-2 d-block">Paket Menjangan</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">{{ __('messages.quick_links') }}</h2>
              <ul class="list-unstyled">
                <li><a href="{{ lroute('home') }}" class="py-2 d-block">{{ __('messages.home') }}</a></li>
                <li><a href="{{ lroute('paket-wisata') }}" class="py-2 d-block">{{ __('messages.tour_packages') }}</a></li>
                <li><a href="{{ lroute('recommendation') }}" class="py-2 d-block">{{ __('messages.recommendation') }}</a></li>
                <li><a href="{{ lroute('article') }}" class="py-2 d-block">{{ __('messages.article') }}</a></li>
                <li><a href="{{ lroute('contact') }}" class="py-2 d-block">{{ __('messages.contact') }}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">{{ __('messages.have_questions') }}</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon fa fa-map-marker"></span><span class="text">Jl.Raya Watukebo Kec. Blimbingsari Kab. Banyuwangi</span></li>
	                <li><a href="#"><span class="icon fa fa-phone"></span><span class="text">+62 823 5789 6912</span></a></li>
	                <li><a href="#"><span class="icon fa fa-envelope"></span><span class="text">kutamasya@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p>
  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | <a href="{{ url('/') }}">Kutamasya.id</a>
            </p>
          </div>
        </div>
      </div>
    </footer>
    
  

  <!-- loader -->
  <div id="ftco-loader" class="fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="{{ asset('asset/js/jquery.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/jquery-migrate-3.0.1.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/popper.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/bootstrap.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/jquery.easing.1.3.js') }}" defer></script>
  <script src="{{ asset('asset/js/jquery.waypoints.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/owl.carousel.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/aos.js') }}" defer></script>
  <script src="{{ asset('asset/js/jquery.animateNumber.min.js') }}" defer></script>
  <script src="{{ asset('asset/js/main.js') }}" defer></script>
  
  <!-- Fix: Navbar mobile burger tidak langsung menutup -->
  <script>
    // Gunakan window.load agar dijamin berjalan SETELAH main.js (defer) selesai
    window.addEventListener('load', function() {
      function fixMobileNavbar() {
        if (window.innerWidth < 992) {
          // Lepas event hover mouseenter/mouseleave yang dipasang main.js
          // karena di mobile/touchscreen langsung mentrigger mouseleave
          // sehingga menu dropdown menutup sendiri
          if (typeof jQuery !== 'undefined') {
            jQuery('nav .dropdown').off('mouseenter mouseleave');
          }
        }
      }

      fixMobileNavbar();
      window.addEventListener('resize', fixMobileNavbar);
    });
  </script>


    


  
  <!-- INI BAGIAN WHATSAPP YANG MUNCUL DI BAWAH KANAN -->
  <!-- Floating WhatsApp Widget -->
  <div class="whatsapp-floating-widget" style="position: fixed; bottom: 25px; right: 25px; z-index: 9999; display: flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif;">
      <!-- Chat Pill (Tooltip) -->
      <a href="https://wa.me/6282357896912?text=Halo%20Kaka,%20saya%20ingin%20tanya%20tentang%20paket%20wisata" target="_blank" rel="noopener noreferrer" aria-label="Tanya kami via WhatsApp" class="whatsapp-chat-pill" style="background: white; border: 1px solid rgba(0,0,0,0.08); padding: 8px 16px; border-radius: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); font-size: 11px; font-weight: 600; color: #333; text-decoration: none; display: flex; align-items: center; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); transform-origin: right center; animation: pulseGlow 2s infinite;">
          {{ __('messages.whatsapp_chat_pill') }}
      </a>
      
      <!-- WhatsApp Icon Button -->
      <a href="https://wa.me/6282357896912?text=Halo%20Kaka,%20saya%20ingin%20tanya%20tentang%20paket%20wisata" target="_blank" rel="noopener noreferrer" aria-label="Hubungi kami melalui WhatsApp" class="whatsapp-btn" style="background-color: #25d366; width: 50px; height: 50px; border-radius: 50px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3); transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); text-decoration: none;">
          <i class="fa fa-whatsapp"></i>
      </a>
  </div>

  <style>
      /* Hover & Animation effects for the WhatsApp widget */
      .whatsapp-floating-widget:hover .whatsapp-btn {
          transform: scale(1.1) rotate(8deg);
          box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
      }
      
      .whatsapp-floating-widget:hover .whatsapp-chat-pill {
          transform: scale(1.05);
          box-shadow: 0 6px 20px rgba(0,0,0,0.1);
          border-color: rgba(37, 211, 102, 0.3);
          color: #25d366;
      }

      @keyframes pulseGlow {
          0% {
              box-shadow: 0 4px 15px rgba(0,0,0,0.06);
          }
          50% {
              box-shadow: 0 4px 20px rgba(37, 211, 102, 0.15);
              border-color: rgba(37, 211, 102, 0.2);
          }
          100% {
              box-shadow: 0 4px 15px rgba(0,0,0,0.06);
          }
      }

      /* Responsive styling for mobile screens */
      @media (max-width: 575.98px) {
          .whatsapp-floating-widget {
              bottom: 20px !important;
              right: 20px !important;
              gap: 8px !important;
          }
          .whatsapp-btn {
              width: 44px !important;
              height: 44px !important;
              font-size: 20px !important;
          }
          .whatsapp-chat-pill {
              padding: 6px 12px !important;
              font-size: 10px !important;
          }
      }
  </style>
<!-- INI BAGIANAKHIR DARI WHATSAPP -->

  @stack('scripts')

  <!-- INSTANT PAGE PRELOADER: Makes page loading instantaneous by prefetching HTML on hover -->
  <script src="{{ asset('asset/js/instantpage.js') }}" type="module" defer></script>
  </body>
</html>
