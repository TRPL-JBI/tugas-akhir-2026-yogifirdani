<div class="overflow-x-auto">
    <table class="w-full text-left">
        <thead class="border-b border-gray-100 dark:border-gray-800">
            <tr>
                <th class="px-5 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">#</th>
                <th class="px-5 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">Judul</th>
                <th class="px-5 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">Penulis</th>
                <th class="px-5 py-4 text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                <th class="px-5 py-4 text-sm font-medium text-gray-500 dark:text-gray-400 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @forelse ($articles as $article)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ ($articles->currentPage() - 1) * $articles->perPage() + $loop->iteration }}
                </td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        @if($article->image)
                            <img src="{{ $article->image_url }}" class="h-10 w-10 rounded-lg object-cover shadow-sm">
                        @else
                            <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-white/90 line-clamp-1">{{ $article->title }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $article->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ $article->author->name ?? 'Unknown' }}
                </td>
                <td class="px-5 py-4">
                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $article->status === 'active' ? 'bg-success-50 text-success-700 dark:bg-success-500/15 dark:text-success-400' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400' }}">
                        {{ ucfirst($article->status) }}
                    </span>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.kelola-artikel.edit', $article->slug) }}" class="rounded-lg border border-gray-200 p-2 text-gray-600 hover:bg-gray-50 hover:text-brand-500 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-white/[0.03] transition-colors shadow-sm">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button type="button" 
                                @click="deleteActionUrl = '{{ route('admin.kelola-artikel.destroy', $article->slug) }}'; deleteItemName = 'artikel {{ addslashes($article->title) }}'; deleteModalOpen = true"
                                class="rounded-lg border border-gray-200 p-2 text-gray-600 hover:bg-error-50 hover:text-error-500 dark:border-gray-800 dark:text-gray-400 dark:hover:bg-error-500/10 transition-colors shadow-sm">
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                    Tidak ada artikel ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($articles->hasPages())
<div class="pagination-container border-t border-gray-100 dark:border-gray-800 px-5 py-4">
    {{ $articles->links() }}
</div>
@endif
