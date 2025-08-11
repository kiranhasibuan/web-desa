<?php

use Livewire\Volt\Component;
use App\Models\Banner;

new class extends Component {
    public function with()
    {
        return [
            'banners' => Banner::aktif()->urutan()->with('media')->get(),
        ];
    }
}; ?>

<section class="banner-style-four p_relative">
  <div class="banner-carousel owl-theme owl-carousel owl-nav-none dots-style-one">
    @forelse($banners as $banner)
      <div class="slide-item p_relative" wire:key="banner-{{ $banner->id }}">
        <div class="bg-layer"
             style="background-image: url('{{ $banner->getBannerImageUrl('large') ?: asset('assets/images/banner/default-banner.jpg') }}')">
        </div>
        <div class="shape-box">
          <div class="shape-1"></div>
          <div class="shape-2"></div>
        </div>
        <div class="auto-container">
          <div class="content-box">
            @if ($banner->kategori)
              <span class="upper-text">{{ $banner->kategori }}</span>
            @endif
            @if ($banner->deskripsi)
              <div class="banner-content">
                {!! $banner->deskripsi !!}
              </div>
            @else
              <h2>{{ $banner->judul }}</h2>
            @endif

            <div class="btn-box">
              <a href="{{ url('/layanan') }}" class="theme-btn banner-btn mr_20">Layanan Kami</a>
              <!-- Perbaikan: Konsistensi URL -->
              <a href="{{ url('/profil-desa') }}" class="theme-btn banner-btn-two"><span>Profil Desa</span></a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <!-- Default banner jika tidak ada data -->
      <div class="slide-item p_relative">
        <div class="bg-layer" style="background-image: url('{{ asset('assets/images/banner/default-banner.jpg') }}')"></div>
        <div class="shape-box">
          <div class="shape-1"></div>
          <div class="shape-2"></div>
        </div>
        <div class="auto-container">
          <div class="content-box">
            <span class="upper-text">Selamat Datang</span>
            <h2>Website Resmi Desa <span>{{ $namaDesa }}</span></h2>
            <p>Sumber Informasi terbaru tentang pemerintahan di Desa {{ $namaDesa }}</p>
            <div class="btn-box">
              <a href="{{ url('/layanan') }}" class="theme-btn banner-btn mr_20">Layanan Kami</a>
              <!-- Perbaikan: Konsistensi URL -->
              <a href="{{ url('/profil-desa') }}" class="theme-btn banner-btn-two"><span>Profil Desa</span></a>
            </div>
          </div>
        </div>
      </div>
    @endforelse
  </div>
</section>
