<header class="main-header header-style-four">
  <!-- header-lower -->
  <div class="header-lower">
    <div class="auto-container">
      <div class="outer-box">
        <figure class="logo-box"><a href="{{ url('/') }}">
            @if ($logo)
              <div class="flex items-center gap-3">
                <img src="{{ Storage::url($logo) }}" alt="{{ $siteName }}" class="h-12 w-auto" />
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-[#45A735]">{{ $siteName }}</span>
                  <span class="text-sm text-[#090909]">Kabupaten Kepulauan Aru</span>
                </div>
              </div>
            @else
              <div class="flex items-center">
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-[#45A735]">{{ $siteName }}</span>
                  <span class="text-sm text-[#090909]">Kabupaten Kepulauan Aru</span>
                </div>
            @endif
          </a>
        </figure>
        <div class="menu-area">
          <!--Mobile Navigation Toggler-->
          <div class="mobile-nav-toggler">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
          </div>
          <nav class="main-menu navbar-expand-md navbar-light clearfix">
            <div id="navbarSupportedContent" class="navbar-collapse show clearfix">
              <ul class="navigation clearfix">
                <li class="{{ request()->is('/') ? 'current' : '' }}"><a href="{{ url('/') }}">Beranda</a></li>
                <li class="{{ request()->is('profil') ? 'current' : '' }}"><a href="{{ url('/profil') }}">Profil Desa</a></li>
                {{-- <li class="{{ request()->is('potensi') ? 'current' : '' }}"><a href="{{ url('/potensi') }}">Potensi Desa</a> --}}
                <li class="{{ request()->is('demografi') ? 'current' : '' }}"><a href="{{ url('/demografi') }}">Demografi Desa</a>
                  {{-- <li class="{{ request()->is('berita') ? 'current' : '' }}"><a href="{{ url('/berita') }}">Berita Kegiatan</a> --}}
              </ul>
            </div>
          </nav>
        </div>
        <div class="menu-right-content">
          <div class="search-btn mr_20"><button class="search-toggler"><i class="icon-1"></i></button></div>
          <div class="btn-box"><a href="{{ url('/admin') }}" class="theme-btn btn-one">Masuk</a></div>
        </div>
      </div>
    </div>
  </div>

  <!--sticky Header-->
  <div class="sticky-header">
    <div class="outer-container">
      <div class="outer-box">
        <figure class="logo-box"><a href="{{ url('/') }}">
            @if ($logo)
              <div class="flex items-center gap-3">
                <img src="{{ Storage::url($logo) }}" alt="{{ $siteName }}" class="h-12 w-auto" />
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-[#45A735]">{{ $siteName }}</span>
                  <span class="text-sm text-[#090909]">Kabupaten Kepulauan Aru</span>
                </div>
              </div>
            @else
              <div class="flex items-center">
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-[#45A735]">{{ $siteName }}</span>
                  <span class="text-sm text-[#090909]">Kabupaten Kepulauan Aru</span>
                </div>
            @endif
          </a>
        </figure>
        <div class="menu-area">
          <nav class="main-menu clearfix">
            <!--Keep This Empty / Menu will come through Javascript-->
          </nav>
        </div>
        <div class="menu-right-content">
          <div class="search-btn mr_20"><button class="search-toggler"><i class="icon-1"></i></button></div>
          <div class="btn-box"><a href="{{ url('/admin') }}" class="theme-btn btn-one">Masuk</a></div>
        </div>
      </div>
    </div>
  </div>
</header>
