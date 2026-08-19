<div class="overflow-x-auto">
    <table class="w-full min-w-[700px] text-sm">
        <thead>
            <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">#</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Nama Paket</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Kategori Paket</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Kategori Wisata</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Kota</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Durasi</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                <th class="px-5 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($packages as $index => $package)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                <td class="px-5 py-4 text-gray-500 dark:text-gray-400">{{ $packages->firstItem() + $index }}</td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        @if($package->image)
                            <img src="{{ $package->image_url }}" class="h-10 w-10 rounded-lg object-cover shadow-sm">
                        @else
                            <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="font-medium text-gray-800 dark:text-white/90">{{ $package->package_name }}</span>
                    </div>
                </td>
                <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $package->category->category_name ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $package->tour_category ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $package->packageType->type_name ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $package->city }}</td>
                <td class="px-5 py-4 text-gray-600 dark:text-gray-300">{{ $package->duration }}</td>
                <td class="px-5 py-4">
                    @if($package->is_active)
                        <span class="inline-flex rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/15 dark:text-success-400">Aktif</span>
                    @else
                        <span class="inline-flex rounded-full bg-error-50 px-2.5 py-0.5 text-xs font-medium text-error-700 dark:bg-error-500/15 dark:text-error-400">Nonaktif</span>
                    @endif
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-2">
                        {{-- Detail --}}
                        <a href="{{ route('admin.kelola-paket-wisata.show', $package) }}"
                            title="Lihat Detail"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.kelola-paket-wisata.edit', $package) }}"
                            title="Edit"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>

                        <button type="button" 
                                @click="deleteActionUrl = '{{ route('admin.kelola-paket-wisata.destroy', $package) }}'; deleteItemName = 'paket wisata {{ addslashes($package->package_name) }}'; deleteModalOpen = true"
                                title="Hapus"
                                class="flex h-8 w-8 items-center justify-center rounded-lg border border-error-200 bg-error-50 text-error-600 hover:bg-error-100 dark:border-error-700 dark:bg-error-500/15 dark:text-error-400 dark:hover:bg-error-500/25 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                    Belum ada paket wisata. <a href="{{ route('admin.kelola-paket-wisata.create') }}" class="text-brand-500 hover:underline">Tambah sekarang</a>.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($packages->hasPages())
<div class="pagination-container border-t border-gray-200 px-5 py-4 dark:border-gray-800">
    {{ $packages->links() }}
</div>
@endif
