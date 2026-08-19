@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ deleteModalOpen: false, deleteActionUrl: '', deleteItemName: '', deleteItemId: null, isDeleting: false }" x-init="$watch('deleteModalOpen', value => { if (!value) isDeleting = false })">

    <!-- Page Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white/90">Saran Wisatawan</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Daftar pesan, pertanyaan, dan masukan dari wisatawan</p>
        </div>
        <div class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2.5 dark:border-gray-800 dark:bg-white/[0.03]">
            <span class="text-sm text-gray-500 dark:text-gray-400">Total Saran:</span>
            <span class="text-sm font-semibold text-brand-600 dark:text-brand-400">{{ $suggestions->total() }}</span>
        </div>
    </div>

    <!-- Alert -->
    @if(session('success'))
    <div class="flex items-center gap-3 rounded-lg border border-success-300 bg-success-50 px-4 py-3 text-sm text-success-700 dark:border-success-700 dark:bg-success-500/15 dark:text-success-400">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.saran-wisatawan.index') }}" class="flex flex-wrap items-center gap-2">
            <div class="relative flex-1 min-w-[200px] sm:max-w-sm">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}"
                     placeholder="Cari nama, email, subjek, atau pesan..."
                     class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-10 w-full rounded-lg border border-gray-300 bg-white dark:bg-gray-900 pl-10 pr-4 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:placeholder:text-white/30" />
            </div>
            <button type="submit"
                class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                Cari
            </button>
            <a href="{{ route('admin.saran-wisatawan.index') }}"
                class="reset-search {{ request('search') ? '' : 'hidden' }} inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 transition-colors">
                Reset
            </a>
        </form>

        <!-- Entries per page -->
        <div class="flex items-center gap-2 self-end sm:self-auto">
            <span class="text-xs text-gray-500 dark:text-gray-400">Tampilkan</span>
            <select name="per_page" id="per-page-select"
                class="shadow-theme-xs h-10 rounded-lg border border-gray-300 bg-white dark:bg-gray-900 px-3 py-1.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:text-white/90">
                <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                <option value="25" {{ request('per_page', 5) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page', 5) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page', 5) == 100 ? 'selected' : '' }}>100</option>
            </select>
            <span class="text-xs text-gray-500 dark:text-gray-400">entri</span>
        </div>
    </div>

    <!-- Table Card -->
    <div id="table-container" class="overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        @include('admin.saran._table')
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
                <form :action="deleteActionUrl" method="POST" @submit.prevent="deleteModalOpen = false; isDeleting = true; submitDeleteForm($el, deleteItemId)" class="inline-block">
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

        // Intercept and handle delete via AJAX
        window.submitDeleteForm = async function(form, rowId) {
            if (rowId) {
                const row = document.getElementById(rowId);
                if (row) {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    setTimeout(() => {
                        row.style.display = 'none';
                    }, 300);
                }
            }
            try {
                await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                });
                
                await updateTable(window.location.href);
            } catch (error) {
                console.error('Error deleting:', error);
            }
        };

        // Function to fetch and update table
        async function updateTable(url) {
            // Add loading state
            tableContainer.style.opacity = '0.5';
            tableContainer.style.pointerEvents = 'none';

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const html = await response.text();
                tableContainer.innerHTML = html;
                
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
                console.error('Error fetching table:', error);
            } finally {
                tableContainer.style.opacity = '1';
                tableContainer.style.pointerEvents = 'auto';
            }
        }

        const perPageSelect = document.getElementById('per-page-select');

        // Handle per page select change
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', this.value);
                url.searchParams.set('page', 1);
                updateTable(url.toString());
            });
        }

        // Handle search input (debounce)
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const url = new URL(searchForm.action);
                url.searchParams.set('search', this.value);
                if (perPageSelect) {
                    url.searchParams.set('per_page', perPageSelect.value);
                }
                updateTable(url.toString());
            }, 500);
        });

        // Prevent form submission reload
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const url = new URL(this.action);
            url.searchParams.set('search', searchInput.value);
            if (perPageSelect) {
                url.searchParams.set('per_page', perPageSelect.value);
            }
            updateTable(url.toString());
        });

        // Handle pagination clicks (Event Delegation)
        tableContainer.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination-container a');
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
                updateTable(resetBtn.href);
            }
        });
    });
</script>
@endsection
