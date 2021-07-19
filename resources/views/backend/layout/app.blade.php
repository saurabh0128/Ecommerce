<!doctype html>
<html lang="en">

<!-- Mirrored from vetra.laborasyon.com/demos/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jul 2021 07:30:43 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> @yield('title')  </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{URL::asset('backend_asset/images/favicon.png')}}"/>

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&amp;display=swap" rel="stylesheet">

    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/icons/bootstrap-icons-1.4.0/bootstrap-icons.min.css')}}" type="text/css">

    <!-- Bootstrap Docs -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/bootstrap-docs.css')}}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/app.min.css')}}" type="text/css">

    @yield('css')



    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- preloader -->
<div class="preloader">
    <img src="https://vetra.laborasyon.com/assets/images/logo.svg" alt="logo">
    <div class="preloader-icon"></div>
</div>
<!-- ./ preloader -->

<!-- sidebars -->

@include('backend.layout.notification')

@include('backend.layout.setting_sidebar')

@include('backend.layout.search_sidebar')

<!-- ./ sidebars -->

@include('backend.layout.menu')

<!-- layout-wrapper -->
<div class="layout-wrapper">

@include('backend.layout.header')

    @yield('content')

   @include('backend.layout.footer')

</div>
<!-- ./ layout-wrapper -->




<!-- Bundle scripts -->
<script src="{{URL::asset('backend_asset/libs/bundle.js')}}"></script>


<!-- Main Javascript file -->
<script src="{{URL::asset('backend_asset/js/app.min.js')}}"></script>

@yield('js')
</body>

<!-- Mirrored from vetra.laborasyon.com/demos/default/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jul 2021 07:31:10 GMT -->
</html>
