@extends('backend.layout.app')

@section('title')
    Order
@endsection

@section('css')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Prism -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/prism/prism.css')}}" type="text/css">
@endsection

@section('content')
    <!-- content -->
    <div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
            
            <div class="p-3">
                <h4 class="d-inline" >Order Detail</h4>
                <a href="{{route('admin.order.create')}}" >
                        <button class="btn btn-primary btn-icon d-inline float-end"  >
                                <i class="bi bi-plus-circle"></i> Add Product
                        </button>
                </a>
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="datatable-example" class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                        </thead>
                    
                        <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                
            </div>
        </div>
    </div>

    </div>
    <!-- ./ content -->

@endsection

@section('js')

 <!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

    <!-- Examples -->
    <script src="{{URL::asset('backend_asset/js/examples/datatable.js')}}"></script>

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>

@endsection

