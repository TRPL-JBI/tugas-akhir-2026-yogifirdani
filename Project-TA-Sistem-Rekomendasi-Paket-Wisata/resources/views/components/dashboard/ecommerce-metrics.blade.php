@props([
    'totalUsers' => 0,
    'totalPackages' => 0,
    'totalDestinations' => 0,
    'monthlyRevenues' => [],
    'totalRevenueAllTime' => 0
])

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4 md:gap-4 lg:gap-6">
    <!-- Card Wisatawan -->
    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-5 shadow-theme-xs hover:border-violet-500/30 transition-all duration-300">
      <!-- High-End Radial Glow Background (only visible on hover) -->
      <div class="absolute right-0 top-0 -mr-6 -mt-6 h-28 w-28 rounded-full bg-violet-500/5 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 bg-violet-50 text-violet-600 rounded-xl dark:bg-violet-500/10 dark:text-violet-400">
          <svg
            class="fill-current"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M8.80443 5.60156C7.59109 5.60156 6.60749 6.58517 6.60749 7.79851C6.60749 9.01185 7.59109 9.99545 8.80443 9.99545C10.0178 9.99545 11.0014 9.01185 11.0014 7.79851C11.0014 6.58517 10.0178 5.60156 8.80443 5.60156ZM5.10749 7.79851C5.10749 5.75674 6.76267 4.10156 8.80443 4.10156C10.8462 4.10156 12.5014 5.75674 12.5014 7.79851C12.5014 9.84027 10.8462 11.4955 8.80443 11.4955C6.76267 11.4955 5.10749 9.84027 5.10749 7.79851ZM4.86252 15.3208C4.08769 16.0881 3.70377 17.0608 3.51705 17.8611C3.48384 18.0034 3.5211 18.1175 3.60712 18.2112C3.70161 18.3141 3.86659 18.3987 4.07591 18.3987H13.4249C13.6343 18.3987 13.7992 18.3141 13.8937 18.2112C13.9797 18.1175 14.017 18.0034 13.9838 17.8611C13.7971 17.0608 13.4132 16.0881 12.6383 15.3208C11.8821 14.572 10.6899 13.955 8.75042 13.955C6.81096 13.955 5.61877 14.572 4.86252 15.3208ZM3.8071 14.2549C4.87163 13.2009 6.45602 12.455 8.75042 12.455C11.0448 12.455 12.6292 13.2009 13.6937 14.2549C14.7397 15.2906 15.2207 16.5607 15.4446 17.5202C15.7658 18.8971 14.6071 19.8987 13.4249 19.8987H4.07591C2.89369 19.8987 1.73504 18.8971 2.05628 17.5202C2.28015 16.5607 2.76117 15.2906 3.8071 14.2549ZM15.3042 11.4955C14.4702 11.4955 13.7006 11.2193 13.082 10.7533C13.3742 10.3314 13.6054 9.86419 13.7632 9.36432C14.1597 9.75463 14.7039 9.99545 15.3042 9.99545C16.5176 9.99545 17.5012 9.01185 17.5012 7.79851C17.5012 6.58517 16.5176 5.60156 15.3042 5.60156C14.7039 5.60156 14.1597 5.84239 13.7632 6.23271C13.6054 5.73284 13.3741 5.26561 13.082 4.84371C13.7006 4.37777 14.4702 4.10156 15.3042 4.10156C17.346 4.10156 19.0012 5.75674 19.0012 7.79851C19.0012 9.84027 17.346 11.4955 15.3042 11.4955ZM19.9248 19.8987H16.3901C16.7014 19.4736 16.9159 18.969 16.9827 18.3987H19.9248C20.1341 18.3987 20.2991 18.3141 20.3936 18.2112C20.4796 18.1175 20.5169 18.0034 20.4837 17.861C20.2969 17.0607 19.913 16.088 19.1382 15.3208C18.4047 14.5945 17.261 13.9921 15.4231 13.9566C15.2232 13.6945 14.9995 13.437 14.7491 13.1891C14.5144 12.9566 14.262 12.7384 13.9916 12.5362C14.3853 12.4831 14.8044 12.4549 15.2503 12.4549C17.5447 12.4549 19.1291 13.2008 20.1936 14.2549C21.2395 15.2906 21.7206 16.5607 21.9444 17.5202C22.2657 18.8971 21.107 19.8987 19.9248 19.8987Z"
            />
          </svg>
        </div>

        <!-- Sleek Sparkline Wave -->
        <div class="w-14 h-7 text-violet-500/60 dark:text-violet-400/50">
          <svg class="w-full h-full stroke-current" width="56" height="28" viewBox="0 0 100 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 35C15 35 10 15 25 15C40 15 45 28 60 28C75 28 85 5 100 5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <div class="mt-4">
        <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Wisatawan</span>
        <p class="mt-1 font-bold text-gray-800 text-lg sm:text-xl dark:text-white/90 tracking-tight">{{ number_format($totalUsers) }}</p>
        <span class="text-[10px] text-gray-500 dark:text-gray-400 block mt-0.5">Total wisatawan terdaftar</span>
      </div>
    </div>

    <!-- Card Paket Wisata -->
    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-5 shadow-theme-xs hover:border-cyan-500/30 transition-all duration-300">
      <!-- High-End Radial Glow Background (only visible on hover) -->
      <div class="absolute right-0 top-0 -mr-6 -mt-6 h-28 w-28 rounded-full bg-cyan-500/5 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 bg-cyan-50 text-cyan-600 rounded-xl dark:bg-cyan-500/10 dark:text-cyan-400">
          <svg
            class="fill-current"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M11.665 3.75621C11.8762 3.65064 12.1247 3.65064 12.3358 3.75621L18.7807 6.97856L12.3358 10.2009C12.1247 10.3065 11.8762 10.3065 11.665 10.2009L5.22014 6.97856L11.665 3.75621ZM4.29297 8.19203V16.0946C4.29297 16.3787 4.45347 16.6384 4.70757 16.7654L11.25 20.0366V11.6513C11.1631 11.6205 11.0777 11.5843 10.9942 11.5426L4.29297 8.19203ZM12.75 20.037L19.2933 16.7654C19.5474 16.6384 19.7079 16.3787 19.7079 16.0946V8.19202L13.0066 11.5426C12.9229 11.5844 12.8372 11.6208 12.75 11.6516V20.037ZM13.0066 2.41456C12.3732 2.09786 11.6277 2.09786 10.9942 2.41456L4.03676 5.89319C3.27449 6.27432 2.79297 7.05342 2.79297 7.90566V16.0946C2.79297 16.9469 3.27448 17.726 4.03676 18.1071L10.9942 21.5857L11.3296 20.9149C11.6277 20.9024 12.3732 20.9024 13.0066 21.5857L19.9641 18.1071C20.7264 17.726 21.2079 16.0946 21.2079 16.0946V7.90566C21.2079 7.05342 20.7264 6.27432 19.9641 5.89319L13.0066 2.41456Z"
            />
          </svg>
        </div>

        <!-- Sleek Sparkline Wave -->
        <div class="w-14 h-7 text-cyan-500/60 dark:text-cyan-400/50">
          <svg class="w-full h-full stroke-current" width="56" height="28" viewBox="0 0 100 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 10C15 10 20 30 35 30C50 30 45 10 60 10C75 10 80 35 100 35" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <div class="mt-4">
        <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Paket Wisata</span>
        <p class="mt-1 font-bold text-gray-800 text-lg sm:text-xl dark:text-white/90 tracking-tight">{{ number_format($totalPackages) }}</p>
        <span class="text-[10px] text-gray-500 dark:text-gray-400 block mt-0.5">Total paket perjalanan aktif</span>
      </div>
    </div>

    <!-- Card Destinasi -->
    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-5 shadow-theme-xs hover:border-emerald-500/30 transition-all duration-300">
      <!-- High-End Radial Glow Background (only visible on hover) -->
      <div class="absolute right-0 top-0 -mr-6 -mt-6 h-28 w-28 rounded-full bg-emerald-500/5 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 bg-emerald-50 text-emerald-600 rounded-xl dark:bg-emerald-500/10 dark:text-emerald-400">
          <svg
            class="stroke-current"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M12 21C16.5 17.5 19 14.17 19 10C19 5.86 15.14 2.5 12 2.5C8.86 2.5 5 5.86 5 10C5 14.17 7.5 17.5 12 21Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 12.5C13.38 12.5 14.5 11.38 14.5 10C14.5 8.62 13.38 7.5 12 7.5C10.62 7.5 9.5 8.62 9.5 10C9.5 11.38 10.62 12.5 12 12.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <!-- Sleek Sparkline Wave -->
        <div class="w-14 h-7 text-emerald-500/60 dark:text-emerald-400/50">
          <svg class="w-full h-full stroke-current" width="56" height="28" viewBox="0 0 100 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 30C10 30 15 5 30 5C45 5 50 25 65 25C80 25 90 10 100 10" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <div class="mt-4">
        <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Destinasi</span>
        <p class="mt-1 font-bold text-gray-800 text-lg sm:text-xl dark:text-white/90 tracking-tight">{{ number_format($totalDestinations) }}</p>
        <span class="text-[10px] text-gray-500 dark:text-gray-400 block mt-0.5">Total objek wisata terkelola</span>
      </div>
    </div>

    <!-- Card Uang Masuk -->
    <div x-data="{
          activeMonth: 'all',
          revenues: {{ json_encode($monthlyRevenues) }},
          totalAllTime: {{ $totalRevenueAllTime }},
          get displayAmount() {
              if (this.activeMonth === 'all') {
                  return this.formatRupiah(this.totalAllTime);
              }
              return this.formatRupiah(this.revenues[this.activeMonth] || 0);
          },
          formatRupiah(value) {
              return 'Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value);
          }
         }"
         class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-white/[0.03] sm:p-5 shadow-theme-xs hover:border-amber-500/30 transition-all duration-300">
      
      <!-- High-End Radial Glow Background (only visible on hover) -->
      <div class="absolute right-0 top-0 -mr-6 -mt-6 h-28 w-28 rounded-full bg-amber-500/5 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

      <div class="flex items-center justify-between">
        <div class="flex items-center justify-center w-10 h-10 sm:w-11 sm:h-11 bg-amber-50 text-amber-600 rounded-xl dark:bg-amber-500/10 dark:text-amber-400">
          <svg
            class="stroke-current"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path d="M12 2V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M17 5H9.5C8.258 5 7.25 6.008 7.25 7.25C7.25 8.492 8.258 9.5 9.5 9.5H14.5C15.742 9.5 16.75 10.508 16.75 11.75C16.75 12.992 15.742 14 14.5 14H7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16.75 11.75C16.75 12.992 15.742 14 14.5 14H9.5C8.258 14 7.25 12.992 7.25 11.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>

        <!-- Sleek Sparkline Wave -->
        <div class="w-14 h-7 text-amber-500/60 dark:text-amber-400/50">
          <svg class="w-full h-full stroke-current" width="56" height="28" viewBox="0 0 100 40" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 25C15 25 15 5 30 5C45 5 45 35 60 35C75 35 85 15 100 15" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <div class="mt-4">
        <div class="flex items-center justify-between">
          <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Uang Masuk</span>
          
          <!-- Smooth Premium Filter Dropdown -->
          <div class="relative z-10 -mt-1 select-none">
            <select x-model="activeMonth" 
                    aria-label="Pilih Bulan"
                    class="block w-24 py-0.5 pl-1.5 pr-5 text-[10px] font-semibold text-gray-600 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-amber-500/30 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:focus:ring-amber-500/20 cursor-pointer transition-all duration-200">
              <option value="all">Semua</option>
              <option value="1">Januari</option>
              <option value="2">Februari</option>
              <option value="3">Maret</option>
              <option value="4">April</option>
              <option value="5">Mei</option>
              <option value="6">Juni</option>
              <option value="7">Juli</option>
              <option value="8">Agustus</option>
              <option value="9">September</option>
              <option value="10">Oktober</option>
              <option value="11">November</option>
              <option value="12">Desember</option>
            </select>
          </div>
        </div>
        
        <!-- Smooth dynamic display of formatted amount -->
        <p class="mt-1 font-bold text-gray-800 text-lg sm:text-xl dark:text-white/90 tracking-tight transition-all duration-300"
            x-text="displayAmount"></p>
        
        <span class="text-[10px] text-gray-500 dark:text-gray-400 block mt-0.5">
          Pendapatan terverifikasi (Paid)
        </span>
      </div>
    </div>
</div>