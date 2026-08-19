@extends('template')
@section('content')
<style>
    /* Override warna merah template ke biru brand */
    .testimony-section .quote {
        background: rgb(87, 201, 209) !important;
    }
    .testimony-section .quote i {
        color: #fff !important;
        font-size: 14px;
    }
    .testimony-section .owl-dots .owl-dot.active span {
        background: rgb(87, 201, 209) !important;
    }
    /* Ganti warna utama tombol dari merah ke warna brand */
    .btn.btn-primary {
        background: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        color: #fff !important;
    }
    .btn.btn-primary:hover {
        background: rgb(68, 189, 199) !important;
        border-color: rgb(68, 189, 199) !important;
        color: #fff !important;
        box-shadow: 0 4px 20px rgba(87, 201, 209, 0.4) !important;
    }
    .btn-outline-white:hover {
        background: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        color: #fff !important;
    }
    .btn-outline-primary {
        border-color: rgb(87, 201, 209) !important;
        color: rgb(87, 201, 209) !important;
    }
    .btn-outline-primary:hover {
        background-color: rgb(87, 201, 209) !important;
        border-color: rgb(87, 201, 209) !important;
        color: #fff !important;
    }
    .testimony-section .subheading {
        color: rgb(87, 201, 209) !important;
    }
    /* Perbaikan panah kiri-kanan slider */
    .owl-nav button {
        color: rgb(87, 201, 209) !important;
        outline: none !important;
    }
    .owl-nav button span {
        font-size: 40px !important;
        line-height: 1;
    }
    .owl-nav button:hover {
        background: transparent !important;
        color: rgb(68, 189, 199) !important;
    }
</style>

    <div class="hero-wrap" 
     style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}');
     background-size: cover; background-position: center; height: 80vh; min-height: 600px;">
      <div class="overlay"></div>
      <div class="container" style="height: 100%;">
        <div class="row no-gutters slider-text align-items-center justify-content-start" style="height: 100%;" data-scrollax-parent="true">
          <div class="col-md-9" data-scrollax=" properties: { translateY: '70%' }">
            <h1 class="mb-2" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" style="line-height: 1;">
              <span style="font-family: 'Alex Brush', cursive; font-size: clamp(2.5rem, 8vw, 4.5rem); color: #fff; font-weight: 400; display: block; margin-bottom: -10px;">{{ __('messages.hero_title_1') }}</span>
              <span style="font-size: clamp(2rem, 6vw, 3.5rem); font-weight: 600;">{{ __('messages.hero_title_2') }}</span>
            </h1>
            <p class="mb-8" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" style="font-size: clamp(0.9rem, 3vw, 1.1rem); color: rgba(255,255,255,0.9); font-weight: 400; max-width: 600px; line-height: 1.6;">
              {{ __('messages.hero_subtitle') }}
            </p>
            <div data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" class="mt-4">
              <a href="{{ lroute('paket-wisata') }}" class="btn btn-primary py-3 px-4 mr-md-2 mb-2 mb-md-0" style="border-radius: 30px; font-weight: 500; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">{{ __('messages.see_packages') }}</a>
              <a href="{{ lroute('about') }}" class="btn btn-white btn-outline-white py-3 px-4" style="border-radius: 30px; font-weight: 500;">{{ __('messages.know_us') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <section class="ftco-section services-section bg-light">
      <div class="container">
        <div class="row d-flex">
          <div class="col-sm-6 col-md-3 d-flex align-self-stretch ftco-animate mb-4">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center"><div class="icon"><span class="fa fa-shield"></span></div></div>
              <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">{{ __('messages.best_price_guarantee') }}</h3>
                <p>{{ __('messages.services_desc') }}</p>
              </div>
            </div>      
          </div>
          <div class="col-sm-6 col-md-3 d-flex align-self-stretch ftco-animate mb-4">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center"><div class="icon"><span class="fa fa-thumbs-up"></span></div></div>
              <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">{{ __('messages.travellers_love_us') }}</h3>
                <p>{{ __('messages.services_desc') }}</p>
              </div>
            </div>    
          </div>
          <div class="col-sm-6 col-md-3 d-flex align-self-stretch ftco-animate mb-4">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center"><div class="icon"><span class="fa fa-search"></span></div></div>
              <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">{{ __('messages.best_travel_agent') }}</h3>
                <p>{{ __('messages.services_desc') }}</p>
              </div>
            </div>      
          </div>
          <div class="col-sm-6 col-md-3 d-flex align-self-stretch ftco-animate mb-4">
            <div class="media block-6 services d-block text-center">
              <div class="d-flex justify-content-center"><div class="icon"><span class="fa fa-phone"></span></div></div>
              <div class="media-body p-2 mt-2">
                <h3 class="heading mb-3">{{ __('messages.dedicated_support') }}</h3>
                <p>{{ __('messages.services_desc') }}</p>
              </div>
            </div>      
          </div>
        </div>
      </div>
    </section> -->
    
    <!-- <section class="ftco-section ftco-destination">
    	<div class="container">
    		<div class="row justify-content-start mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate">
          	<span class="subheading">Featured</span>
            <h2 class="mb-4"><strong>Featured</strong> Destination</h2>
          </div>
        </div>
    		<div class="row">
    			<div class="col-md-12">
    				<div class="destination-slider owl-carousel ftco-animate">
    					<div class="item">
		    				<div class="destination">
		    					<a href="#" class="img d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/destination-1.jpg);">
		    						<div class="icon d-flex justify-content-center align-items-center">
		    							<span class="icon-search2"></span>
		    						</div>
		    					</a>
		    					<div class="text p-3">
		    						<h3><a href="#">Paris, Italy</a></h3>
		    						<span class="listing">15 Listing</span>
		    					</div>
		    				</div>
	    				</div>
	    				<div class="item">
		    				<div class="destination">
		    					<a href="#" class="img d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/destination-2.jpg);">
		    						<div class="icon d-flex justify-content-center align-items-center">
		    							<span class="icon-search2"></span>
		    						</div>
		    					</a>
		    					<div class="text p-3">
		    						<h3><a href="#">San Francisco, USA</a></h3>
		    						<span class="listing">20 Listing</span>
		    					</div>
		    				</div>
	    				</div>
	    				<div class="item">
		    				<div class="destination">
		    					<a href="#" class="img d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/destination-3.jpg);">
		    						<div class="icon d-flex justify-content-center align-items-center">
		    							<span class="icon-search2"></span>
		    						</div>
		    					</a>
		    					<div class="text p-3">
		    						<h3><a href="#">Lodon, UK</a></h3>
		    						<span class="listing">10 Listing</span>
		    					</div>
		    				</div>
	    				</div>
	    				<div class="item">
		    				<div class="destination">
		    					<a href="#" class="img d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/destination-4.jpg);">
		    						<div class="icon d-flex justify-content-center align-items-center">
		    							<span class="icon-search2"></span>
		    						</div>
		    					</a>
		    					<div class="text p-3">
		    						<h3><a href="#">Lion, Singapore</a></h3>
		    						<span class="listing">3 Listing</span>
		    					</div>
		    				</div>
	    				</div>
	    				<div class="item">
		    				<div class="destination">
		    					<a href="#" class="img d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/destination-5.jpg);">
		    						<div class="icon d-flex justify-content-center align-items-center">
		    							<span class="icon-search2"></span>
		    						</div>
		    					</a>
		    					<div class="text p-3">
		    						<h3><a href="#">Australia</a></h3>
		    						<span class="listing">3 Listing</span>
		    					</div>
		    				</div>
	    				</div>
	    				<div class="item">
		    				<div class="destination">
		    					<a href="#" class="img d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/destination-6.jpg);">
		    						<div class="icon d-flex justify-content-center align-items-center">
		    							<span class="icon-search2"></span>
		    						</div>
		    					</a>
		    					<div class="text p-3">
		    						<h3><a href="#">Paris, Italy</a></h3>
		    						<span class="listing">3 Listing</span>
		    					</div>
		    				</div>
	    				</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section> -->

    <section class="ftco-section bg-light">
    	<div class="container">
				<div class="row justify-content-start mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate">
          	<span class="subheading">{{ __('messages.special_offers') }}</span>
            <h2 class="mb-4"><strong>Top</strong> {{ __('messages.tour_packages') }}</h2>
          </div>
        </div>    		
    		<div class="row">
                @if(isset($topPackages) && $topPackages->count() > 0)
                    @foreach($topPackages as $package)
                        <div class="col-md-6 col-lg-3 ftco-animate mb-4">
                            @include('paket.card', ['package' => $package])
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center py-5">
                        <p style="color: #666;">Belum ada paket wisata yang tersedia.</p>
                    </div>
                @endif
    		</div>
    	</div>
    </section>

    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}');">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-4">{{ __('messages.fun_facts') }}</h2>
            <span class="subheading">{{ __('messages.fun_facts_desc') }}</span>
          </div>
        </div>
    		<div class="row justify-content-center">
    			<div class="col-md-10">
		    		<div class="row">
		          <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="{{ $totalUsers }}">0</strong>
		                <span>{{ __('messages.registered_users') }}</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="{{ $totalPackages }}">0</strong>
		                <span>{{ __('messages.all_packages') }}</span>
		              </div>
		            </div>
		          </div>
		          <div class="col-md-4 d-flex justify-content-center counter-wrap ftco-animate">
		            <div class="block-18 text-center">
		              <div class="text">
		                <strong class="number" data-number="{{ $totalDestinations }}">0</strong>
		                <span>{{ __('messages.all_destinations') }}</span>
		              </div>
		            </div>
		          </div>
		        </div>
	        </div>
        </div>
    	</div>
    </section>


    <!-- <section class="ftco-section">
    	<div class="container">
				<div class="row justify-content-start mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate">
          	<span class="subheading">Special Offers</span>
            <h2 class="mb-4"><strong>Popular</strong> Hotels &amp; Rooms</h2>
          </div>
        </div>    		
    	</div>
    	<div class="container-fluid">
    		<div class="row">
    			<div class="col-sm col-md-6 col-lg ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/hotel-1.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<div class="d-flex">
    							<div class="one">
		    						<h3><a href="#">Hotel, Italy</a></h3>
		    						<p class="rate">
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star-o"></i>
		    							<span>8 Rating</span>
		    						</p>
	    						</div>
	    						<div class="two">
	    							<span class="price per-price">$40<br><small>/night</small></span>
    							</div>
    						</div>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> Miami, Fl</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm col-md-6 col-lg ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/hotel-2.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<div class="d-flex">
    							<div class="one">
		    						<h3><a href="#">Hotel, Italy</a></h3>
		    						<p class="rate">
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star-o"></i>
		    							<span>8 Rating</span>
		    						</p>
	    						</div>
	    						<div class="two">
	    							<span class="price per-price">$40<br><small>/night</small></span>
    							</div>
    						</div>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> Miami, Fl</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm col-md-6 col-lg ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/hotel-3.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<div class="d-flex">
    							<div class="one">
		    						<h3><a href="#">Hotel, Italy</a></h3>
		    						<p class="rate">
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star-o"></i>
		    							<span>8 Rating</span>
		    						</p>
	    						</div>
	    						<div class="two">
	    							<span class="price per-price">$40<br><small>/night</small></span>
    							</div>
    						</div>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> Miami, Fl</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm col-md-6 col-lg ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/hotel-4.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<div class="d-flex">
    							<div class="one">
		    						<h3><a href="#">Hotel, Italy</a></h3>
		    						<p class="rate">
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star-o"></i>
		    							<span>8 Rating</span>
		    						</p>
	    						</div>
	    						<div class="two">
	    							<span class="price per-price">$40<br><small>/night</small></span>
    							</div>
    						</div>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> Miami, Fl</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-sm col-md-6 col-lg ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/hotel-5.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<div class="d-flex">
    							<div class="one">
		    						<h3><a href="#">Hotel, Italy</a></h3>
		    						<p class="rate">
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star"></i>
		    							<i class="icon-star-o"></i>
		    							<span>8 Rating</span>
		    						</p>
	    						</div>
	    						<div class="two">
	    							<span class="price per-price">$40<br><small>/night</small></span>
    							</div>
    						</div>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> Miami, Fl</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section> -->

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row justify-content-start mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate">
            <span class="subheading">{{ __('messages.recent_blog') }}</span>
            <h2><strong>{{ __('messages.tips_articles') }}</strong></h2>
          </div>
        </div>
        <div class="row">
          @forelse($latestArticles as $article)
            <div class="col-sm-6 col-md-3 ftco-animate mb-4">
              <div class="d-flex flex-column h-100" style="border-radius: 12px; overflow: hidden; box-shadow: 0 3px 12px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.05); background: #fff; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 12px rgba(0,0,0,0.06)';">

                {{-- Gambar --}}
                <a href="{{ lroute('article.show', $article->slug) }}" style="display: block; overflow: hidden; height: 170px;">
                  <img src="{{ $article->image_url ?? asset('images/no-image.jpg') }}"
                       alt="{{ $article->getTranslation('title') }}"
                       style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                       onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                       loading="lazy" width="300" height="170">
                </a>

                {{-- Konten --}}
                <div class="p-3 d-flex flex-column flex-grow-1">

                  {{-- Meta --}}
                  <div class="d-flex align-items-center mb-1" style="font-size: 11px; color: #999;">
                    <i class="fa fa-calendar mr-1" style="color: rgb(87, 201, 209);"></i>
                    <span class="mr-2">{{ $article->created_at->format('d M Y') }}</span>
                    <i class="fa fa-user mr-1" style="color: rgb(87, 201, 209);"></i>
                    <span>{{ $article->author->name ?? 'Admin' }}</span>
                  </div>

                  {{-- Judul --}}
                  <h3 style="font-size: 14px; font-weight: 700; line-height: 1.4; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">
                    <a href="{{ lroute('article.show', $article->slug) }}" style="color: #222; text-decoration: none;">{{ $article->getTranslation('title') }}</a>
                  </h3>

                  {{-- Tombol --}}
                  <div class="mt-auto" style="border-top: 1px solid #f0f0f0; padding-top: 8px;">
                    <a href="{{ lroute('article.show', $article->slug) }}"
                       style="background: rgb(87, 201, 209); color: #fff; border-radius: 20px; padding: 5px 14px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; box-shadow: 0 2px 8px rgba(87,201,209,0.3);">
                      {{ __('messages.read_more') }} <i class="fa fa-arrow-right" style="font-size: 11px;"></i>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted">Belum ada artikel terbaru.</p>
            </div>
          @endforelse
        </div>
      </div>
    </section>

    <!-- <section class="ftco-section">
    	<div class="container">
				<div class="row justify-content-start mb-5 pb-3">
          <div class="col-md-7 heading-section ftco-animate">
          	<span class="subheading">Special Offers</span>
            <h2 class="mb-4"><strong>Popular</strong> Restaurants</h2>
          </div>
        </div>    		
    		<div class="row">
    			<div class="col-md-6 col-lg-3 ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/restaurant-1.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<h3><a href="#">Luxury Restaurant</a></h3>
    						<p class="rate">
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star-o"></i>
    							<span>8 Rating</span>
    						</p>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> San Franciso, CA</span> 
    							<span class="ml-auto"><a href="#">Discover</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-6 col-lg-3 ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/restaurant-2.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<h3><a href="#">Luxury Restaurant</a></h3>
    						<p class="rate">
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star-o"></i>
    							<span>8 Rating</span>
    						</p>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> San Franciso, CA</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-6 col-lg-3 ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/restaurant-3.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<h3><a href="#">Luxury Restaurant</a></h3>
    						<p class="rate">
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star-o"></i>
    							<span>8 Rating</span>
    						</p>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> San Franciso, CA</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    			<div class="col-md-6 col-lg-3 ftco-animate">
    				<div class="destination">
    					<a href="#" class="img img-2 d-flex justify-content-center align-items-center" style="background-image: url(https://themewagon.github.io/direngine/images/restaurant-4.jpg);">
    						<div class="icon d-flex justify-content-center align-items-center">
    							<span class="icon-search2"></span>
    						</div>
    					</a>
    					<div class="text p-3">
    						<h3><a href="#">Luxury Restaurant</a></h3>
    						<p class="rate">
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star"></i>
    							<i class="icon-star-o"></i>
    							<span>8 Rating</span>
    						</p>
    						<p>Far far away, behind the word mountains, far from the countries</p>
    						<hr>
    						<p class="bottom-area d-flex">
    							<span><i class="icon-map-o"></i> San Franciso, CA</span> 
    							<span class="ml-auto"><a href="#">Book Now</a></span>
    						</p>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
    </section> -->

    <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-start">
          <div class="col-md-5 heading-section ftco-animate">
          	<span class="subheading">Best Directory Website</span>
            <h2 class="mb-4 pb-3"><strong>{{ __('messages.why_choose_us') }}</strong></h2>
            <p>{{ __('messages.why_choose_us_desc') }}</p>
            <p><a href="{{ lroute('about') }}" class="btn btn-primary mt-4 px-4 py-3 text-white">{{ __('messages.read_more') }}</a></p>
          </div>
					<div class="col-md-1"></div>
          <div class="col-md-6 heading-section ftco-animate">
          	<span class="subheading">Testimony</span>
            <h2 class="mb-4 pb-3"><strong>{{ __('messages.guests_says') }}</strong></h2>
          	<div class="row ftco-animate">
		          <div class="col-md-12">
		            <div class="carousel-testimony owl-carousel">
		              <div class="item">
		                <div class="testimony-wrap d-flex">
		                  <div class="user-img mb-5" style="background-image: url('{{ asset('images/user/person_1.webp') }}')">
		                    <span class="quote d-flex align-items-center justify-content-center">
		                      <i class="fa fa-quote-left"></i>
		                    </span>
		                  </div>
		                  <div class="text ml-md-4">
		                    <p class="mb-5">{{ __('messages.guests_says_desc') }}</p>
		                    <p class="name">Dennis Green</p>
		                    <span class="position">Guest from italy</span>
		                  </div>
		                </div>
		              </div>
		              <div class="item">
		                <div class="testimony-wrap d-flex">
		                  <div class="user-img mb-5" style="background-image: url('{{ asset('images/user/person_2.webp') }}')">
		                    <span class="quote d-flex align-items-center justify-content-center">
		                      <i class="fa fa-quote-left"></i>
		                    </span>
		                  </div>
		                  <div class="text ml-md-4">
		                    <p class="mb-5">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
		                    <p class="name">Dennis Green</p>
		                    <span class="position">Guest from London</span>
		                  </div>
		                </div>
		              </div>
		              <div class="item">
		                <div class="testimony-wrap d-flex">
		                  <div class="user-img mb-5" style="background-image: url('{{ asset('images/user/person_3.webp') }}')">
		                    <span class="quote d-flex align-items-center justify-content-center">
		                      <i class="fa fa-quote-left"></i>
		                    </span>
		                  </div>
		                  <div class="text ml-md-4">
		                    <p class="mb-5">{{ __('messages.guests_says_desc') }}</p>
		                    <p class="name">Dennis Green</p>
		                    <span class="position">Guest from Philippines</span>
		                  </div>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>
          </div>
        </div>
      </div>
    </section>
		
		<!-- <section class="ftco-section-parallax">
      <div class="parallax-img d-flex align-items-center">
        <div class="container">
          <div class="row d-flex justify-content-center">
            <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
              <h2>{{ __('messages.subscribe_newsletter') }}</h2>
              <p>{{ __('messages.subscribe_desc') }}</p>
              <div class="row d-flex justify-content-center mt-5">
                <div class="col-md-8">
                  <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                      <input type="text" class="form-control" placeholder="{{ __('messages.enter_email') }}">
                      <input type="submit" value="{{ __('messages.subscribe') }}" class="submit px-3">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->


@endsection
