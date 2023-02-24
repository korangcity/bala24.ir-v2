<!doctype html>
<html lang="en" dir="rtl" data-layout="vertical" data-layout-style="detached" data-sidebar="light" data-topbar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="@yield("description")">
    <meta name="keywords" content="@yield("keywords")">
    <meta property="og:title" content="@yield("ogTitle")">
    <meta property="og:description" content="@yield("ogDescription")">
    <meta property="og:type" content="@yield("ogType")">
    <meta property="og:image" content="@yield("ogImage")">

    <link rel="apple-touch-icon" sizes="180x180" href="{{baseUrl(httpCheck())}}apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{baseUrl(httpCheck())}}favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{baseUrl(httpCheck())}}favicon-16x16.png">
    <link rel="manifest" href="{{baseUrl(httpCheck())}}site.webmanifest">
    <link rel="mask-icon" href="{{baseUrl(httpCheck())}}safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">


    <link href="{{baseUrl(httpCheck())}}home/assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

    <script src="{{baseUrl(httpCheck())}}home/assets/js/layout.js"></script>

    <link href="{{baseUrl(httpCheck())}}home/assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" />

    <link href="{{baseUrl(httpCheck())}}home/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="{{baseUrl(httpCheck())}}home/assets/css/app-rtl.min.css" rel="stylesheet" type="text/css" />

    <link href="{{baseUrl(httpCheck())}}home/assets/css/layoutCustom.css" rel="stylesheet" type="text/css" />

@yield('head')
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">


<div class="layout-wrapper landing">

    @include("home.fa.landing_layout.header")
    @yield("content")

    @include("home.fa.landing_layout.footer")


    <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

</div>

<script src="{{baseUrl(httpCheck())}}home/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/node-waves/waves.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/libs/feather-icons/feather.min.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="{{baseUrl(httpCheck())}}home/assets/js/plugins.js"></script>


<script src="{{baseUrl(httpCheck())}}home/assets/libs/swiper/swiper-bundle.min.js"></script>


<script src="{{baseUrl(httpCheck())}}home/assets/js/pages/landing.init.js"></script>

@yield('script')
</body>

</html>


@php die; @endphp