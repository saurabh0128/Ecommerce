@extends('backend.layout.app')

@section('title')
    Admin Dashboard
@endsection


@section('css')
    <!-- Slick -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/slick/slick.css')}}" type="text/css">

    <!-- Main style file -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/app.min.css')}}" type="text/css">
@endsection





@section('js')

<!-- Examples -->
<script src="{{URL::asset('backend_asset/js/examples/dashboard.js')}}"></script>

@endsection