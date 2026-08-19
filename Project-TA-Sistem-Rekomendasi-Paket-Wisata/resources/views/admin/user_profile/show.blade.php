@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteItemName: '', isDeleting: false }" x-init="$watch('deleteModalOpen', value => { if (!value) isDeleting = false })">

    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.user-profile.index') }}"
            class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">Detail Pengguna</h1>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $user->name }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <!-- Profile Card -->
        <div class="col-span-1">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <!-- Avatar -->
                <div class="flex flex-col items-center text-center">
                    <div class="flex h-20 w-20 items-center justify-center rounded-full bg-brand-100 text-3xl font-bold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white/90">{{ $user->name }}</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="mt-3 inline-flex items-center rounded-full bg-success-50 px-3 py-1 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-400">
                        Customer
                    </span>
                </div>

                <!-- Stats -->
                <div class="mt-6 grid grid-cols-1 gap-3 border-t border-gray-100 pt-6 dark:border-gray-800">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">No. Telepon</span>
                        <span class="font-medium text-gray-800 dark:text-white/90">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Bergabung</span>
                        <span class="font-medium text-gray-800 dark:text-white/90">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex flex-col gap-2">
                    <a href="{{ route('admin.user-profile.edit', $user) }}"
                        class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Data
                    </a>
                    <button type="button"
                        @click="deleteActionUrl = '{{ route('admin.user-profile.destroy', $user) }}'; deleteItemName = 'pengguna {{ addslashes($user->name) }}'; deleteModalOpen = true"
                        class="flex w-full items-center justify-center gap-2 rounded-lg border border-error-200 bg-error-50 px-4 py-2.5 text-sm font-medium text-error-700 hover:bg-error-100 dark:border-error-700 dark:bg-error-500/15 dark:text-error-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Pengguna
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Detail -->
        <div class="col-span-1 xl:col-span-2 space-y-6">

            <!-- Informasi Akun -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <h3 class="mb-5 text-base font-semibold text-gray-800 dark:text-white/90">Informasi Akun</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Nama Lengkap</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Email</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">No. Telepon</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->phone ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Status Email</p>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-success-600 dark:text-success-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-warning-600 dark:text-warning-400">
                                    Belum Terverifikasi
                                </span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Tanggal Daftar</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-1">Terakhir Diperbarui</p>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $user->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
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
@endsection
