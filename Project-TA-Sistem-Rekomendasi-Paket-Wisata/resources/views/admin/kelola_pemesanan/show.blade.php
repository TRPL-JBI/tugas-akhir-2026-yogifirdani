@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteItemName: '', isDeleting: false }" x-init="$watch('deleteModalOpen', value => { if (!value) isDeleting = false })">

    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kelola-pemesanan.index') }}"
            class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">Detail Pemesanan</h1>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Kode Booking: {{ $booking->booking_code }}</p>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="flex items-center gap-3 rounded-lg border border-success-300 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-700 dark:bg-success-500/15 dark:text-success-400">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <!-- Info Detail (Left - Scrollable) -->
        <div class="col-span-1 xl:col-span-2 space-y-6">

            <!-- Informasi Pelanggan -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-5 text-base font-semibold text-gray-800 dark:text-white/90">Informasi Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Nama Lengkap</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Email</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">No. Telepon</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Tanggal Pemesanan</p>
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Catatan</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-white/[0.02] p-4 rounded-xl leading-relaxed border border-gray-100 dark:border-gray-800/50">
                            {{ $booking->notes ? $booking->notes : 'Tidak ada catatan.' }}
                        </p>
                    </div>
                    <div class="col-span-1 md:col-span-2 mt-4">
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2">Dokumen Identitas (KTP/Passport)</p>
                        @if($booking->identity_document_path)
                            @php
                                // Menggunakan Storage::url sesuai standar Laravel
                                $docUrl = Storage::url($booking->identity_document_path);
                                $isPdf = Str::endsWith(strtolower($booking->identity_document_path), '.pdf');
                            @endphp

                            @if($isPdf)
                                <a href="{{ $docUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-brand-700 bg-brand-50 rounded-lg hover:bg-brand-100 transition-colors dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 border border-brand-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Lihat Dokumen PDF
                                </a>
                            @else
                                <a href="{{ $docUrl }}" target="_blank" class="block mt-2">
                                    <img src="{{ $docUrl }}" alt="Dokumen Identitas" class="h-32 object-contain rounded-lg border border-gray-200 shadow-sm hover:opacity-90 transition-opacity">
                                </a>
                                <p class="text-xs text-gray-500 mt-1 italic">Klik gambar untuk memperbesar</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-500 italic">Tidak ada dokumen yang diunggah.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Paket Wisata -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-5 text-base font-semibold text-gray-800 dark:text-white/90">Detail Paket Wisata</h3>
                
                <div class="space-y-6">
                    <!-- Package Thumbnail Block -->
                    @if($booking->tourPackage?->image_url)
                    <div class="flex flex-col sm:flex-row gap-4 items-center bg-gray-50 dark:bg-white/[0.02] p-4 rounded-xl border border-gray-100 dark:border-gray-800/50">
                        <img src="{{ $booking->tourPackage->image_url }}" alt="{{ $booking->tourPackage->package_name }}" class="w-full sm:w-32 h-20 object-cover rounded-lg shadow-sm" />
                        <div class="text-center sm:text-left">
                            <a href="{{ route('admin.kelola-paket-wisata.edit', $booking->tourPackage) }}" class="text-sm font-semibold text-brand-600 hover:text-brand-700 dark:text-brand-400 dark:hover:text-brand-300 hover:underline">
                                {{ $booking->tourPackage->package_name }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                {{ strip_tags($booking->tourPackage->duration) }} | Meeting Point: {{ strip_tags($booking->tourPackage->meeting_point) }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(!$booking->tourPackage?->image_url)
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Nama Paket</p>
                            <p class="text-sm font-medium text-brand-600 dark:text-brand-400">
                                {{ $booking->tourPackage?->package_name ?? 'Paket dihapus' }}
                            </p>
                        </div>
                        @endif
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Kategori / Tipe Paket</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">
                                {{ $booking->tourPackage?->category?->getTranslation('category_name') ?? $booking->tourPackage?->tour_category ?? '-' }} / {{ $booking->tourPackage?->packageType?->getTranslation('type_name') ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Durasi</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->tourPackage?->duration ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Meeting Point</p>
                            <div class="text-sm font-medium text-gray-800 dark:text-white/90 prose dark:prose-invert max-w-none">
                                {!! $booking->tourPackage?->meeting_point ?? '-' !!}
                            </div>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Jumlah Peserta</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->num_participants }} Orang</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Tanggal Trip</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $booking->trip_date->format('d M Y') }}</p>
                        </div>
                        
                        @if($booking->tourPackage?->destination)
                        <div class="col-span-1 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Destinasi yang Dikunjungi</p>
                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-white/[0.02] p-4 rounded-xl leading-relaxed border border-gray-100 dark:border-gray-800/50 prose dark:prose-invert max-w-none">
                                {!! $booking->tourPackage->destination !!}
                            </div>
                        </div>
                        @endif
                        
                        @if($booking->tourPackage?->facilities_included)
                        <div class="col-span-1 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wider text-success-600 dark:text-success-400 mb-1">Fasilitas Termasuk</p>
                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-success-50/20 dark:bg-success-500/5 p-4 rounded-xl leading-relaxed border border-success-100/50 dark:border-success-900/20 prose dark:prose-invert max-w-none">
                                {!! $booking->tourPackage->facilities_included !!}
                            </div>
                        </div>
                        @endif
                        
                        @if($booking->tourPackage?->facilities_excluded)
                        <div class="col-span-1 md:col-span-2">
                            <p class="text-xs font-medium uppercase tracking-wider text-error-600 dark:text-error-400 mb-1">Fasilitas Tidak Termasuk</p>
                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-error-50/20 dark:bg-error-500/5 p-4 rounded-xl leading-relaxed border border-error-100/50 dark:border-error-900/20 prose dark:prose-invert max-w-none">
                                {!! $booking->tourPackage->facilities_excluded !!}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Booking Card (Right - Sticky) -->
        <div class="col-span-1 xl:sticky xl:top-24 self-start">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                
                <!-- Booking Status Header -->
                <div class="flex flex-col items-center text-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-100 text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h2 class="font-mono text-sm font-semibold text-brand-600 dark:text-brand-400 bg-brand-50 dark:bg-brand-500/10 px-3 py-1 rounded-lg">
                        {{ $booking->booking_code }}
                    </h2>
                    
                    <!-- Badges -->
                    <div class="mt-4 flex flex-wrap gap-2 justify-center">
                        @php
                            if ($booking->payment_status === 'failed') {
                                $cfg = ['label' => 'Gagal', 'class' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400'];
                            } elseif ($booking->payment_status === 'refunded') {
                                $cfg = ['label' => 'Refund', 'class' => 'bg-blue-50 text-blue-700 dark:bg-blue-500/15 dark:text-blue-400'];
                            } elseif ($booking->payment_status === 'pending') {
                                $cfg = ['label' => 'Pending', 'class' => 'bg-gray-100 text-gray-600 dark:bg-white/5 dark:text-gray-400'];
                            } else {
                                if ($booking->remaining_amount > 0) {
                                    $cfg = ['label' => 'Uang Muka (DP)', 'class' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400'];
                                } else {
                                    $cfg = ['label' => 'Lunas', 'class' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400'];
                                }
                            }
                            
                            $bookingStatusConfig = [
                                'confirmed' => ['label' => 'Dikonfirmasi', 'class' => 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400'],
                                'pending'   => ['label' => 'Menunggu',    'class' => 'bg-warning-50 text-warning-700 dark:bg-warning-500/15 dark:text-warning-400'],
                                'cancelled' => ['label' => 'Dibatalkan',   'class' => 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400'],
                            ];
                            $bCfg = $bookingStatusConfig[$booking->booking_status] ?? ['label' => ucfirst($booking->booking_status), 'class' => 'bg-gray-100 text-gray-600'];
                        @endphp
                        
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $cfg['class'] }}">
                            Bayar: {{ $cfg['label'] }}
                        </span>
                        
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $bCfg['class'] }}">
                            Trip: {{ $bCfg['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Price Details -->
                <div class="mt-6 space-y-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Total Harga</span>
                        <span class="font-semibold text-gray-800 dark:text-white/90">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Uang Muka (DP)</span>
                        <span class="font-medium text-gray-800 dark:text-white/90">Rp {{ number_format($booking->dp_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Sisa Pembayaran</span>
                        <span class="font-semibold {{ $booking->remaining_amount > 0 ? 'text-error-600 dark:text-error-400' : 'text-success-600 dark:text-success-400' }}">Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Status Trip Management -->
                <div class="mt-6 border-t border-gray-100 pt-6 dark:border-gray-800">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Kelola Status Trip</p>
                    <div class="flex flex-col gap-2">
                        @if($booking->booking_status === 'pending')
                            <form action="{{ route('admin.kelola-pemesanan.update-status', $booking) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="booking_status" value="confirmed" />
                                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-success-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-success-700 transition-colors shadow-xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Konfirmasi Trip
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.kelola-pemesanan.update-status', $booking) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="booking_status" value="cancelled" />
                                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-error-50 text-error-700 hover:bg-error-100 border border-error-200 px-4 py-2.5 text-sm font-semibold dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Batalkan Trip
                                </button>
                            </form>
                        @elseif($booking->booking_status === 'confirmed')
                            @php
                                $todayStr = now()->toDateString();
                                $tripDateStr = $booking->trip_date->toDateString();
                            @endphp
                            @if($tripDateStr >= $todayStr)
                                <form action="{{ route('admin.kelola-pemesanan.update-status', $booking) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="booking_status" value="cancelled" />
                                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-error-50 text-error-700 hover:bg-error-100 border border-error-200 px-4 py-2.5 text-sm font-semibold dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Batalkan Trip
                                    </button>
                                </form>
                            @else
                                <div class="bg-gray-50 dark:bg-white/[0.02] p-3 rounded-lg border border-gray-100 dark:border-gray-800/50 text-center">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Trip telah selesai dan tidak dapat diubah.</p>
                                </div>
                            @endif
                        @elseif($booking->booking_status === 'cancelled')
                            <form action="{{ route('admin.kelola-pemesanan.update-status', $booking) }}" method="POST" class="w-full">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="booking_status" value="pending" />
                                <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-50 text-brand-700 hover:bg-brand-100 border border-brand-200 px-4 py-2.5 text-sm font-semibold dark:bg-brand-500/10 dark:text-brand-400 dark:hover:bg-brand-500/20 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89"/>
                                    </svg>
                                    Pulihkan Ke Menunggu
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex flex-col gap-2">
                    <button type="button"
                        @click="deleteActionUrl = '{{ route('admin.kelola-pemesanan.destroy', $booking) }}'; deleteItemName = 'pemesanan {{ $booking->booking_code }}'; deleteModalOpen = true"
                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-error-200 bg-error-50 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-100 dark:border-error-700 dark:bg-error-500/15 dark:text-error-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Pemesanan
                    </button>
                </div>
            </div>
        </div>
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
                <form :action="deleteActionUrl" method="POST" @submit.prevent="deleteModalOpen = false; isDeleting = true" class="inline-block">
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
@endsection
