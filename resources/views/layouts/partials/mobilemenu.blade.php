<div class="mobile-menu">
  <div class="menu-backdrop"></div>
  <div class="close-btn"><i class="fas fa-times"></i></div>
  <nav class="menu-box">
    <div class="nav-logo">
      <a href="{{ url('/') }}">
        <figure class="logo-box"><a href="{{ url('/') }}">
            @if ($logo)
              <div class="flex items-center gap-3">
                <img src="{{ Storage::url($logo) }}" alt="{{ $siteName }}" class="h-12 w-auto" />
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-[#45A735]">{{ $siteName }}</span>
                  <span class="text-sm text-white">Kabupaten Kepulauan Aru</span>
                </div>
              </div>
            @else
              <div class="flex items-center">
                <div class="flex flex-col">
                  <span class="text-xl font-bold text-[#45A735]">{{ $siteName }}</span>
                  <span class="text-sm text-white">Kabupaten Kepulauan Aru</span>
                </div>
            @endif
          </a>
        </figure>
      </a>
    </div>
    <div class="menu-outer"></div>
    {{-- <div class="contact-info">
      <h4>Contact Info</h4>
      <ul>
        <li>Chicago 12, Melborne City, USA</li>
        <li><a href="tel:+8801682648101">+88 01682648101</a></li>
        <li><a href="mailto:info@example.com">info@example.com</a></li>
      </ul>
    </div>
    <div class="social-links">
      <ul class="clearfix">
        <li><a href="{{ url('/') }}"><span class="fab fa-twitter"></span></a></li>
        <li><a href="{{ url('/') }}"><span class="fab fa-facebook-square"></span></a></li>
        <li><a href="{{ url('/') }}"><span class="fab fa-pinterest-p"></span></a></li>
        <li><a href="{{ url('/') }}"><span class="fab fa-instagram"></span></a></li>
        <li><a href="{{ url('/') }}"><span class="fab fa-youtube"></span></a></li>
      </ul>
    </div> --}}
  </nav>
</div>
