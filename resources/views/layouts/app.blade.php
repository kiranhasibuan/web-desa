@props(['title', 'namaDesa', 'namaKabupaten'])
@php
  $favicon = $siteSettings->logo;
  $siteName = $siteSettings->name ?? config('app.name', 'Website Desa');
  $logo = $siteSettings->logo ?? null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr" class="scroll-smooth">

  <head>
    @include('layouts.partials.head')
  </head>

  <body>
    <div class="boxed_wrapper ltr">
      {{-- Preloader --}}
      @include('layouts.partials.preloader')

      {{-- Page Direction --}}
      @include('layouts.partials.pageDirection')

      {{-- Search Popup --}}
      @include('layouts.partials.searchPopup')

      {{-- Main Header --}}
      @include('layouts.partials.header')

      {{-- Mobile Menu --}}
      @include('layouts.partials.mobileMenu')

      {{-- <main> --}}
      {{ $slot }}
      {{-- </main> --}}

      {{-- Footer --}}
      @if (!isset($footer))
        @include('layouts.partials.footer')
      @endif

      {{-- Scroll to Top --}}
      @include('layouts.partials.scroll')
    </div>

    @include('layouts.partials.scripts')
  </body>

</html>
