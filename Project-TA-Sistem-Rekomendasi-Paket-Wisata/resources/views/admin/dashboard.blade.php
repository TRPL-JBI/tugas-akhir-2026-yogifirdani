@extends('layouts.app')

@section('content')
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <!-- Metrics & Monthly Sale (Spans full width since Monthly Target is hidden) -->
    <div class="col-span-12 space-y-6">
      <x-dashboard.ecommerce-metrics 
        :total-users="$totalUsers" 
        :total-packages="$totalPackages" 
        :total-destinations="$totalDestinations" 
        :monthly-revenues="$monthlyRevenues"
        :total-revenue-all-time="$totalRevenueAllTime"
      />
      <x-dashboard.monthly-sale 
        :monthly-bookings="$monthlyBookings" 
      />
    </div>

    <!-- Monthly Target is hidden as requested, but preserved in code for future use -->
    <div class="hidden">
        <x-dashboard.monthly-target />
    </div>

    <!-- Statistics is hidden as requested, but preserved in code for future use -->
    <div class="hidden col-span-12">
      <x-dashboard.statistics-chart />
    </div>

    <!-- Customers Demographic is hidden as requested, but preserved in code for future use -->
    <div class="hidden col-span-12 xl:col-span-5">
      <x-dashboard.customer-demographic />
    </div>

    <!-- Recent Orders is hidden as requested, but preserved in code for future use -->
    <div class="hidden col-span-12 xl:col-span-7">
      <x-dashboard.recent-orders />
    </div>
  </div>
@endsection
