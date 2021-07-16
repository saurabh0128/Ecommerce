<!doctype html>
<html lang="en">

<!-- Mirrored from vetra.laborasyon.com/demos/default/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jul 2021 07:31:11 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Vetra | E-Commerce HTML Admin Dashboard Template</title>

    <!-- Favicon -->
   <link rel="shortcut icon" href="{{URL::asset('backend_asset/images/favicon.png')}}"/>

    <!-- Themify icons -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/icons/themify-icons/themify-icons.css')}}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/app.min.css')}}" type="text/css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="auth">

<!-- begin::preloader-->
<div class="preloader">
    <div class="preloader-icon"></div>
</div>
<!-- end::preloader -->


    <div class="form-wrapper">
        <div class="container">
            <div class="card">
                <div class="row g-0">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-10 offset-md-1">
                                <div class="d-block " >
                                      <img width="150" src="https://vetra.laborasyon.com/assets/images/logo.svg " class="mx-auto d-block"  alt="logo">
                                </div>
                                <div class="my-5 text-center text-lg-start">
                                    <h1 class="display-8">Sign In</h1>
                                    <p class="text-muted">Sign in to Vetra to continue</p>
                                </div>
                                <form class="mb-5" method="post" action="/admin">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="post">
                                    <div class="mb-3 ">
                                        <input type="text" name="username" class="form-control" placeholder="Enter UserName" autofocus value="{{ old('username') }}">
                                        @error('username')
                                            <div class="text-primary">
                                                {{$message}}
                                            </div> 
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                                        @error('password')
                                            <div class="text-primary">
                                                {{$message}}
                                            </div> 
                                        @enderror
                                    </div>
                                    <div class="text-center text-lg-start">
                                        <p class="small">Can't access your account? <a href="#">Reset your password now</a>.</p>
                                        <button type="submit" class="btn btn-primary">Sign In</button>
                                    </div>
                                </form>
                                <p class="text-center d-block d-lg-none mt-5 mt-lg-0">
                                    Don't have an account? <a href="#">Sign up</a>.
                                </p>
                                <ul class="list-inline">
                                    <li class="list-inline-item">
                                        <a href="#">Privacy Policy</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="#">Terms & Conditions</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>


<!-- Bundle scripts -->
<script src="{{URL::asset('backend_asset/js/bundle.js')}}"></script>

<!-- Main Javascript file -->
<script src="{{URL::asset('backend_asset/js/app.min.js')}}"></script>
</body>

<!-- Mirrored from vetra.laborasyon.com/demos/default/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jul 2021 07:31:11 GMT -->
</html>
