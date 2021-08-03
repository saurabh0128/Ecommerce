@extends('backend.layout.app')

@section('title')
Page
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
                <h4 class="d-inline" >Page Detail</h4>
                @can('Add Pages')
                <a href="{{route('admin.page.create')}}" >
                    <button class="btn btn-primary btn-icon d-inline float-end"  >
                            <i class="bi bi-plus-circle"></i> Add Page
                    </button>
                </a>
                @endcan
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="PageDatatable" class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Page Name</th>
                            <th>Page Text</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                   
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Page Name</th>
                            <th>Page Text</th>
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




    <script type="text/javascript" charset="utf-8" async defer>

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


        $('#PageDatatable').DataTable({ 
                processing: true,
                serverSide: true,
                ajax:{
                    type:'post',
                    url:'{{ route('admin.page.ajax')}}',
                    data:{'_token':'{{ csrf_token() }}','data':'datatable'}
                },
                columns:[
                    {data:'id',name:'DT_RowIndex'},
                    {data:"page_name"},
                    {data:"page_status"},
                    {
                        data:'action',
                        name:'action',
                        searchable:false,
                        orderable:false
                    }
                ]
            });

        @if(Session::get('success'))      
            toastr["success"]("{{Session::get('success')}}")
        @endif

    </script>

@endsection