@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.user-profile.show', $user) }}"
            class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">Edit Pengguna</h1>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">{{ $user->name }}</p>
        </div>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
    <div class="rounded-lg border border-error-300 bg-error-50 px-4 py-3 dark:border-error-700 dark:bg-error-500/15">
        <ul class="list-inside list-disc space-y-1 text-sm text-error-700 dark:text-error-400">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <!-- Left: Form -->
        <div class="col-span-1 xl:col-span-2">
            <form action="{{ route('admin.user-profile.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03] space-y-5">
                    <h2 class="text-base font-semibold text-gray-800 dark:text-white/90">Informasi Pengguna</h2>

                    <!-- Nama -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Nama Lengkap <span class="text-error-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            placeholder="Nama lengkap pengguna"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Email <span class="text-error-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            placeholder="email@example.com"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>

                    <!-- No. Telepon -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            No. Telepon
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                            placeholder="08xxxxxxxxxx"
                            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                    </div>

                    <!-- Tombol -->
                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.user-profile.show', $user) }}"
                            class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right: Info Box -->
        <div class="col-span-1">
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="flex flex-col items-center text-center">
                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-100 text-2xl font-bold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400 mb-3">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $user->name }}</h3>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    <span class="mt-2 inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-400">
                        Customer
                    </span>
                </div>
                <div class="mt-5 space-y-3 border-t border-gray-100 pt-5 dark:border-gray-800 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Bergabung</span>
                        <span class="font-medium text-gray-700 dark:text-gray-300">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <div class="mt-5">
                    <p class="text-xs text-gray-400 dark:text-gray-500 leading-relaxed">
                        ⚠️ Perubahan akan langsung mempengaruhi akun pengguna tersebut.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
