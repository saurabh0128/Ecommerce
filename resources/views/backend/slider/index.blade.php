@extends('backend.layout.app')

@section('title')
	Slider
@endsection

@section('css')
	<!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Prism -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/prism/prism.css')}}" type="text/css">

    <!-- toaster css -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/toastr.css')}}" type="text/css">
@endsection

@section('content')

<!-- content -->
<div class="content ">        
    <div class="row">
        <div class="col-lg-12 bd-content">
            
            <div class="p-3">
                <h4 class="d-inline" >Slider Detail</h4>
                @can('Add Slider')
                <a href="{{route('admin.slide.create')}}" >
                    <button class="btn btn-primary btn-icon d-inline float-end"  >
                            <i class="bi bi-plus-circle"></i> Add slider
                    </button>
                </a>
                @endcan
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="SlideDatatable" class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Slide Image</th>
                            <th>Slide Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                   
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Slide Image</th>
                            <th>Slide Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
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

    <!-- toaster js -->
    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

    <script type="text/javascript">
    	 toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        @if(Session::get('success'))      
            toastr["success"]("{{Session::get('success')}}")
        @endif


         	$('#SlideDatatable').DataTable({ 
                processing: true,
                serverSide: true,
                ajax:{
                    type:'post',
                    url:'{{ route('admin.slide.ajax')}}',
                    data:{'_token':'{{ csrf_token() }}','data':'datatable'}
                },
                columns:[
                    {data:'id',name:'DT_RowIndex'},
                    {data:"slide_image"},
                    {data:"slide_status"},
                    {data:'start_date'},
                    {data:'end_date'},
                    {
                        data:'action',
                        name:'action',
                        searchable:false,
                        orderable:false
                    }
                ]
            });

         	function DeleteFunc(id){
             //For remove a progressbar and set a closebutton
            toastr.options = {
                "progressBar":false,
                "closeButton":true,
            }

            toastr["info"]("Are you sure you want to delete record?<br /><br /><button id='cnf_del_btn'  type='button' class='btn btn-light btn-sm'>Yes</button>");

            $('#cnf_del_btn').click(function(){
                $.ajax({
                    type:'post',
                    url:"{{route('admin.slide.destroy','')}}"+'/'+id,
                    data:{'_token':'{{ csrf_token() }}','_method':'delete'},
                    success:function (response){
                        if(response.error){
                            toastr["error"](response.error);
                        }
                        else{
                            toastr["success"]("Record Deleted Successfully");
                            $('#SlideDatatable').DataTable().draw(false);
                        } 
                    }
                });
            });
        }


    </script>

@endsection