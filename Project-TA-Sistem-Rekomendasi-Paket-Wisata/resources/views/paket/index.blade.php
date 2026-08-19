@extends('template')

@section('content')

@push('styles')
<style>
    /* Pagination Elegance */
    .custom-pagination {
        display: inline-flex;
        gap: 6px;
        align-items: center;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .custom-pagination li {
        display: inline-block;
    }
    .custom-pagination li a, .custom-pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid #ffccb3; /* Soft orange/red border for inactive */
        color: #ff6b6b; /* Orange/red text */
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        background: #fff;
        border-radius: 50%;
    }
    .custom-pagination li.active span {
        background: rgb(87, 201, 209); /* Theme blue/cyan */
        color: #fff;
        border-color: rgb(87, 201, 209);
        box-shadow: 0 4px 10px rgba(87, 201, 209, 0.3);
    }
    .custom-pagination li a:hover {
        border-color: rgb(87, 201, 209);
        color: rgb(87, 201, 209);
    }
    .custom-pagination li.disabled span {
        color: #ccc;
        border-color: #eee;
        background: #fafafa;
    }
    
    /* Shape for Prev button (D-shape facing left) */
    .custom-pagination li:first-child a, .custom-pagination li:first-child span {
        border-radius: 8px 20px 20px 8px;
        border-color: #ddd;
        color: #777;
    }
    
    /* Shape for Next button (D-shape facing right) */
    .custom-pagination li:last-child a, .custom-pagination li:last-child span {
        border-radius: 20px 8px 8px 20px;
        border-color: #ffccb3;
        color: #ff6b6b;
    }
</style>
@endpush
<!-- Hero Section -->
<div class="hero-wrap" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}'); background-size: cover; background-position: center; height: 60vh; min-height: 400px;">
  <div class="overlay"></div>
  <div class="container" style="height: 100%;">
    <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 100%;" data-scrollax-parent="true">
      <div class="col-md-9 text-center" data-scrollax=" properties: { translateY: '70%' }">
        <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }"><span class="mr-2"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></span> <span>{{ __('messages.tour_packages') }}</span></p>
        <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" style="color: #fff; font-weight: 700;">
            @if($selectedCategory && $selectedType)
                {{ $selectedCategory->category_name }} - {{ $selectedType->type_name }}
            @elseif($selectedCategory)
                {{ $selectedCategory->category_name }}
            @elseif($selectedType)
                {{ $selectedType->type_name }}
            @else
                {{ __('messages.all_packages') }}
            @endif
        </h1>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<section class="ftco-section bg-light">
  <div class="container">
    
    {{-- Filter Dropdown
    <div class="row justify-content-center mb-5 pb-3" style="position: relative; z-index: 99;">
      <div class="col-md-7 heading-section text-center ftco-animate">
        <h2 class="mb-4">{{ __('messages.filter_tour') }}</h2>
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 10px 30px; border-radius: 30px; font-size: 16px; background-color: #2188ff; border-color: #2188ff;">
            {{ $selectedType ? $selectedType->getTranslation('type_name') : __('messages.choose_type') }}
          </button>
          <div class="dropdown-menu shadow-lg border-0" aria-labelledby="filterDropdown" style="z-index: 9999; border-radius: 15px; margin-top: 10px; min-width: 250px; left: 50%; transform: translateX(-50%);">
            <a class="dropdown-item py-3 {{ !$selectedType ? 'active' : '' }}" href="{{ lroute('paket-wisata') }}" style="font-weight: 600;">{{ __('messages.all_packages') }}</a>
            @foreach($packageTypes as $type)
              <a class="dropdown-item py-3 {{ ($selectedType && $selectedType->id == $type->id) ? 'active' : '' }}" href="{{ lroute('paket-wisata', ['tipe' => $type->slug]) }}" style="font-weight: 500;">{{ $type->getTranslation('type_name') }}</a>
            @endforeach
          </div>
        </div>
      </div>
    </div> --}}

    <!-- Package Grid -->
    <div class="row">
      @forelse($packages as $package)
        <div class="col-sm-6 col-md-3 ftco-animate mb-4">
          @include('paket.card', ['package' => $package])
        </div>
      @empty
        <div class="col-12 text-center py-5">
            <div class="alert alert-info" style="border-radius: 15px;">
                {{ __('messages.no_packages_found') }}
            </div>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="row mt-4 mb-5">
      <div class="col text-right" style="padding-right: 30px;">
        {{ $packages->appends(request()->query())->links('vendor.pagination.custom') }}
      </div>
    </div>
    
  </div>
</section>

@endsection
