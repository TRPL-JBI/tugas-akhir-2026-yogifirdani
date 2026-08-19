<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar ftco-navbar-light" id="ftco-navbar" style="z-index: 9999 !important;">
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}" style="padding: 5px 0;">
        <img src="{{ asset('asset/images/Logo-kutamasya.webp') }}" 
             alt="Kutamasya Logo" 
             style="height: 50px; width: auto; border-radius: 5px;" 
             width="150" 
             height="50">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation" style="padding: 7px 11px; border: none; outline: none; background: transparent; color: inherit;">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="3" y1="12" x2="21" y2="12"></line>
          <line x1="3" y1="6" x2="21" y2="6"></line>
          <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
      </button>

      <div class="collapse navbar-collapse" id="ftco-nav">
        <!-- Menu Utama di Tengah -->
        <ul class="navbar-nav mx-auto center-nav">
          <li class="nav-item {{ request()->is(app()->getLocale()) || request()->is(app()->getLocale().'/') ? 'active' : '' }}"><a href="{{ lroute('home') }}" class="nav-link">{{ __('messages.home') }}</a></li>          
          <li class="nav-item {{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ lroute('about') }}" class="nav-link">{{ __('messages.about') }}</a></li>
          <li class="nav-item dropdown {{ request()->routeIs('paket-wisata') ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownPaketWisata" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ __('messages.tour_packages') }} <i class="fa fa-chevron-down" style="font-size: 10px; margin-left: 5px;"></i>
            </a>
            
            <div class="dropdown-menu mega-menu-dropdown shadow-lg border-0" aria-labelledby="dropdownPaketWisata">
              <div class="mega-menu-container">
                <!-- Left Sidebar for Categories (Bab) -->
                <div class="mega-menu-sidebar">
                  
                  <!-- 1. Ekonomis Trip -->
                  <div class="mega-menu-item active" data-target="sub-ekonomis">
                    <div class="menu-item-content">
                      <span class="menu-item-title">Ekonomis Trip</span>
                      <span class="menu-item-desc">{{ App::getLocale() == 'id' ? 'Fasilitas Homestay & R&B' : 'Homestay & R&B Budget Facilities' }}</span>
                    </div>
                    <i class="fa fa-chevron-right menu-item-arrow"></i>
                    
                    <!-- Sub-menu (Right Panel) -->
                    <div class="mega-sub-menu shadow-sm">
                      <h6 class="sub-menu-header">Ekonomis Trip</h6>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'ekonomis-trip', 'tipe' => 'open-trip-banyuwangi']) }}">
                        <i class="fa fa-users text-teal"></i> Open Trip Banyuwangi
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'ekonomis-trip', 'tipe' => 'one-day-trip-banyuwangi']) }}">
                        <i class="fa fa-sun-o text-teal"></i> One Day Trip Banyuwangi
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'ekonomis-trip', 'tipe' => '2-day-1-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 2 Day 1 Night (2D1N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'ekonomis-trip', 'tipe' => '3-day-2-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 3 Day 2 Night (3D2N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'ekonomis-trip', 'tipe' => '4-day-3-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 4 Day 3 Night (4D3N)
                      </a>
                      <a class="sub-menu-item view-all" href="{{ lroute('paket-wisata', ['kategori' => 'ekonomis-trip']) }}">
                        <i class="fa fa-arrow-circle-right text-teal"></i> {{ App::getLocale() == 'id' ? 'Lihat Semua Paket Ekonomis' : 'View All Economy Packages' }}
                      </a>
                    </div>
                  </div>
                  
                  <!-- 2. Exclusive Trip -->
                  <div class="mega-menu-item" data-target="sub-exclusive">
                    <div class="menu-item-content">
                      <span class="menu-item-title">Exclusive Trip</span>
                      <span class="menu-item-desc">{{ App::getLocale() == 'id' ? 'Hotel Bintang 3 & Mobil' : 'Min 3-Star Hotel & Private Car' }}</span>
                    </div>
                    <i class="fa fa-chevron-right menu-item-arrow"></i>
                    
                    <!-- Sub-menu -->
                    <div class="mega-sub-menu shadow-sm">
                      <h6 class="sub-menu-header">Exclusive Trip</h6>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'exclusive-trip', 'tipe' => 'one-day-trip-banyuwangi']) }}">
                        <i class="fa fa-sun-o text-teal"></i> One Day Trip Banyuwangi
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'exclusive-trip', 'tipe' => '2-day-1-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 2 Day 1 Night (2D1N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'exclusive-trip', 'tipe' => '3-day-2-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 3 Day 2 Night (3D2N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'exclusive-trip', 'tipe' => '4-day-3-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 4 Day 3 Night (4D3N)
                      </a>
                      <a class="sub-menu-item view-all" href="{{ lroute('paket-wisata', ['kategori' => 'exclusive-trip']) }}">
                        <i class="fa fa-arrow-circle-right text-teal"></i> {{ App::getLocale() == 'id' ? 'Lihat Semua Paket Exclusive' : 'View All Exclusive Packages' }}
                      </a>
                    </div>
                  </div>
                  
                  <!-- 3. Luxury Trip -->
                  <div class="mega-menu-item" data-target="sub-luxury">
                    <div class="menu-item-content">
                      <span class="menu-item-title">Luxury Trip</span>
                      <span class="menu-item-desc">{{ App::getLocale() == 'id' ? 'Hotel Bintang 5 & Mobil Luxury' : 'Min 5-Star Hotel & Luxury Car' }}</span>
                    </div>
                    <i class="fa fa-chevron-right menu-item-arrow"></i>
                    
                    <!-- Sub-menu -->
                    <div class="mega-sub-menu shadow-sm">
                      <h6 class="sub-menu-header">Luxury Trip</h6>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'luxury-trip', 'tipe' => 'one-day-trip-banyuwangi']) }}">
                        <i class="fa fa-sun-o text-teal"></i> One Day Trip Banyuwangi
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'luxury-trip', 'tipe' => '2-day-1-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 2 Day 1 Night (2D1N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'luxury-trip', 'tipe' => '3-day-2-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 3 Day 2 Night (3D2N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'luxury-trip', 'tipe' => '4-day-3-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 4 Day 3 Night (4D3N)
                      </a>
                      <a class="sub-menu-item view-all" href="{{ lroute('paket-wisata', ['kategori' => 'luxury-trip']) }}">
                        <i class="fa fa-arrow-circle-right text-teal"></i> {{ App::getLocale() == 'id' ? 'Lihat Semua Paket Luxury' : 'View All Luxury Packages' }}
                      </a>
                    </div>
                  </div>
                  
                  <!-- 4. Comparment Trip -->
                  <div class="mega-menu-item" data-target="sub-comparment">
                    <div class="menu-item-content">
                      <span class="menu-item-title">Comparment Trip</span>
                      <span class="menu-item-desc">{{ App::getLocale() == 'id' ? 'VVIP, Public Figur & Artis' : 'VIP Guests & Public Figures' }}</span>
                    </div>
                    <i class="fa fa-chevron-right menu-item-arrow"></i>
                    
                    <!-- Sub-menu -->
                    <div class="mega-sub-menu shadow-sm">
                      <h6 class="sub-menu-header">Comparment Trip</h6>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'comparment-trip', 'tipe' => 'one-day-trip-banyuwangi']) }}">
                        <i class="fa fa-sun-o text-teal"></i> One Day Trip Banyuwangi
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'comparment-trip', 'tipe' => '2-day-1-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 2 Day 1 Night (2D1N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'comparment-trip', 'tipe' => '3-day-2-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 3 Day 2 Night (3D2N)
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'comparment-trip', 'tipe' => '4-day-3-night-banyuwangi']) }}">
                        <i class="fa fa-calendar-o text-teal"></i> 4 Day 3 Night (4D3N)
                      </a>
                      <a class="sub-menu-item view-all" href="{{ lroute('paket-wisata', ['kategori' => 'comparment-trip']) }}">
                        <i class="fa fa-arrow-circle-right text-teal"></i> {{ App::getLocale() == 'id' ? 'Lihat Semua Paket Comparment' : 'View All Compartment Packages' }}
                      </a>
                    </div>
                  </div>
                  
                  <!-- 5. Education Trip -->
                  <div class="mega-menu-item" data-target="sub-education">
                    <div class="menu-item-content">
                      <span class="menu-item-title">Education Trip</span>
                      <span class="menu-item-desc">{{ App::getLocale() == 'id' ? 'Study Tour & Gathering' : 'Study Tour, Seminar & Gathering' }}</span>
                    </div>
                    <i class="fa fa-chevron-right menu-item-arrow"></i>
                    
                    <!-- Sub-menu -->
                    <div class="mega-sub-menu shadow-sm">
                      <h6 class="sub-menu-header">Education Trip</h6>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip', 'tipe' => 'conference']) }}">
                        <i class="fa fa-university text-teal"></i> Conference
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip', 'tipe' => 'symposium']) }}">
                        <i class="fa fa-comments text-teal"></i> Symposium
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip', 'tipe' => 'seminar-international']) }}">
                        <i class="fa fa-globe text-teal"></i> Seminar International
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip', 'tipe' => 'study-tour']) }}">
                        <i class="fa fa-graduation-cap text-teal"></i> Study Tour
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip', 'tipe' => 'summer-winter-tour']) }}">
                        <i class="fa fa-snowflake-o text-teal"></i> Summer / Winter Tour
                      </a>
                      <a class="sub-menu-item" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip', 'tipe' => 'gathering']) }}">
                        <i class="fa fa-users text-teal"></i> Gathering
                      </a>
                      <a class="sub-menu-item view-all" href="{{ lroute('paket-wisata', ['kategori' => 'education-trip']) }}">
                        <i class="fa fa-arrow-circle-right text-teal"></i> {{ App::getLocale() == 'id' ? 'Lihat Semua Paket Education' : 'View All Education Packages' }}
                      </a>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </li>
          <li class="nav-item {{ request()->routeIs('recommendation') ? 'active' : '' }}"><a href="{{ lroute('recommendation') }}" class="nav-link">{{ __('messages.recommendation') }}</a></li>
          <li class="nav-item {{ request()->routeIs('article') ? 'active' : '' }}"><a href="{{ lroute('article') }}" class="nav-link">{{ __('messages.article') }}</a></li>
          <li class="nav-item {{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ lroute('contact') }}" class="nav-link">{{ __('messages.contact') }}</a></li>
        </ul>

        <!-- Tombol Auth & Lang di Kanan -->
        <ul class="navbar-nav ml-auto align-items-center">
          <!-- Language Switcher Toggle Switch -->
          <li class="nav-item d-flex align-items-center mr-lg-3">
            <a href="{{ locale_switch_url(App::getLocale() == 'id' ? 'en' : 'id') }}" 
               class="d-inline-flex align-items-center" 
               style="text-decoration: none;"
               aria-label="Ubah bahasa ke {{ App::getLocale() == 'id' ? 'English' : 'Bahasa Indonesia' }}"
               title="{{ App::getLocale() == 'id' ? 'Switch to English' : 'Ganti ke Bahasa Indonesia' }}">
                <div class="position-relative d-flex align-items-center shadow-sm" 
                     style="width: 58px; height: 30px; background: {{ App::getLocale() == 'en' ? 'rgb(87, 201, 209)' : '#dee2e6' }}; border-radius: 30px; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55); padding: 3px; cursor: pointer; border: 1px solid rgba(0,0,0,0.05);">
                    
                    <!-- Track Text -->
                    <div class="w-100 d-flex justify-content-between align-items-center px-2" 
                         style="font-size: 9px; font-weight: 800; color: {{ App::getLocale() == 'en' ? 'rgba(255,255,255,0.9)' : '#888' }}; user-select: none;">
                        <span style="visibility: {{ App::getLocale() == 'en' ? 'visible' : 'hidden' }};">EN</span>
                        <span style="visibility: {{ App::getLocale() == 'id' ? 'visible' : 'hidden' }};">ID</span>
                    </div>

                    <!-- Toggle Knob -->
                    <div class="d-flex align-items-center justify-content-center shadow-sm" 
                         style="width: 24px; height: 24px; background: white; border-radius: 50%; position: absolute; left: {{ App::getLocale() == 'id' ? '3px' : '31px' }}; transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);">
                        @if(App::getLocale() == 'id')
                            <img src="https://flagcdn.com/w40/id.png" style="width: 16px; height: auto; border-radius: 2px;" width="16" height="11" alt="ID">
                        @else
                            <img src="https://flagcdn.com/w40/gb.png" style="width: 16px; height: auto; border-radius: 2px;" width="16" height="11" alt="EN">
                        @endif
                    </div>
                </div>
            </a>
          </li>

          @if (Route::has('login'))
            @auth
              @if(Auth::user()->role === 'admin')
                <li class="nav-item cta"><a href="{{ route('admin.dashboard') }}" class="nav-link"><span>{{ __('messages.admin_panel') }}</span></a></li>
              @else
                <li class="nav-item d-flex align-items-center">
                  <a href="{{ lroute('profile') }}" class="nav-link" title="{{ Auth::user()->name }}" style="padding:0; line-height:1;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                      <circle cx="12" cy="7" r="4"/>
                    </svg>
                  </a>
                </li>
              @endif
            @else
              <li class="nav-item"><a href="{{ lroute('login') }}" class="nav-link">{{ __('messages.login') }}</a></li>
              @if (Route::has('register'))
                <li class="nav-item cta"><a href="{{ lroute('register') }}" class="nav-link"><span>{{ __('messages.register') }}</span></a></li>
              @endif
            @endauth
          @endif
        </ul>
      </div>
    </div>
</nav>

<style>
/* Mega Menu Dropdown Style */
@media (min-width: 992px) {
  .mega-menu-dropdown {
    min-width: 480px !important;
    padding: 0 !important;
    border-radius: 12px !important;
    overflow: visible !important;
    border: none !important;
    background: #ffffff !important;
    box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important;
    margin-top: 10px !important;
  }
  .mega-menu-container {
    display: flex;
    position: relative;
    min-height: 290px;
    border-radius: 12px;
    overflow: hidden;
  }
  .mega-menu-sidebar {
    width: 190px;
    background-color: #f8fafc;
    padding: 10px;
    border-right: 1px solid rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    gap: 4px;
  }
  .mega-menu-item {
    padding: 8px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: static;
  }
  .mega-menu-item:hover, .mega-menu-item.active {
    background-color: #ffffff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
  }
  .menu-item-content {
    display: flex;
    flex-direction: column;
    gap: 0px;
  }
  .menu-item-title {
    font-weight: 700;
    font-size: 13px;
    color: #333333;
    transition: color 0.2s;
  }
  .mega-menu-item:hover .menu-item-title, .mega-menu-item.active .menu-item-title {
    color: #57c9d1 !important;
  }
  .menu-item-desc {
    display: none; /* Hide description on desktop for a cleaner, more compact look */
  }
  .menu-item-arrow {
    font-size: 9px;
    color: #cccccc;
    transition: all 0.2s;
  }
  .mega-menu-item:hover .menu-item-arrow, .mega-menu-item.active .menu-item-arrow {
    color: #57c9d1 !important;
    transform: translateX(3px);
  }
  .mega-sub-menu {
    position: absolute;
    top: 0;
    left: 190px;
    width: 290px;
    height: 100%;
    padding: 12px 16px;
    background-color: #ffffff;
    display: none;
    flex-direction: column;
    gap: 4px;
    box-sizing: border-box;
    animation: megaMenuFadeIn 0.25s ease-out;
  }
  .mega-menu-item.active .mega-sub-menu {
    display: flex;
  }
  .sub-menu-header {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    color: #aaaaaa;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding-bottom: 4px;
  }
  .sub-menu-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    border-radius: 6px;
    color: #444444 !important;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s;
  }
  .sub-menu-item i {
    font-size: 14px;
    color: #57c9d1;
    transition: transform 0.2s;
  }
  .sub-menu-item:hover {
    background-color: rgba(87, 201, 209, 0.08);
    color: #57c9d1 !important;
    text-decoration: none;
  }
  .sub-menu-item:hover i {
    transform: scale(1.15);
  }
  .sub-menu-item.view-all {
    margin-top: auto;
    border-top: 1px solid rgba(0,0,0,0.05);
    padding-top: 12px;
    color: #57c9d1 !important;
    font-weight: 700;
  }
  .text-teal {
    color: #57c9d1 !important;
  }
}

/* Mobile responsive styles */
@media (max-width: 991.98px) {
  .mega-menu-dropdown {
    width: 100% !important;
    padding: 0 !important;
    box-shadow: none !important;
    background: #ffffff !important;
    margin-top: 0 !important;
    border-radius: 0 !important;
  }
  .mega-menu-container {
    display: block;
    width: 100%;
    background: #ffffff !important;
  }
  .mega-menu-sidebar {
    width: 100%;
    background: #ffffff !important;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 2px;
  }
  .mega-menu-item {
    display: block;
    padding: 12px 18px;
    border-bottom: 1px solid rgba(0,0,0,0.05) !important;
    cursor: pointer;
    background: #ffffff !important;
  }
  .menu-item-content {
    display: flex;
    flex-direction: column;
  }
  .menu-item-title {
    font-size: 14px;
    font-weight: 700;
    color: #333333 !important;
  }
  .menu-item-desc {
    font-size: 11px;
    color: #777777 !important;
  }
  .menu-item-arrow {
    display: none;
  }
  .mega-sub-menu {
    position: relative;
    top: 0;
    left: 0;
    width: 100%;
    padding: 10px 0 10px 15px;
    background-color: #f8fafc !important;
    border-radius: 6px;
    margin-top: 8px;
    display: none;
    flex-direction: column;
    gap: 4px;
  }
  .mega-menu-item.active .mega-sub-menu {
    display: flex;
  }
  .sub-menu-header {
    display: none;
  }
  .sub-menu-item {
    padding: 8px 12px;
    font-size: 13px;
    color: #444444 !important;
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
  }
  .sub-menu-item i {
    color: #57c9d1;
  }
  .sub-menu-item:hover {
    color: #57c9d1 !important;
    background: transparent;
  }
}

@keyframes megaMenuFadeIn {
  from {
    opacity: 0;
    transform: translateY(4px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const dropdown = document.querySelector('.nav-item.dropdown');
  
  if (dropdown) {
    // When the dropdown opens on desktop, auto-activate the first item
    dropdown.addEventListener('show.bs.dropdown', function() {
      if (window.innerWidth >= 992) {
        const firstItem = document.querySelector('.mega-menu-item');
        if (firstItem) {
          document.querySelectorAll('.mega-menu-item').forEach(i => i.classList.remove('active'));
          firstItem.classList.add('active');
        }
      }
    });
  }

  // Handle active states on hover (desktop) or click (mobile)
  document.querySelectorAll('.mega-menu-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
      if (window.innerWidth >= 992) {
        document.querySelectorAll('.mega-menu-item').forEach(i => i.classList.remove('active'));
        item.classList.add('active');
      }
    });

    item.addEventListener('click', function(e) {
      if (window.innerWidth < 992) {
        // Toggle active class on mobile
        const isActive = item.classList.contains('active');
        
        if (isActive) {
          item.classList.remove('active');
        } else {
          document.querySelectorAll('.mega-menu-item').forEach(i => i.classList.remove('active'));
          item.classList.add('active');
        }
        
        // Prevent link execution if they clicked inside the item header to expand it
        if (!e.target.closest('.sub-menu-item')) {
          e.preventDefault();
          e.stopPropagation();
        }
      }
    });
  });
});
</script>
