@extends('backend.layout.app')

@section('title')
    City 
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
            
            <h4>City Detail</h4>

            <div class="card">
                <div class="card-body">
                    <table id="cityDatatable" class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>city Name</th>
                            <th>State Name</th>
                        </tr>
                        </thead>
                       
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>city Name</th>
                            <th>State Name</th>
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

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>

    <script type="text/javascript">
                var table = $('#cityDatatable').DataTable({ 
                    processing: true,
                    serverSide: true,
                    ajax:{
                        type:'post',
                        url:'{{ route('admin.city.ajax')}}',
                        data:{'_token':'{{ csrf_token() }}','mode':'datatable'}
                    },
                    columns:[
                        {data:'id',name:'DT_RowIndex'},
                        {data:"city name"},
                        {data:"state name"}
                    ]
                });
    </script>   

@endsection

