@props([
    'monthlyBookings' => []
])

<div
    class="overflow-hidden rounded-2xl border border-gray-200 bg-white px-5 pt-5 sm:px-6 sm:pt-6 dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
            Grafik Pembeli Bulanan
        </h3>
    </div>

    <div class="max-w-full overflow-x-auto custom-scrollbar">
        <div id="chartOne" data-series="{{ json_encode($monthlyBookings) }}" class="-ml-5 min-w-[690px] pl-2 xl:min-w-full" style="min-height: 180px;"></div>
    </div>
</div>
