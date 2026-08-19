<div class="overflow-x-auto">
    <table class="w-full min-w-[650px] text-left text-sm">
        <thead>
            <tr class="border-b border-gray-200 dark:border-gray-800">
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400">#</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Pengguna</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Email</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400">No. Telepon</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Terdaftar</th>
                <th class="whitespace-nowrap px-5 py-4 font-medium text-gray-500 dark:text-gray-400">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse($users as $index => $user)
            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">

                <!-- Nomor -->
                <td class="whitespace-nowrap px-5 py-4 text-gray-400 dark:text-gray-500 text-xs">
                    {{ $users->firstItem() + $index }}
                </td>

                <!-- Avatar + Nama -->
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-gray-800 dark:text-white/90">{{ $user->name }}</span>
                    </div>
                </td>

                <!-- Email -->
                <td class="whitespace-nowrap px-5 py-4 text-gray-600 dark:text-gray-300">
                    {{ $user->email }}
                </td>

                <!-- Phone -->
                <td class="whitespace-nowrap px-5 py-4 text-gray-500 dark:text-gray-400">
                    {{ $user->phone ?? '-' }}
                </td>

                <!-- Terdaftar -->
                <td class="whitespace-nowrap px-5 py-4 text-gray-500 dark:text-gray-400 text-xs">
                    {{ $user->created_at->format('d M Y') }}
                </td>

                <!-- Aksi -->
                <td class="whitespace-nowrap px-5 py-4">
                    <div class="flex items-center gap-2">

                        {{-- Detail --}}
                        <a href="{{ route('admin.user-profile.show', $user) }}"
                            title="Lihat Detail"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>

                        {{-- Edit --}}
                        <a href="{{ route('admin.user-profile.edit', $user) }}"
                            title="Edit"
                            class="flex h-8 w-8 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-500 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>

                        <button type="button" 
                                @click="deleteActionUrl = '{{ route('admin.user-profile.destroy', $user) }}'; deleteItemName = 'pengguna {{ addslashes($user->name) }}'; deleteModalOpen = true"
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
                <td colspan="6" class="px-5 py-14 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Tidak ada pengguna ditemukan.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($users->hasPages())
<div class="pagination-container border-t border-gray-200 px-5 py-4 dark:border-gray-800">
    {{ $users->links() }}
</div>
@endif
