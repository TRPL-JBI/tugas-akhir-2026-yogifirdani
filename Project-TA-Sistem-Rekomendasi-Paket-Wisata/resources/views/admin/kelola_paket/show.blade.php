@extends('layouts.app')

@section('content')
<div class="space-y-6 pb-12" x-data="{ activeTab: 'id', deleteModalOpen: false, deleteActionUrl: '', deleteItemName: '', isDeleting: false }" x-init="$watch('deleteModalOpen', value => { if (!value) isDeleting = false })">
    <!-- Breadcrumbs -->
    <nav class="flex text-sm text-gray-500 dark:text-gray-400 mb-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.kelola-paket-wisata.index') }}" class="hover:text-brand-500 transition-colors">Kelola Paket</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                    <span class="ml-1 md:ml-2">Detail Paket</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Language Switcher Tabs -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex p-1 bg-gray-100 dark:bg-gray-800 rounded-xl w-fit">
            <button type="button" @click="activeTab = 'id'" 
                :class="activeTab === 'id' ? 'bg-white dark:bg-gray-700 shadow-sm text-brand-600 dark:text-brand-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                🇮🇩 Bahasa Indonesia
            </button>
            <button type="button" @click="activeTab = 'en'" 
                :class="activeTab === 'en' ? 'bg-white dark:bg-gray-700 shadow-sm text-brand-600 dark:text-brand-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300'"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition-all">
                🇬🇧 English
            </button>
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400 italic">
            <span x-show="activeTab === 'id'">Menampilkan konten dalam Bahasa Indonesia</span>
            <span x-show="activeTab === 'en'" x-cloak>Displaying content in English</span>
        </div>
    </div>

    <!-- Page Header & Actions -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90 sm:text-3xl">
                <span x-show="activeTab === 'id'">{{ $kelolaPackage->package_name }}</span>
                <span x-show="activeTab === 'en'" x-cloak>{{ $kelolaPackage->package_name_en ?: $kelolaPackage->package_name }}</span>
            </h1>
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kelolaPackage->is_active ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400' : 'bg-error-50 text-error-700 dark:bg-error-500/15 dark:text-error-400' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $kelolaPackage->is_active ? 'bg-success-600' : 'bg-error-600' }}"></span>
                    {{ $kelolaPackage->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
                <span class="text-gray-400">|</span>
                <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ $kelolaPackage->city }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.kelola-paket-wisata.index') }}" 
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:bg-white/[0.03] dark:text-gray-400 dark:hover:bg-white/[0.05] transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.kelola-paket-wisata.edit', $kelolaPackage) }}"
                class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Paket
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Quick Glance Card -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Durasi -->
                <div class="bg-white dark:bg-white/[0.03] p-4 sm:p-5 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col gap-3 hover:shadow-md transition-shadow">
                    <div class="p-2.5 bg-blue-50 dark:bg-blue-500/10 rounded-xl text-blue-600 dark:text-blue-400 w-fit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Durasi</p>
                        <p class="font-bold text-sm text-gray-800 dark:text-white/90 leading-snug">
                            <span x-show="activeTab === 'id'">{{ $kelolaPackage->duration }}</span>
                            <span x-show="activeTab === 'en'" x-cloak>{{ $kelolaPackage->duration_en ?: $kelolaPackage->duration }}</span>
                        </p>
                    </div>
                </div>
                <!-- Kategori Paket -->
                <div class="bg-white dark:bg-white/[0.03] p-4 sm:p-5 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col gap-3 hover:shadow-md transition-shadow">
                    <div class="p-2.5 bg-purple-50 dark:bg-purple-500/10 rounded-xl text-purple-600 dark:text-purple-400 w-fit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Kategori Paket</p>
                        <p class="font-bold text-sm text-gray-800 dark:text-white/90 leading-snug">{{ $kelolaPackage->category->category_name ?? '-' }}</p>
                    </div>
                </div>
                <!-- Kategori Wisata -->
                <div class="bg-white dark:bg-white/[0.03] p-4 sm:p-5 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col gap-3 hover:shadow-md transition-shadow">
                    <div class="p-2.5 bg-teal-50 dark:bg-teal-500/10 rounded-xl text-teal-600 dark:text-teal-400 w-fit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2a2.5 2.5 0 002.5-2.5V8a2 2 0 00-2-2h-1.5a2 2 0 01-2-2V2.5A2.5 2.5 0 0012 0h-1.5M12 21h-2a2 2 0 01-2-2v-1a2 2 0 00-2-2H3.055"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Kategori Wisata</p>
                        <p class="font-bold text-sm text-gray-800 dark:text-white/90 leading-snug">{{ $kelolaPackage->tour_category ?? '-' }}</p>
                    </div>
                </div>
                <!-- Tipe -->
                <div class="bg-white dark:bg-white/[0.03] p-4 sm:p-5 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col gap-3 hover:shadow-md transition-shadow">
                    <div class="p-2.5 bg-orange-50 dark:bg-orange-500/10 rounded-xl text-orange-600 dark:text-orange-400 w-fit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Tipe Paket</p>
                        <p class="font-bold text-sm text-gray-800 dark:text-white/90 leading-snug">{{ $kelolaPackage->packageType->type_name ?? '-' }}</p>
                    </div>
                </div>
                <!-- Mulai Harga -->
                <div class="bg-white dark:bg-white/[0.03] p-4 sm:p-5 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm flex flex-col gap-3 col-span-2 md:col-span-3 lg:col-span-1 hover:shadow-md transition-shadow">
                    <div class="p-2.5 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl text-emerald-600 dark:text-emerald-400 w-fit">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-500 dark:text-gray-400 mb-1 uppercase tracking-wider">Mulai Harga</p>
                        <p class="font-bold text-emerald-600 dark:text-emerald-400 text-lg leading-snug">Rp {{ number_format($kelolaPackage->price_10pax ?? $kelolaPackage->price_1pax, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2 bg-gray-50/50 dark:bg-white/[0.01]">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <h3 class="font-bold text-gray-800 dark:text-white/90">Deskripsi Paket</h3>
                </div>
                <div class="p-6">
                    <div x-show="activeTab === 'id'" class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed">
                        {!! $kelolaPackage->description ?: '-' !!}
                    </div>
                    <div x-show="activeTab === 'en'" x-cloak class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 leading-relaxed">
                        {!! $kelolaPackage->description_en ?: '-' !!}
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2 bg-brand-50/50 dark:bg-brand-500/5">
                    <svg class="w-5 h-5 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-brand-800 dark:text-brand-200">Informasi Tambahan</h3>
                </div>
                <div class="p-6">
                    <div x-show="activeTab === 'id'" class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! $kelolaPackage->information ?: '-' !!}
                    </div>
                    <div x-show="activeTab === 'en'" x-cloak class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! $kelolaPackage->information_en ?: '-' !!}
                    </div>
                </div>
            </div>

            <!-- Pricing Grid -->
            <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2 bg-gray-50/50 dark:bg-white/[0.01]">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 8V7m0 1v8m0 0v1"/></svg>
                    <h3 class="font-bold text-gray-800 dark:text-white/90">Daftar Harga per Kapasitas</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
                        @php
                            $prices = [
                                '1 Orang' => $kelolaPackage->price_1pax,
                                '2 Orang' => $kelolaPackage->price_2pax,
                                '3 Orang' => $kelolaPackage->price_3pax,
                                '4 Orang' => $kelolaPackage->price_4pax,
                                '5 Orang' => $kelolaPackage->price_5pax,
                                '8 Orang' => $kelolaPackage->price_8pax,
                                '10 Orang' => $kelolaPackage->price_10pax,
                            ];
                        @endphp
                        @foreach($prices as $label => $price)
                            @if($price)
                            <div class="bg-gray-50 dark:bg-white/[0.02] p-4 rounded-2xl border border-gray-100 dark:border-gray-800 hover:shadow-md transition-all duration-300">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="p-1.5 bg-brand-50 dark:bg-brand-500/10 rounded-lg text-brand-600 dark:text-brand-400">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                    </div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $label }}</p>
                                </div>
                                <p class="text-xl font-extrabold text-gray-800 dark:text-white/90">
                                    <span class="text-xs font-medium text-gray-400 mr-1">Rp</span>{{ number_format($price, 0, ',', '.') }}
                                </p>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Details: Meeting Point & Schedule -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2 bg-gray-50/50 dark:bg-white/[0.01]">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <h3 class="font-bold text-gray-800 dark:text-white/90">Meeting Point</h3>
                    </div>
                    <div class="p-6">
                        <div x-show="activeTab === 'id'" class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {!! $kelolaPackage->meeting_point ?: 'Belum ditentukan' !!}
                        </div>
                        <div x-show="activeTab === 'en'" x-cloak class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            {!! $kelolaPackage->meeting_point_en ?: 'Not specified' !!}
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2 bg-gray-50/50 dark:bg-white/[0.01]">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <h3 class="font-bold text-gray-800 dark:text-white/90">Jadwal Harian</h3>
                    </div>
                    <div class="p-6">
                        <div x-show="activeTab === 'id'" class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-white/90 leading-relaxed italic">
                            {!! $kelolaPackage->daily_schedule ?: '-' !!}
                        </div>
                        <div x-show="activeTab === 'en'" x-cloak class="prose prose-sm dark:prose-invert max-w-none text-gray-800 dark:text-white/90 leading-relaxed italic">
                            {!! $kelolaPackage->daily_schedule_en ?: '-' !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Itinerary -->
            <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex items-center gap-2 bg-gray-50/50 dark:bg-white/[0.01]">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L16 4m0 13V4m0 0L9 7"/></svg>
                    <h3 class="font-bold text-gray-800 dark:text-white/90">Itinerary Lengkap</h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 dark:bg-white/[0.01] p-5 rounded-2xl border border-gray-100 dark:border-gray-800/50">
                        <div x-show="activeTab === 'id'" class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-loose font-medium">
                            {!! $kelolaPackage->itinerary ?: '-' !!}
                        </div>
                        <div x-show="activeTab === 'en'" x-cloak class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-loose font-medium">
                            {!! $kelolaPackage->itinerary_en ?: '-' !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information Area -->
        <div class="space-y-6">
            <!-- Facilities & Terms -->
            <div class="bg-white dark:bg-white/[0.03] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-white/[0.01]">
                    <h3 class="font-bold text-gray-800 dark:text-white/90 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Kelengkapan & Syarat
                    </h3>
                </div>
                <div class="p-6 space-y-8">
                    <!-- Included -->
                    <div class="space-y-3">
                        <p class="text-xs font-bold text-success-600 dark:text-success-400 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Termasuk
                        </p>
                        <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 bg-success-50/30 dark:bg-success-500/5 p-4 rounded-2xl border border-success-100/50 dark:border-success-500/10">
                            <div x-show="activeTab === 'id'">{!! $kelolaPackage->facilities_included ?: '-' !!}</div>
                            <div x-show="activeTab === 'en'" x-cloak>{!! $kelolaPackage->facilities_included_en ?: '-' !!}</div>
                        </div>
                    </div>
                    <!-- Excluded -->
                    <div class="space-y-3">
                        <p class="text-xs font-bold text-error-600 dark:text-error-400 uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Tidak Termasuk
                        </p>
                        <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 bg-error-50/30 dark:bg-error-500/5 p-4 rounded-2xl border border-error-100/50 dark:border-error-500/10">
                            <div x-show="activeTab === 'id'">{!! $kelolaPackage->facilities_excluded ?: '-' !!}</div>
                            <div x-show="activeTab === 'en'" x-cloak>{!! $kelolaPackage->facilities_excluded_en ?: '-' !!}</div>
                        </div>
                    </div>
                    <!-- Requirements -->
                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            Persyaratan
                        </p>
                        <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400 italic">
                            <div x-show="activeTab === 'id'">{!! $kelolaPackage->persyaratan ?: '-' !!}</div>
                            <div x-show="activeTab === 'en'" x-cloak>{!! $kelolaPackage->persyaratan_en ?: '-' !!}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Meta & Stats Card -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 dark:from-white/[0.05] dark:to-white/[0.01] rounded-3xl p-6 text-white shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-800 dark:border-gray-700">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Informasi Sistem
                </h3>
                <div class="space-y-4">
                    <div class="bg-white/10 p-3 rounded-2xl backdrop-blur-sm border border-white/10">
                        <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Package Slug</p>
                        <p class="text-xs font-mono break-all text-brand-300">{{ $kelolaPackage->slug }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 p-3 rounded-2xl backdrop-blur-sm border border-white/10">
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">DP (Days)</p>
                            <p class="text-sm font-bold">{{ $kelolaPackage->dp_days_before }} Hari</p>
                        </div>
                        <div class="bg-white/10 p-3 rounded-2xl backdrop-blur-sm border border-white/10">
                            <p class="text-[10px] uppercase font-bold text-gray-400 mb-1">Package ID</p>
                            <p class="text-sm font-bold">#{{ str_pad($kelolaPackage->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-2">
                        <div class="flex flex-col">
                            <p class="text-[10px] uppercase font-bold text-gray-400">Created At</p>
                            <p class="text-[11px] font-medium opacity-80">{{ $kelolaPackage->created_at->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                        @if($kelolaPackage->updated_at != $kelolaPackage->created_at)
                        <div class="flex flex-col text-right">
                            <p class="text-[10px] uppercase font-bold text-gray-400">Last Update</p>
                            <p class="text-[11px] font-medium opacity-80">{{ $kelolaPackage->updated_at->diffForHumans() }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
                <button type="button"
                    @click="deleteActionUrl = '{{ route('admin.kelola-paket-wisata.destroy', $kelolaPackage) }}'; deleteItemName = 'paket wisata {{ addslashes($kelolaPackage->package_name) }}'; deleteModalOpen = true"
                    class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-2xl bg-error-50 text-error-600 hover:bg-error-100 dark:bg-error-500/10 dark:text-error-400 dark:hover:bg-error-500/20 transition-all font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus Paket Wisata
                </button>
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
                <form :action="deleteActionUrl" method="POST" @submit="deleteModalOpen = false; isDeleting = true" class="inline-block">
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
<style>
    /* Fallback styling untuk konten dari CKEditor */
    .prose strong, .prose b {
        font-weight: 900 !important;
    }
    .prose ul {
        list-style-type: disc !important;
        padding-left: 1.5rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    .prose ol {
        list-style-type: decimal !important;
        padding-left: 1.5rem !important;
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    .prose p {
        margin-bottom: 0.75rem !important;
    }
</style>
@endsection
