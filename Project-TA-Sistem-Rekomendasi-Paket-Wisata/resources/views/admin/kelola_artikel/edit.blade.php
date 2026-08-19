@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.kelola-artikel.index') }}"
            class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">Edit Artikel</h1>
            <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">Perbarui konten artikel Anda</p>
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

    <form action="{{ route('admin.kelola-artikel.update', $kelolaArtikel->slug) }}" method="POST" enctype="multipart/form-data" x-data="{ activeTab: 'id' }">
        @csrf
        @method('PUT')

        <!-- Language Switcher Tabs -->
        <div class="flex items-center justify-between mb-6">
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
                <span x-show="activeTab === 'id'">Mengedit dalam Bahasa Indonesia</span>
                <span x-show="activeTab === 'en'">Editing in English</span>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <!-- Left Column: Content -->
            <div class="col-span-1 space-y-6 xl:col-span-2">
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="space-y-5">
                        <!-- Judul -->
                        <div x-show="activeTab === 'id'">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Judul Artikel <span class="text-error-500">*</span>
                            </label>
                            <input type="text" name="title" value="{{ old('title', $kelolaArtikel->title) }}"
                                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div x-show="activeTab === 'en'" x-cloak>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Article Title (English)
                            </label>
                            <input type="text" name="title_en" value="{{ old('title_en', $kelolaArtikel->title_en) }}"
                                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>

                        <!-- Konten -->
                        <div x-show="activeTab === 'id'">
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Isi Artikel <span class="text-error-500">*</span>
                            </label>
                            <textarea id="editor-content" name="content">{{ old('content', $kelolaArtikel->content) }}</textarea>
                        </div>
                        <div x-show="activeTab === 'en'" x-cloak>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Content (English)
                            </label>
                            <textarea id="editor-content-en" name="content_en">{{ old('content_en', $kelolaArtikel->content_en) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="col-span-1 space-y-6">
                <!-- Thumbnail -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h2 class="mb-5 text-base font-semibold text-gray-800 dark:text-white/90">Gambar Utama</h2>
                    <div class="space-y-4">
                        <div class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 p-4 dark:border-gray-700 cursor-pointer hover:border-brand-400 transition-colors"
                             x-data="{ preview: '{{ $kelolaArtikel->image_url }}' }"
                             @click="$refs.fileInput.click()">
                            <template x-if="!preview">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="mt-2 text-xs font-semibold text-brand-600">Format WAJIB: .WEBP</p>
                                    <p class="mt-1 text-[11px] text-gray-500">Maksimal Ukuran: 150 KB</p>
                                </div>
                            </template>
                            <template x-if="preview">
                                <div class="relative w-full">
                                    <img :src="preview" class="h-40 w-full rounded-lg object-cover">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 hover:opacity-100 transition-opacity rounded-lg">
                                        <p class="text-white text-xs font-medium">Ganti Gambar</p>
                                    </div>
                                </div>
                            </template>
                            <input type="file" name="image" x-ref="fileInput" class="hidden" @change="preview = URL.createObjectURL($event.target.files[0])">
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <h2 class="mb-5 text-base font-semibold text-gray-800 dark:text-white/90">Status</h2>
                    <select name="status" class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        <option value="active" {{ old('status', $kelolaArtikel->status) == 'active' ? 'selected' : '' }}>Aktif (Tampil)</option>
                        <option value="draft" {{ old('status', $kelolaArtikel->status) == 'draft' ? 'selected' : '' }}>Draft (Sembunyi)</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
                    <div class="flex flex-col gap-3">
                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-lg bg-brand-500 px-4 py-3 text-sm font-medium text-white shadow-theme-xs hover:bg-brand-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Perbarui Artikel
                        </button>
                        <a href="{{ route('admin.kelola-artikel.index') }}" class="flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-transparent dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor-content'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
        })
        .catch(error => { console.error(error); });

    ClassicEditor
        .create(document.querySelector('#editor-content-en'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
        })
        .catch(error => { console.error(error); });
</script>
<style>
    .ck-editor__editable {
        min-height: 400px;
        background-color: transparent !important;
        color: inherit !important;
    }
    .dark .ck-editor__editable {
        background-color: rgb(17 24 39) !important;
        color: white !important;
    }
</style>
@endpush
