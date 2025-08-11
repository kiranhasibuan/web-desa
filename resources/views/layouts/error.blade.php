<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Favicon from settings -->
    <link rel="shortcut icon"
          href="{{ $generalSettings->site_favicon ? Storage::url($generalSettings->site_favicon) : asset('assets/images/favicon.ico') }}"
          type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap"
          rel="stylesheet">
    <!-- Stylesheets -->
    <link href="{{ asset('assets/css/elpath.css') }}" rel="stylesheet">
    <link id="jssDefault" href="{{ asset('assets/css/color.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/module-css/error.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/css/module-css/subscribe.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/css/module-css/footer.css') }}" rel="stylesheet"> --}}
    <!-- Vite & Livewire Stylesheets -->
    @vite(['resources/css/app.css'])
    @livewireStyles
    <!-- Stack Stylesheets -->
    @stack('styles')
  </head>

  <body>
    <div class="boxed_wrapper ltr">
      <main>
        {{ $slot }}
      </main>
    </div>

    @vite(['resources/js/app.js'])
    @livewireScripts
  </body>

</html>
