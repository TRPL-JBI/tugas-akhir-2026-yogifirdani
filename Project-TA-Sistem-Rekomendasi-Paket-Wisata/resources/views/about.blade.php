@extends('template')
@section('content')

    <div class="hero-wrap" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}'); background-size: cover; background-position: center; height: 50vh; min-height: 400px;">
      <div class="overlay"></div>
      <div class="container" style="height: 100%;">
        <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 100%;" data-scrollax-parent="true">
          <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
              <span class="mr-2"><a href="{{ lroute('home') }}">{{ __('messages.home') }}</a></span>
              <span>{{ __('messages.about_page_title') }}</span>
            </p>
            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
              {{ __('messages.about_page_title') }}
            </h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section bg-light">
      <div class="container">
        <div class="row align-items-center">
          <!-- Bagian Gambar -->
          <div class="col-md-6 ftco-animate mb-4 mb-md-0">
            <div class="img about-image" style="background-image: url('{{ asset('images/about.webp') }}'); height: 450px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); background-size: cover; background-position: center;">
            </div>
          </div>

          <!-- Bagian Konten -->
          <div class="col-md-6 ftco-animate pl-md-5">
            <style>
              .about-content h2 {
                font-weight: 700;
                font-size: 32px;
                color: #222;
                margin-bottom: 20px;
                line-height: 1.3;
              }
              .about-content h2 span {
                color: rgb(87, 201, 209);
                display: block;
                font-size: 16px;
                text-transform: uppercase;
                letter-spacing: 2px;
                margin-bottom: 10px;
                font-weight: 600;
              }
              .about-content .lead {
                font-size: 16px;
                color: #666;
                line-height: 1.8;
                margin-bottom: 25px;
              }
              .feature-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
                margin-top: 30px;
              }
              .feature-card {
                background: #fff;
                padding: 15px;
                border-radius: 12px;
                border: 1px solid rgba(0,0,0,0.05);
                transition: all 0.3s ease;
              }
              .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 20px rgba(87, 201, 209, 0.1);
                border-color: rgb(87, 201, 209);
              }
              .feature-card i {
                color: rgb(87, 201, 209);
                font-size: 20px;
                margin-bottom: 10px;
                display: block;
              }
              .feature-card h6 {
                font-weight: 700;
                margin-bottom: 5px;
                font-size: 14px;
              }
              .feature-card p {
                font-size: 12px;
                margin: 0;
                color: #888;
                line-height: 1.4;
              }
            </style>

            <div class="about-content">
              <h2>
                <span>{{ __('messages.about_story_label') }}</span>
                {{ __('messages.about_story_heading') }}
              </h2>
              <p class="lead">{{ __('messages.about_story_desc') }}</p>

              <div class="feature-grid">
                <div class="feature-card">
                  <i class="fa fa-users"></i>
                  <h6>{{ __('messages.about_open_trip') }}</h6>
                  <p>{{ __('messages.about_open_trip_desc') }}</p>
                </div>
                <div class="feature-card">
                  <i class="fa fa-star"></i>
                  <h6>{{ __('messages.about_private_trip') }}</h6>
                  <p>{{ __('messages.about_private_trip_desc') }}</p>
                </div>
                <div class="feature-card">
                  <i class="fa fa-map"></i>
                  <h6>{{ __('messages.about_local_guide') }}</h6>
                  <p>{{ __('messages.about_local_guide_desc') }}</p>
                </div>
                <div class="feature-card">
                  <i class="fa fa-shield"></i>
                  <h6>{{ __('messages.about_safety') }}</h6>
                  <p>{{ __('messages.about_safety_desc') }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}');">
    	<div class="container">
    		<div class="row justify-content-center mb-5 pb-3">
          <div class="col-md-7 text-center heading-section heading-section-white ftco-animate">
            <h2 class="mb-4">{{ __('messages.about_fun_facts_title') }}</h2>
            <span class="subheading">{{ __('messages.about_fun_facts_sub') }}</span>
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

    <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-start">
          <div class="col-md-5 heading-section ftco-animate">
          	<span class="subheading">{{ __('messages.about_best_service') }}</span>
            <h2 class="mb-4 pb-3"><strong>{{ __('messages.about_why_heading') }}</strong></h2>
            <p>{{ __('messages.about_why_desc1') }}</p>
            <p>{{ __('messages.about_why_desc2') }}</p>
            <p>
              <a href="{{ lroute('paket-wisata') }}" class="btn btn-primary mt-4 px-4 py-3 text-white" style="background: rgb(87, 201, 209); border-color: rgb(87, 201, 209); box-shadow: 0 4px 15px rgba(87,201,209,0.3); transition: all 0.3s ease;" onmouseover="this.style.background='rgb(67, 181, 189)'; this.style.borderColor='rgb(67, 181, 189)';" onmouseout="this.style.background='rgb(87, 201, 209)'; this.style.borderColor='rgb(87, 201, 209)';">
                {{ __('messages.about_see_packages') }}
              </a>
            </p>
          </div>
					<div class="col-md-1"></div>
          <div class="col-md-6 heading-section ftco-animate">
          	<span class="subheading">{{ __('messages.about_testimony_label') }}</span>
            <h2 class="mb-4 pb-3"><strong>{{ __('messages.about_testimony_heading') }}</strong></h2>
          	<div class="row ftco-animate">
		          <div class="col-md-12">
		            <div class="carousel-testimony owl-carousel">
		              <div class="item">
		                <div class="testimony-wrap d-flex">
		                  <div class="user-img mb-5" style="background-image: url('{{ asset('images/user/person_1.webp') }}')">
		                    <span class="quote d-flex align-items-center justify-content-center" style="background: rgb(87, 201, 209); color: #fff;">
		                      <i class="fa fa-quote-left"></i>
		                    </span>
		                  </div>
		                  <div class="text ml-md-4">
		                    <p class="mb-5">{{ __('messages.about_review_1') }}</p>
		                    <p class="name">{{ __('messages.about_reviewer_1') }}</p>
		                    <span class="position">{{ __('messages.about_reviewer_1_from') }}</span>
		                  </div>
		                </div>
		              </div>
		              <div class="item">
		                <div class="testimony-wrap d-flex">
		                  <div class="user-img mb-5" style="background-image: url('{{ asset('images/user/person_2.webp') }}')">
		                    <span class="quote d-flex align-items-center justify-content-center" style="background: rgb(87, 201, 209); color: #fff;">
		                      <i class="fa fa-quote-left"></i>
		                    </span>
		                  </div>
		                  <div class="text ml-md-4">
		                    <p class="mb-5">{{ __('messages.about_review_2') }}</p>
		                    <p class="name">{{ __('messages.about_reviewer_2') }}</p>
		                    <span class="position">{{ __('messages.about_reviewer_2_from') }}</span>
		                  </div>
		                </div>
		              </div>
		              <div class="item">
		                <div class="testimony-wrap d-flex">
		                  <div class="user-img mb-5" style="background-image: url('{{ asset('images/user/person_3.webp') }}')">
		                    <span class="quote d-flex align-items-center justify-content-center" style="background: rgb(87, 201, 209); color: #fff;">
		                      <i class="fa fa-quote-left"></i>
		                    </span>
		                  </div>
		                  <div class="text ml-md-4">
		                    <p class="mb-5">{{ __('messages.about_review_3') }}</p>
		                    <p class="name">{{ __('messages.about_reviewer_3') }}</p>
		                    <span class="position">{{ __('messages.about_reviewer_3_from') }}</span>
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

@endsection
