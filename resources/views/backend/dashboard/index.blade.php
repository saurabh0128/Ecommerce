@extends('backend.layout.app')

@section('title')
    Admin Dashboard
@endsection


@section('css')
    <!-- Slick -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/slick/slick.css')}}" type="text/css">

  
@endsection





@section('js')


<!-- Apex chart -->
<script src="{{URL::asset('backend_asset/libs/charts/apex/apexcharts.min.js')}}"></script>

<!-- Slick -->
<script src="{{URL::asset('backend_asset/libs/slick/slick.min.js')}}"></script>


<!-- Examples -->
<script src="{{URL::asset('backend_asset/js/examples/dashboard.js')}}"></script>

@endsection