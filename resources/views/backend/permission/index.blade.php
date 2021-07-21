@extends('backend.layout.app')

@section('title')
    Pemission
@endsection

@section('css')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Prism -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/prism/prism.css')}}" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/toastr.css')}}" type="text/css">
@endsection

@section('content')
    <!-- content -->
    <div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
            <div class="p-3">
                <h4 class="d-inline" >Permission Detail</h4>
                <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#newPermissionModal" >
                        <i class="bi bi-plus-circle"></i> Add Permission
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="PermissionDatatable" class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Guard Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Guard Name</th>
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

    <!-- Add Permission Model -->
    <div class="modal fade" id="newPermissionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="AddPermissionForm" >
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Permission Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="permission_name" class="form-control"   >
                            </div>
                        </div>
                        
                    
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center ">
                                <button type="submit" class="btn btn-primary" >Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--/ Add Permission Model -->


    <!-- Edit Permission Model -->
    <div class="modal fade" id="EditPermissionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="EditPermissionForm" >
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Permission Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="edit_permission_name" class="form-control"   >
                            </div>
                        </div>
                        
                    
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center ">
                                <button type="submit" class="btn btn-primary" >Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--/ Edit Permission Model -->




@endsection

@section('js')

 <!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

   {{--  <!-- Examples -->
    <script src="{{URL::asset('backend_asset/js/examples/datatable.js')}}"></script> --}}

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>

    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

    <script type="text/javascript" >

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
        
        $(document).ready(function(){

            $('#PermissionDatatable').DataTable({
                
                processing: true,
                serverSide: true,
                ajax:{
                    type:'post',
                    url:'{{ route('admin.permission.ajax')}}',
                    data:{'_token':'{{ csrf_token() }}','data':'datatable'}
                },
                columns:[
                    {data:'id',name:'DT_RowIndex'},
                    {data:'name', name:'name'},
                    {data:'guard_name',name:'guard_name'},
                    {
                        data:'action',
                        name:'action',
                        searchable:true,
                        orderable:true
                    }
                ]
            });
        });




        $('#AddPermissionForm').submit(function(e){
            e.preventDefault();
            var permission_name = $('#permission_name').val();
            $.ajax({
                type:'post',
                url:'{{ route('admin.permission.store') }}',
                data:{'_token':'{{ csrf_token() }}',
                'permission_name': permission_name},
                datatype:'json',
                success:function(resposne){
                    if(resposne.error)
                    {
                        //toastr for insert  error message
                        toastr["error"](resposne.error);
                    }
                    else
                    {
                        $('#newPermissionModal').modal('toggle');
                        $('#permission_name').val("");
                        toastr["success"](resposne.success);
                        $('#PermissionDatatable').DataTable().draw(false);

                    }
                }
            });
        });  

        function DeleteFunc(id){

            toastr.options = {
                "progressBar":false,
                "closeButton": true,
            }
            toastr["info"]("Are you sure you want to Delete Record?<br /><br /><button id='cnf_del_btn'  type='button' class='btn btn-light btn-sm'>Yes</button>");

           $('#cnf_del_btn').click(function(){
            $.ajax({
                type:'post',
                url:'{{ route('admin.permission.destroy','') }}'+'/'+id,
                data:{'_token':'{{ csrf_token() }}','_method':'delete'},
                datatype:'json',
                success:function(resposne){
                    toastr["success"]("Record Deleted Successfully");
                     $('#PermissionDatatable').DataTable().draw(false);
                }
            })
           }); 
        }


        //to clear a textbox when close the moddle
        $('#btn_close').click(function(){
            $('#role_name').val("");
        });

        $(document).on('click','#EditBtn',function(){

            var url =$(this).attr('editurl');

            var editdata = jQuery.parseJSON($(this).attr('editdata'));
            $('#edit_permission_name').val(editdata.name);

            $('#EditPermissionForm').attr('action',url);
            $('#EditPermissionModal').modal('show');
        });

        $('#EditPermissionForm').submit(function(e){

            e.preventDefault();

            var editurl = $(this).attr('action');
            var edit_permission_name = $('#edit_permission_name').val();
            $.ajax({
                type:'post',
                url:editurl,
                data:{
                    '_token':'{{ csrf_token() }}',
                    '_method':'put',
                    'edit_permission_name':edit_permission_name
                },
                datatype:'json',
                success:function(resposne){
                    if(resposne.error)
                    {
                        toastr["error"](resposne.error);
                    }
                    else
                    {
                        $('#EditPermissionModal').modal('toggle');
                        $('#edit_permission_name').val("");
                        toastr["success"](resposne.success);
                        $('#PermissionDatatable').DataTable().draw(false)
                    }
                }
            });
        });

    </script>

@endsection

