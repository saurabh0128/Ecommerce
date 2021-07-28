@extends('backend.layout.app')
 
@section('title')
    Rating And Review
@endsection

@section('css')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Prism -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/prism/prism.css')}}" type="text/css">

    <!-- Rating -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/rating/rating.min.css')}}" type="text/css">
@endsection

@section('content')
    <!-- content -->
    <div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
            
            <h4>Rating Detail </h4>
            <div class="card">
                <div class="card-body">
                    <table id="RatingDatatable" class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Avrage Rating</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th >Avrage Rating</th>
                            <th>Product Name</th>
                            <th>product image</th>
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

    <!--Rating  Javascript -->
    <script src="{{URL::asset('backend_asset/libs/rating/jquery.rating.min.js')}}"></script>


    <script type="text/javascript" >
        
            var table = $('#RatingDatatable').DataTable({ 

                processing: true,
                serverSide: true,
                ajax:{
                    type:'post',
                    url:'{{ route('admin.rating.ajax')}}',
                    data:{'_token':'{{ csrf_token() }}','mode':'datatable'}
                },
                columns:[
                    {data:'id',name:'DT_RowIndex'},
                    {data:"avrage rating",orderable:false},
                    {data:"product_id"},
                    {data:"product image", orderable: false}
                ],
                "drawCallback":function(settings, json){
                     $(".product_rating").starRating({
                        starShape: 'rounded',
                        readOnly: true
                    });
                }
            });    

            
               
    </script>



@endsection

