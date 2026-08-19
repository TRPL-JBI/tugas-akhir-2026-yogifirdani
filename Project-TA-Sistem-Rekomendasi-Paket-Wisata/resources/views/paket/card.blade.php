@props(['package' => null])

<div class="destination d-flex flex-column h-100" style="border-radius: 12px; overflow: hidden; box-shadow: 0 3px 12px rgba(0,0,0,0.06); border: 1px solid rgba(0,0,0,0.05); background: #fff; transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 12px rgba(0,0,0,0.06)';">
    
    {{-- Gambar --}}
    <a href="{{ isset($package) && $package->slug ? lroute('paket-wisata.show', $package->slug) : '#' }}" style="display: block; overflow: hidden; height: 170px;">
        <img src="{{ isset($package) && $package->image_url ? $package->image_url : asset('images/background/jungle-island.webp') }}" 
             alt="{{ isset($package) ? $package->getTranslation('package_name') : 'Tour Package' }}" 
             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease;"
             onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
             loading="lazy" width="300" height="170">
    </a>

    {{-- Konten --}}
    <div class="p-3 d-flex flex-column flex-grow-1">
        
        {{-- Nama & Harga --}}
        <div class="d-flex justify-content-between align-items-start mb-1">
            <h3 style="font-size: 14px; line-height: 1.3; font-weight: 700; margin-bottom: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; width: calc(100% - 85px);">
                <a href="{{ isset($package) && $package->slug ? lroute('paket-wisata.show', $package->slug) : '#' }}" style="color: #222; text-decoration: none;">{{ isset($package) ? $package->getTranslation('package_name') : 'Tour Package' }}</a>
            </h3>
            <span style="font-size: 13px; font-weight: 700; color: #000; white-space: nowrap; padding-top: 2px;">Rp {{ number_format($package->price_1pax ?? 0, 0, ',', '.') }}</span>
        </div>

        {{-- Deskripsi --}}
        <p style="font-size: 12px; color: #777; line-height: 1.5; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">{{ Str::limit(strip_tags(isset($package) ? $package->getTranslation('description') : ''), 80) }}</p>

        {{-- Footer Card --}}
        <div class="mt-auto" style="border-top: 1px solid #f0f0f0; padding-top: 6px;">
            <div class="d-flex align-items-center justify-content-between">
                <div style="font-size: 12px; color: #666;">
                    <div><i class="fa fa-clock-o mr-1" style="color: rgb(87, 201, 209);"></i>{{ isset($package) ? ($package->getTranslation('duration') ?? '1 Day') : '1 Day' }}</div>
                    <div class="mt-1"><i class="fa fa-map-marker mr-1" style="color: rgb(87, 201, 209);"></i>{{ isset($package) ? ($package->city ?? 'Location') : 'Location' }}</div>
                </div>
                <a href="{{ isset($package) && $package->slug ? lroute('paket-wisata.show', $package->slug) : '#' }}" 
                   style="background: rgb(87, 201, 209); color: #fff; border-radius: 20px; padding: 4px 12px; font-size: 11px; font-weight: 600; text-decoration: none; box-shadow: 0 2px 8px rgba(87,201,209,0.3); white-space: nowrap;">
                    Detail
                </a>
            </div>
        </div>

    </div>
</div>
