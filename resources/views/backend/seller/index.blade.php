@extends('backend.layout.app')

@section('title')
	Seller
@endsection

@section('css')
	<!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">
    
    <!-- Toastr -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/toastr.css')}}" type="text/css">
@endsection

@section('content')
    <!-- content -->
    <div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
        	<div class="p-3">    
                <h4 class="d-inline" >Seller Details</h4>
                @can('Add Sellers')
                <a href="{{route('admin.seller.create')}}">
                <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#AddUser" >
                    <i class="bi bi-plus-circle"></i> Add Seller
                </button>
                </a>
                @endcan
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="datatable-seller" class="table">
                       <thead>
                            <tr>
                                <th>Id</th>
                                <th>UserName</th>
                                <th>Email Id</th>
                                <th>Profile Img</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>                           
                                <th>UserName</th>
                                <th>Email Id</th>
                                <th>Profile Img</th>
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

<!-- Toastr -->
    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

       

<script type="text/javascript">

    //toaster options
    toastr.options = {
      "closeButton": true,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
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
            toastr['success']('{{Session::get('success')}}');
      
        @endif

    $(document).ready(function(){


        $('#datatable-seller').DataTable({
            processing:true,
            serverSide:true,
            ajax:{
                type:'post',
                url:"{{route('admin.seller.ajax')}}",
                data:{'_token':'{{csrf_token()}}','mode':'datatable'}
            },
            columns: [
                    {data: 'id', name: 'DT_RowIndex'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'email_id', name: 'email_id'},
                    {data: 'profile_img', name: 'profile_img',orderable:false},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false
                    },
                ]   
        });
    });



    function DeleteFunc(id)
    {
        toastr.options = {
            "progressBar":false,
            "closeButton":true
        }
        toastr["info"]("Are you sure you want to delete record? <br /><br /><button type='button' id='cnf_del_btn' class='btn btn-light btn-sm'>Yes</button>")

        $('#cnf_del_btn').click(function(){
            $.ajax({
                type:'post',
                url:'{{ route('admin.seller.destroy','')}}'+"/"+id,    
                data:{'_token':'{{csrf_token()}}','_method':'Delete'},
                datatype:'json',
                success:function(response)
                {
                    if(response.success)
                    {
                        toastr['success'](response.success);
                        $('#datatable-seller').DataTable().draw(false);    
                    }else {
                        toastr['error'](response.error);
                        $('#datatable-seller').DataTable().draw(false);
                    }
                }



            });

        });

    }   

</script>


@endsection

