<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="application-name" content="{{ $siteName }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title> {{ isset($title) ? $title . ' - ' : '' }}{{ $siteName }}</title>

<!-- Favicon from settings -->
<link rel="shortcut icon" href="{{ $favicon ? Storage::url($favicon) : asset('assets/images/favicon.ico') }}" type="image/x-icon">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
<!-- Icon Font -->
<link rel="stylesheet" href="{{ asset('assets/fonts/iconfonts/font-awesome/stylesheet.css') }}">

<!-- Vite & Livewire Stylesheets -->
@vite(['resources/css/app.css'])
@livewireStyles
<!-- Stack Stylesheets -->
@stack('styles')

<!-- Stylesheets -->
<link href="{{ asset('assets/css/font-awesome-all.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/flaticon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/owl.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/jquery.fancybox.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/nice-select.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/odometer.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/elpath.css') }}" rel="stylesheet">
<link id="jssDefault" href="{{ asset('assets/css/color.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/rtl.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/header.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/footer.css') }}" rel="stylesheet">
<?php echo isset($css) ? $css : ''; ?>
<link href="{{ asset('assets/css/module-css/banner.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/clients.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/about.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/chooseus.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/industries.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/process.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/service.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/funfact.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/faq.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/job.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/testimonial.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/news.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/team.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/download.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/subscribe.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/service-details.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/module-css/page-title.css') }}" rel="stylesheet">

<link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
