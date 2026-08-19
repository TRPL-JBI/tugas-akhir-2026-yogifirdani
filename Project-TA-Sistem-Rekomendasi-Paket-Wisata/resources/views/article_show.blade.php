@extends('template')
@section('content')

<style>
    /* Paksa semua menu navbar menjadi tebal di halaman ini (baik saat scroll maupun tidak) */
    #ftco-navbar .nav-link,
    #ftco-navbar .dropdown-item,
    #ftco-navbar .cta .nav-link span {
        font-weight: 700 !important;
    }

    /* Ubah warna teks navbar menjadi hitam di halaman detail (sebelum di-scroll) agar terlihat di background putih */
    #ftco-navbar:not(.scrolled) .nav-link,
    #ftco-navbar:not(.scrolled) .dropdown-item {
        color: #222222 !important;
    }
    /* Warna saat menu aktif atau di-hover menjadi warna brand (baik scroll maupun tidak) */
    #ftco-navbar .nav-item.active .nav-link,
    #ftco-navbar .nav-link:hover {
        color: rgb(87, 201, 209) !important;
    }
    /* Ikon panah bawah (dropdown) */
    #ftco-navbar .nav-link i {
        color: inherit !important;
    }
    /* Tombol Sign Up (garis tepi) */
    #ftco-navbar:not(.scrolled) .cta .nav-link span {
        color: #222222 !important;
        border: 1px solid rgb(87, 201, 209) !important;
    }
    /* Efek hover Sign Up (Register) agar rapi */
    #ftco-navbar:not(.scrolled) .cta .nav-link:hover {
        background: transparent !important;
    }
    #ftco-navbar:not(.scrolled) .cta .nav-link span {
        transition: all 0.3s ease;
    }
    #ftco-navbar:not(.scrolled) .cta .nav-link:hover span {
        background: #70d4de !important;
        border-color: #70d4de !important;
        color: #fff !important;
    }
    /* Ikon Menu (hamburger di mobile) */
    #ftco-navbar:not(.scrolled) .navbar-toggler {
        color: #222222 !important;
    }
</style>

    <!-- Spacer untuk Navbar agar tidak menutupi konten -->
    <div style="height: 100px;"></div>

    <section class="ftco-section ftco-degree-bg pt-0">
      <div class="container">
        <div class="row">      
          <div class="col-md-8 ftco-animate">
            <!-- 1. Gambar Utama (Full Width) -->
            @if($article->image)
                <div class="mb-4">
                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="img-fluid rounded-lg shadow-sm w-100" style="max-height: 600px; object-fit: cover;">
                </div>
            @endif
            
            <!-- 2. Social Share -->
            <!-- <div class="share-post mb-4 d-flex align-items-center" style="font-size: 14px; color: #666;">
                <span class="mr-3">Share the Post :</span>
                <a href="#" class="mr-2 text-success"><i class="fa fa-whatsapp fa-lg"></i></a>
                <a href="#" class="mr-2 text-info"><i class="fa fa-twitter fa-lg"></i></a>
                <a href="#" class="mr-2 text-dark"><i class="fa fa-instagram fa-lg"></i></a>
            </div> -->

            <!-- Breadcrumbs -->
            <div class="mb-4">
                <p class="breadcrumbs mb-2" style="font-size: 14px;">
                    <span class="mr-2"><a href="{{ lroute('home') }}" style="color: #666; font-weight: 500;">{{ __('messages.home') }}</a> <span style="color: #ccc; margin: 0 5px;">/</span></span> 
                    <span class="mr-2"><a href="{{ lroute('article') }}" style="color: #666; font-weight: 500;">{{ __('messages.article') }}</a> <span style="color: #ccc; margin: 0 5px;">/</span></span>
                    <span style="color: rgb(87, 201, 209); font-weight: 600;">{{ $article->getTranslation('title') }}</span>
                </p>
            </div>

            <!-- 3. Judul Artikel -->
            <h2 class="mb-3 font-weight-bold" style="color: #333; line-height: 1.4; font-size: 28px;">{{ $article->getTranslation('title') }}</h2>
            
            <div class="meta mb-4 pb-3 border-bottom">
                <span class="mr-3 text-muted"><i class="fa fa-calendar mr-2"></i>{{ $article->created_at->format('d M Y') }}</span>
                <span class="text-muted"><i class="fa fa-user mr-2"></i>{{ $article->author->name ?? 'Admin' }}</span>
            </div>
            
            <!-- 5. Konten Artikel -->
            <div class="article-content" style="line-height: 1.8; color: #444; font-size: 17px;">
                {!! $article->getTranslation('content') !!}
            </div>

            <div class="tag-widget post-tag-container mb-5 mt-5">
              <div class="tagcloud">
                <a href="#" class="tag-cloud-link">Travel</a>
                <a href="#" class="tag-cloud-link">Tips</a>
                <a href="#" class="tag-cloud-link">Banyuwangi</a>
              </div>
            </div>
            
            <div class="about-author d-flex p-4 bg-light rounded-lg">
              <div class="bio mr-5">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($article->author->name ?? 'Admin') }}&color=7F9CF5&background=EBF4FF" alt="Author" class="img-fluid mb-4 rounded-circle" style="width: 100px; height: 100px; object-fit: cover;" loading="lazy" width="100" height="100">
              </div>
              <div class="desc">
                <h3>{{ $article->author->name ?? 'Admin' }}</h3>
                <p>Penulis di Kutamasya.id yang senang berbagi cerita perjalanan dan tips wisata untuk membantu Anda merencanakan liburan impian.</p>
              </div>
            </div>

          </div> <!-- .col-md-8 -->
          
          <div class="col-md-4 sidebar ftco-animate">
            <!-- <div class="sidebar-box">
              <form action="#" class="search-form">
                <div class="form-group">
                  <span class="icon fa fa-search"></span>
                  <input type="text" class="form-control" placeholder="Cari artikel...">
                </div>
              </form>
            </div> -->

            <div class="sidebar-box ftco-animate">
              <h3>Artikel Lainnya</h3>
              @foreach($relatedArticles as $rel)
              <div class="block-21 mb-4 d-flex">
                <a class="blog-img mr-4" style="background-image: url('{{ $rel->image_url ?? asset('images/no-image.jpg') }}'); border-radius: 5px;"></a>
                <div class="text">
                  <h3 class="heading"><a href="{{ lroute('article.show', $rel->slug) }}">{{ $rel->getTranslation('title') }}</a></h3>
                  <div class="meta">
                    <div><a href="#"><span class="icon-calendar"></span> {{ $rel->created_at->format('M d, Y') }}</a></div>
                    <div><a href="#"><span class="icon-person"></span> {{ $rel->author->name ?? 'Admin' }}</a></div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

            <!-- <div class="sidebar-box ftco-animate">
              <h3>Tag Cloud</h3>
              <div class="tagcloud">
                <a href="#" class="tag-cloud-link">Wisata</a>
                <a href="#" class="tag-cloud-link">Kuliner</a>
                <a href="#" class="tag-cloud-link">Budaya</a>
                <a href="#" class="tag-cloud-link">Alam</a>
                <a href="#" class="tag-cloud-link">Pantai</a>
                <a href="#" class="tag-cloud-link">Gunung</a>
              </div>
            </div> -->
          </div>

        </div>
      </div>
    </section> <!-- .section -->

@endsection

@push('styles')
<style>
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        margin: 20px 0;
    }
    .article-content blockquote {
        border-left: 5px solid rgb(87, 201, 209);
        padding-left: 20px;
        font-style: italic;
        background: #f9f9f9;
        padding: 20px;
    }
</style>
@endpush
