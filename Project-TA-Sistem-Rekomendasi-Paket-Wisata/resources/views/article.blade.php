@extends('template')
@section('content')




<!-- Hero Section -->
<div class="hero-wrap" style="background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.1) 60%), url('{{ asset('images/background/jungle-island.webp') }}'); background-size: cover; background-position: center; height: 60vh; min-height: 380px;">
  <div class="overlay"></div>
  <div class="container" style="height: 100%;">
    <div class="row no-gutters slider-text align-items-center justify-content-center" style="height: 100%;" data-scrollax-parent="true">
      <div class="col-md-9 ftco-animate text-center" data-scrollax="properties: { translateY: '70%' }">
        <p class="breadcrumbs" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }">
          <span class="mr-2"><a href="{{ lroute('home') }}">{{ __('messages.home') }}</a></span>
          <span>{{ __('messages.article_page_title') }}</span>
        </p>
        <h1 class="mb-3 bread" data-scrollax="properties: { translateY: '30%', opacity: 1.6 }" style="color: #fff; font-weight: 700;">
          {{ __('messages.article_page_heading') }}
        </h1>
      </div>
    </div>
  </div>
</div>

    <section class="ftco-section" style="background: #f8f9fa; padding-top: 50px; padding-bottom: 80px;">
      <div class="container">


        <div class="row">
          @forelse($articles as $article)
            <div class="col-sm-6 col-md-3 ftco-animate mb-4">
              <div class="d-flex flex-column h-100" style="border-radius: 12px; overflow: hidden; box-shadow: 0 3px 12px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.05); background: #fff; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 12px rgba(0,0,0,0.06)';">

                {{-- Gambar --}}
                <a href="{{ lroute('article.show', $article->slug) }}" style="display: block; overflow: hidden; height: 170px;">
                  <img src="{{ $article->image_url ?? asset('images/no-image.jpg') }}"
                       alt="{{ $article->getTranslation('title') }}"
                       style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
                       onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                       loading="lazy">
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
                      {{ __('messages.article_read_more') }} <i class="fa fa-arrow-right" style="font-size: 11px;"></i>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted">{{ __('messages.article_empty') }}</p>
            </div>
          @endforelse
        </div>

        <!-- Pagination -->
        <div class="row mt-4">
          <div class="col text-center d-flex justify-content-center">
            {{ $articles->links() }}
          </div>
        </div>

      </div>
    </section>

@endsection

