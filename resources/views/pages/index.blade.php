<x-app-layout :title="'Beranda'">
  <div>
    <!-- banner-section -->
    <livewire:banner />
    <!-- banner-section end -->
    <!-- sambutan-section -->
    <livewire:sambutan />
    <!-- sambutan-section end -->

    <section class="industries-style-four py-10">
      <div class="auto-container">
        <div class="sec-title centred pb_60 sec-title-animation animation-style2">
          <span class="sub-title mb_10 title-animation">Statistik</span>
          <h2 class="title-animation">Statistik Penduduk</h2>
        </div>
        <div class="row clearfix">
          <div class="industries-block">
            <livewire:demografi.stat-card />
          </div>
          <div class="more-btn centred">
            <a href="{{ url('/demografi') }}" class="theme-btn btn-one">Lihat Demografi Desa</a>
          </div>
        </div>
      </div>
    </section>
  </div>
</x-app-layout>
