@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteItemName: '', isDeleting: false }" x-init="$watch('deleteModalOpen', value => { if (!value) isDeleting = false })">

    <!-- Page Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">Kelola Pemesanan</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Daftar seluruh pemesanan paket wisata dari pelanggan</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-lg border border-success-300 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-700 dark:bg-success-500/15 dark:text-success-400">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Search & Filter Controls Row -->
    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 mb-6">
        <!-- Search Input (Left) -->
        <div class="w-full xl:max-w-md">
            <form method="GET" action="{{ route('admin.kelola-pemesanan.index') }}" class="flex items-center gap-2">
                <div class="relative flex-1">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                         placeholder="Cari kode booking, nama, email..."
                         class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 pl-10 pr-4 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
                </div>
                <button type="submit"
                    class="inline-flex h-10 items-center justify-center rounded-lg bg-brand-500 px-4 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Cari
                </button>
                <a href="{{ route('admin.kelola-pemesanan.index') }}"
                   class="reset-search inline-flex h-10 items-center justify-center rounded-lg border border-gray-300 bg-white dark:border-gray-700 dark:bg-gray-800 px-4 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ request('search') ? '' : 'hidden' }}">
                    Reset
                </a>
            </form>
        </div>

        <!-- Status Filter Segmented Controls (Right) -->
        <div class="flex flex-wrap items-center gap-1 bg-gray-100/80 dark:bg-white/[0.02] p-1.5 rounded-xl border border-gray-200 dark:border-gray-800/80 self-start xl:self-auto">
            @php
                $currentStatus = request('status', 'all');
                $tabs = [
                    'all' => 'Semua',
                    'today' => 'Hari Ini 📅',
                    'upcoming' => 'Akan Datang',
                    'completed' => 'Selesai',
                    'pending' => 'Menunggu',
                    'cancelled' => 'Dibatalkan'
                ];
            @endphp
            @foreach($tabs as $key => $label)
                <a href="{{ route('admin.kelola-pemesanan.index', array_merge(request()->query(), ['status' => $key, 'page' => 1])) }}"
                   class="filter-tab px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all {{ $currentStatus === $key ? 'bg-white dark:bg-gray-800 text-brand-600 dark:text-brand-400 shadow-xs border border-gray-200/50 dark:border-gray-750' : 'border border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Table Card -->
    <div id="table-container" class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <!-- Table Head -->
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800">
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Kode Booking</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Nama Pelanggan</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Nama Paket</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Tanggal Trip</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Total Harga</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Status Pembayaran</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Status Trip</th>
                        <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-600 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($bookings as $booking)
                    <tr class="group hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">

                        <!-- Kode Booking -->
                        <td class="whitespace-nowrap px-5 py-4">
                            <span class="font-mono text-xs font-semibold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/10 px-2 py-1 rounded-md">
                                {{ $booking->booking_code }}
                            </span>
                        </td>

                        <!-- Nama Pelanggan -->
                        <td class="px-5 py-4">
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white/90">{{ $booking->customer_name }}</p>
                                <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">{{ $booking->customer_email }}</p>
                            </div>
                        </td>

                        <!-- Nama Paket -->
                        <td class="px-5 py-4 text-gray-700 dark:text-gray-300">
                            {{ $booking->tourPackage?->package_name ?? '<span class="text-gray-400 italic">Paket dihapus</span>' }}
                        </td>

                        <!-- Tanggal Trip -->
                        <td class="whitespace-nowrap px-5 py-4 text-gray-700 dark:text-gray-300">
                            {{ $booking->trip_date->format('d M Y') }}
                        </td>

                        <!-- Total Harga -->
                        <td class="whitespace-nowrap px-5 py-4 font-medium text-gray-800 dark:text-white/90">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>

                        <!-- Status Pembayaran -->
                        <td class="whitespace-nowrap px-5 py-4">
                            @php
                                if ($booking->payment_status === 'failed') {
                                    $cfg = ['label' => 'Gagal', 'class' => 'bg-error-50 text-error-800 dark:bg-error-500/15 dark:text-error-450'];
                                } elseif ($booking->payment_status === 'refunded') {
                                    $cfg = ['label' => 'Refund', 'class' => 'bg-blue-50 text-blue-800 dark:bg-blue-500/15 dark:text-blue-400'];
                                } elseif ($booking->payment_status === 'pending') {
                                    $cfg = ['label' => 'Pending', 'class' => 'bg-gray-150 text-gray-800 dark:bg-white/10 dark:text-gray-300'];
                                } else {
                                    if ($booking->remaining_amount > 0) {
                                        $cfg = ['label' => 'Uang Muka (DP)', 'class' => 'bg-warning-55 text-warning-850 dark:bg-warning-500/15 dark:text-warning-400'];
                                    } else {
                                        $cfg = ['label' => 'Lunas', 'class' => 'bg-success-50 text-success-800 dark:bg-success-500/15 dark:text-success-400'];
                                    }
                                }
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $cfg['class'] }}">
                                {{ $cfg['label'] }}
                            </span>
                        </td>

                        <!-- Status Trip -->
                        <td class="whitespace-nowrap px-5 py-4">
                            @php
                                $todayStr = now()->toDateString();
                                $tripDateStr = $booking->trip_date->toDateString();
                                
                                if ($booking->booking_status === 'cancelled') {
                                    $tCfg = ['label' => 'Dibatalkan', 'class' => 'bg-error-50 text-error-800 dark:bg-error-500/15 dark:text-error-450'];
                                } elseif ($booking->booking_status === 'pending') {
                                    $tCfg = ['label' => 'Menunggu', 'class' => 'bg-warning-55 text-warning-850 dark:bg-warning-500/15 dark:text-warning-400'];
                                } else {
                                    if ($tripDateStr === $todayStr) {
                                        $tCfg = ['label' => 'Hari Ini 🚀', 'class' => 'bg-brand-500 text-white font-semibold dark:bg-brand-500 dark:text-white shadow-xs shadow-brand-500/20'];
                                    } elseif ($tripDateStr < $todayStr) {
                                        $tCfg = ['label' => 'Selesai ✓', 'class' => 'bg-gray-150 text-gray-800 dark:bg-white/10 dark:text-gray-300'];
                                    } else {
                                        $tCfg = ['label' => 'Akan Datang', 'class' => 'bg-blue-50 text-blue-800 dark:bg-blue-500/15 dark:text-blue-400'];
                                    }
                                }
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $tCfg['class'] }}">
                                {{ $tCfg['label'] }}
                            </span>
                        </td>

                        <!-- Aksi -->
                        <td class="whitespace-nowrap px-5 py-4">
                            <div class="flex items-center gap-2">

                                {{-- Tombol Detail --}}
                                <a href="{{ route('admin.kelola-pemesanan.show', $booking) }}"
                                    title="Lihat Detail"
                                    aria-label="Lihat detail pemesanan {{ $booking->booking_code }}"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <button type="button"
                                    @click="deleteActionUrl = '{{ route('admin.kelola-pemesanan.destroy', $booking) }}'; deleteItemName = 'pemesanan {{ addslashes($booking->booking_code) }} dari {{ addslashes($booking->customer_name) }}'; deleteModalOpen = true"
                                    title="Hapus"
                                    aria-label="Hapus pemesanan {{ $booking->booking_code }}"
                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-error-200 bg-error-50 text-error-600 hover:bg-error-100 dark:border-error-700 dark:bg-error-500/15 dark:text-error-400 dark:hover:bg-error-500/25 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-14 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada data pemesanan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
        <div class="border-t border-gray-200 px-5 py-4 dark:border-gray-800">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>

    <!-- Delete Confirmation Modal Local -->
    <div x-show="deleteModalOpen" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
         x-cloak>
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/40 transition-opacity"
             x-show="deleteModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="deleteModalOpen = false"></div>

        <!-- Modal Card -->
        <div class="relative w-full max-w-md p-6 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-800 z-50 transform"
             x-show="deleteModalOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-2">
            
            <div class="flex items-start gap-4">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-error-50 dark:bg-error-500/10 text-error-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>

                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Konfirmasi Hapus</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Apakah Anda yakin ingin menghapus <span class="font-semibold text-error-600 dark:text-error-400 break-all" x-text="deleteItemName"></span>? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-2.5">
                <button type="button" 
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors focus:outline-hidden disabled:opacity-50 disabled:cursor-not-allowed"
                        @click="deleteModalOpen = false"
                        :disabled="isDeleting">
                    Batal
                </button>
                <form :action="deleteActionUrl" method="POST" @submit.prevent="deleteModalOpen = false; isDeleting = true; submitDeleteForm($el)" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-error-600 hover:bg-error-700 rounded-lg transition-colors focus:outline-hidden disabled:opacity-75 disabled:cursor-not-allowed min-w-[96px]"
                            :disabled="isDeleting">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableContainer = document.getElementById('table-container');
        const searchInput = document.querySelector('input[name="search"]');
        const searchForm = searchInput.closest('form');
        let searchTimeout;

        async function updateTable(url) {
            tableContainer.style.opacity = '0.5';
            tableContainer.style.pointerEvents = 'none';
            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();
                
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newTable = doc.getElementById('table-container');
                if (newTable) {
                    tableContainer.innerHTML = newTable.innerHTML;
                }

                // Update URL in browser without reload
                window.history.pushState({}, '', url);

                // Update Reset button visibility after search
                const resetBtn = document.querySelector('.reset-search');
                const searchVal = new URL(url).searchParams.get('search');
                if (resetBtn) {
                    if (searchVal && searchVal.trim() !== '') {
                        resetBtn.classList.remove('hidden');
                    } else {
                        resetBtn.classList.add('hidden');
                    }
                }
            } catch (error) {
                console.error('Error updating table:', error);
            } finally {
                tableContainer.style.opacity = '1';
                tableContainer.style.pointerEvents = 'auto';
            }
        }

        // Handle search input (debounce)
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('search', this.value);
                url.searchParams.set('page', '1'); // Reset page on new search
                updateTable(url.toString());
            }, 500);
        });

        // Prevent form submission reload
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const url = new URL(window.location.href);
            url.searchParams.set('search', searchInput.value);
            url.searchParams.set('page', '1'); // Reset page
            updateTable(url.toString());
        });

        // Handle filter tab clicks (AJAX tab switching)
        document.addEventListener('click', function(e) {
            const tab = e.target.closest('.filter-tab');
            if (tab) {
                e.preventDefault();
                
                // Immediately update active styling
                document.querySelectorAll('.filter-tab').forEach(t => {
                    t.className = 'filter-tab px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all border border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300';
                });
                tab.className = 'filter-tab px-3.5 py-1.5 text-xs font-semibold rounded-lg transition-all bg-white dark:bg-gray-800 text-brand-600 dark:text-brand-400 shadow-xs border border-gray-200/50 dark:border-gray-750';
                
                updateTable(tab.href);
            }
        });

        // Handle pagination clicks (Event Delegation)
        tableContainer.addEventListener('click', function(e) {
            const link = e.target.closest('a[href*="page="]');
            if (link) {
                e.preventDefault();
                updateTable(link.href);
            }
        });

        // Handle Reset button click
        document.addEventListener('click', function(e) {
            const resetBtn = e.target.closest('.reset-search');
            if (resetBtn) {
                e.preventDefault();
                searchInput.value = '';
                
                const url = new URL(resetBtn.href);
                // Retain active status filter if present in URL
                const currentStatus = new URL(window.location.href).searchParams.get('status');
                if (currentStatus) {
                    url.searchParams.set('status', currentStatus);
                }
                updateTable(url.toString());
            }
        });

        window.submitDeleteForm = async function(form) {
            try {
                await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });
                
                await updateTable(window.location.href);
            } catch (error) {
                console.error('Error deleting:', error);
            }
        };
    });
</script>
@endsection
