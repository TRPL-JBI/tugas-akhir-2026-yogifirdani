<div class="overflow-x-auto">
    <table class="w-full min-w-[800px] text-left text-sm">
        <thead>
            <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-16">#</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-48">Wisatawan</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-48">Email</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-56">Subjek</th>
                <th class="px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Pesan</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-36">Tanggal</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400 w-24">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($suggestions as $index => $saran)
            <tr id="row-{{ $saran->id }}" class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors align-top">

                <!-- Nomor -->
                <td class="whitespace-nowrap px-5 py-4 text-gray-400 dark:text-gray-500 text-xs">
                    {{ $suggestions->firstItem() + $index }}
                </td>

                <!-- Nama -->
                <td class="px-5 py-4 font-medium text-gray-800 dark:text-white/90">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                            {{ strtoupper(substr($saran->name, 0, 1)) }}
                        </div>
                        <span class="break-words max-w-[150px]">{{ $saran->name }}</span>
                    </div>
                </td>

                <!-- Email -->
                <td class="px-5 py-4 text-gray-600 dark:text-gray-300 break-all">
                    {{ $saran->email }}
                </td>

                <!-- Subjek -->
                <td class="px-5 py-4 text-gray-700 dark:text-white/80 font-medium">
                    {{ $saran->subject ?? '-' }}
                </td>

                <!-- Pesan -->
                <td class="px-5 py-4 text-gray-500 dark:text-gray-400 text-xs leading-relaxed max-w-md break-words">
                    {{ $saran->message }}
                </td>

                <!-- Tanggal -->
                <td class="whitespace-nowrap px-5 py-4 text-gray-400 dark:text-gray-500 text-xs">
                    {{ $saran->created_at->timezone('Asia/Jakarta')->format('d M Y') }}
                    <div class="text-[10px] text-gray-400 mt-0.5">{{ $saran->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</div>
                </td>

                <!-- Aksi -->
                <td class="whitespace-nowrap px-5 py-4">
                    <div class="flex items-center gap-2">
                        <button type="button" 
                                @click="deleteActionUrl = '{{ route('admin.saran-wisatawan.destroy', $saran) }}'; deleteItemName = 'saran dari {{ addslashes($saran->name) }}'; deleteItemId = 'row-{{ $saran->id }}'; deleteModalOpen = true"
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
                <td colspan="7" class="px-5 py-14 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Belum ada saran atau pesan dari wisatawan.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($suggestions->hasPages())
<div class="pagination-container border-t border-gray-200 px-5 py-4 dark:border-gray-800">
    {{ $suggestions->links() }}
</div>
@endif
