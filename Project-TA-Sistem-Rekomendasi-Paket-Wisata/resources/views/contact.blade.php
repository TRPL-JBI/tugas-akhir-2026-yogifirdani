@extends('template')
@section('content')

    <div class="hero-wrap" style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 25%), url('{{ asset('images/background/jungle-island.webp') }}'); background-size: cover; background-position: center; height: 50vh; min-height: 400px;">
      <div class="overlay"></div>
      <div class="container" style="height: 100%;">
        <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 100%;" data-scrollax-parent="true">
          <div class="col-md-9 ftco-animate text-center" data-scrollax=" properties: { translateY: '70%' }">
            <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
              <span class="mr-2"><a href="{{ lroute('home') }}">{{ __('messages.home') }}</a></span>
              <span>{{ __('messages.contact_page_title') }}</span>
            </p>
            <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
              {{ __('messages.contact_page_heading') }}
            </h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section contact-section ftco-degree-bg">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
          <div class="col-md-12 mb-4">
            <h2 class="h4">{{ __('messages.contact_info_title') }}</h2>
          </div>
          <div class="w-100"></div>
          <div class="col-sm-6 col-md-3 mb-4">
            <p><span>{{ __('messages.contact_address_label') }}:</span> Jl. Watukebo, Kecamatan Blimbingsari, Kabupaten Banyuwangi, Jawa Timur 68460</p>
          </div>
          <div class="col-sm-6 col-md-3 mb-4">
            <p><span>{{ __('messages.contact_phone_label') }}:</span> <a href="tel://1234567920">+62-823-4399-1298</a></p>
          </div>
          <div class="col-sm-6 col-md-3 mb-4">
            <p><span>{{ __('messages.contact_email_label') }}:</span> <a href="mailto:kutamasya@gmail.com">kutamasya@gmail.com</a></p>
          </div>
          <div class="col-sm-6 col-md-3 mb-4">
            <p><span>{{ __('messages.contact_website_label') }}:</span> <a href="#">kutamasya.id</a></p>
          </div>
        </div>

        <div class="row block-9">
          <div class="col-md-6 pr-md-5 mb-5 mb-md-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 6px; font-size: 14px; background: rgb(87, 201, 209); color: #fff; border: none;">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: #fff; opacity: 1;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" method="POST">
              @csrf
              <div class="form-group">
                <input type="text" name="name" class="form-control" placeholder="{{ __('messages.contact_name_ph') }}" required>
              </div>
              <div class="form-group">
                <input type="email" name="email" class="form-control" placeholder="{{ __('messages.contact_email_ph') }}" required>
              </div>
              <div class="form-group">
                <input type="text" name="subject" class="form-control" placeholder="{{ __('messages.contact_subject_ph') }}">
              </div>
              <div class="form-group">
                <textarea name="message" id="message" cols="30" rows="7" class="form-control"
                          placeholder="{{ __('messages.contact_message_ph') }}" required></textarea>
              </div>
              <div class="form-group">
                <input type="submit" value="{{ __('messages.contact_send_btn') }}" class="btn btn-primary py-3 px-5 text-white">
              </div>
            </form>
          </div>

          <div class="col-md-6" id="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.3450361291216!2d114.31618591058941!3d-8.324283391676994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd1574420decb7b%3A0xaaf6f646a627d003!2sJl.%20Raya%20Watukebo%2C%20Watukebo%2C%20Kec.%20Rogojampi%2C%20Kabupaten%20Banyuwangi%2C%20Jawa%20Timur%2068462!5e1!3m2!1sen!2sid!4v1779954071391!5m2!1sen!2sid"
                    width="100%" height="100%"
                    style="border:0; min-height:400px; border-radius: 5px;"
                    allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </section>

@endsection
