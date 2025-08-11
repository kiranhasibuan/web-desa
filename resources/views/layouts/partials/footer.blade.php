<footer class="main-footer home-2">
  <div class="widget-section p_relative pt_50 pb_50">
    <div class="auto-container">
      <div class="row clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 footer-column">
          <div class="footer-widget logo-widget mr_30">
            <figure class="logo-box mb-2"><a href="{{ url('/') }}">
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

            <p>{{ $siteSettings->company_address }}</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 footer-column">
          <div class="footer-widget links-widget">
            <div class="widget-title">
              <h4>Hubungi Kami</h4>
            </div>
            <div class="widget-content">
              <ul class="links-list clearfix">
                <a class="mb-2 inline-flex items-center gap-2 rounded-full border-2 border-[#45a735] px-3 py-2 font-medium text-[#45a735] transition-colors duration-200 hover:bg-[#45a735] hover:text-white"
                   href="https://wa.me/{{ $siteSettings->company_phone }}">
                  <i class="fa fa-phone-alt"></i>
                  {{ $siteSettings->company_phone }}
                </a>

                <a class="mb-2 inline-flex items-center gap-2 rounded-full border-2 border-[#45a735] px-3 py-2 font-medium text-[#45a735] transition-colors duration-200 hover:bg-[#45a735] hover:text-white"
                   href="{{ $siteSettings->company_email }}">
                  <i class="fa fa-envelope"></i>
                  {{ $siteSettings->company_email }}
                </a>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-12 footer-column">
          <div class="footer-widget links-widget">
            <div class="widget-title">
              <h4>Jelajahi</h4>
            </div>
            <div class="widget-content">
              <ul class="links-list clearfix">
                <li><a href="{{ url('https://bakukele.site/') }}">Website Bakukele</a></li>
                <li><a href="{{ url('https://kepulauanarukab.go.id/') }}">Website Kepulauan Aru</a></li>
                <li><a href="{{ url('https://portal.kepulauanarukab.go.id/') }}">Portal Kepulauan Aru</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="auto-container">
      <div class="bottom-inner">
        <div class="copyright">
          <p>Copyright &copy; 2025 <a href="{{ url('/') }}">BPS 8105</a> All rights reserved.</p>
        </div>
        <ul class="social-links">
          @php
            $socialLinks = [
                'facebook' => $siteSocialSettings->facebook_url ?? null,
                'twitter' => $siteSocialSettings->twitter_url ?? null,
                'instagram' => $siteSocialSettings->instagram_url ?? null,
                'linkedin' => $siteSocialSettings->linkedin_url ?? null,
                'youtube' => $siteSocialSettings->youtube_url ?? null,
                'tiktok' => $siteSocialSettings->tiktok_url ?? null,
            ];

            $faIcons = [
                'twitter' => 'fa-brands fa-x-twitter',
                'facebook' => 'fa-brands fa-facebook-f',
                'instagram' => 'fa-brands fa-instagram',
                'linkedin' => 'fa-brands fa-linkedin-in',
                'youtube' => 'fa-brands fa-youtube',
                'tiktok' => 'fa-brands fa-tiktok',
            ];
          @endphp
          <li>
            <h5>Ikuti Kami di:</h5>
          </li>
          @foreach ($socialLinks as $platform => $url)
            @if (!empty($url))
              <li><a href="{{ $url }}">
                  <i class="{{ $faIcons[$platform] ?? 'fa-brands fa-' . $platform }}"></i>
                </a></li>
            @endif
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</footer>
