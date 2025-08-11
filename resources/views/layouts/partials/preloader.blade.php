<div class="loader-wrap">
  <div class="preloader">
    <div class="preloader-close"><i class="icon-27"></i></div>
    <div id="handle-preloader" class="handle-preloader">
      <div class="animation-preloader">
        <div class="spinner"></div>
        <div class="txt-loading">
          @foreach (str_split(strtolower($siteName)) as $letter)
            <span data-text-preloader="{{ $letter }}" class="letters-loading">
              {{ $letter }}
            </span>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
