@extends('backend.layout.app')

@section('title')
    Rolls
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
                <h4 class="d-inline" >Roll Detail</h4>
                <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#newTaskModal" >
                    <i class="bi bi-plus-circle"></i> Add Role
                </button>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="datatable-example" class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Role Name</th>
                            <th>Guard Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                      
                        <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Role Name</th>
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

    <!-- Add Role Model -->
    <div class="modal fade" id="newTaskModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="AddRoleForm" >
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Role Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="role_name" autofocus  class="form-control" >
                            </div>
                        </div>
                        
                    
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center ">
                                <button type="submit" class="btn btn-primary" id="AddRoleBtn" >Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add Role Model -->


    <!-- Edit Role Model -->
    <div class="modal fade" id="EditRoleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    

                    <form autocomplete="off" id="EditRoleForm">
                        <input type="hidden" name="RoleId" id="RoleId" >
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Role Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="edit_role_name"  class="form-control" autofocus>
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center ">
                                <button type="submit" class="btn btn-primary" id="EditRoleBtn" >Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Role Model -->





@endsection

@section('js')

 <!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

    <!-- Examples -->
    {{-- <script src="{{URL::asset('backend_asset/js/examples/datatable.js')}}"></script> --}}

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>
    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

    

    <script type="text/javascript" >


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



        //for a datatable
        $(document).ready(function () {

            $('#datatable-example').DataTable({
                processing: true,
                serverSide: true,
                ajax: { 
                 type:'post',
                 url:"{{ route('admin.role.ajax') }}",
                 data:{'_token':'{{ csrf_token() }}','mode':'datatable'}
                },
                columns: [
                    {data: 'id', name: 'DT_RowIndex'},
                    {data: 'name', name: 'role name'},
                    {data: 'guard_name', name: 'guard_name'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
            });

        });






        //Add role click function for add form modal and store data into database using ajax and give a success and error resposne 
        $('#AddRoleForm').submit(function(e){

            e.preventDefault();

            var role_name = $('#role_name').val();

            $.ajax({
                type:'post',
                url:'{{ route('admin.role.store') }}',
                data:{'role_name':role_name,'_token':'{{ csrf_token() }}' },
                datatype:'json',
                success:function(response){
                   if(response.error) 
                   {     


                        //toastr for error message
                        toastr["error"](response.error);
                   }
                   else
                   { 
                        //toastr for success message
                        $('#newTaskModal').modal('toggle');
                        $('#role_name').val("");
                        toastr["success"](response.success);
                        $('#datatable-example').DataTable().draw(false);
                   }
                }
            });
        });


        //to clear a textbox when close the moddle
        $('#btn_close').click(function(){
            $('#role_name').val("");
        });


        //Delete Function For Delete a Role Record

        function DeleteFunc(id)
        {   

            toastr.options ={
                "progressBar":false,
                "closeButton":true
            }

            toastr["info"]("Are you sure you want to delete record? <br /><br /><button type='button' id='cnf_del_btn' class='btn btn-light btn-sm'>Yes</button>")
            


            $('#cnf_del_btn').click(function(){

                $.ajax({
                    type:'post',
                    url:'{{ route('admin.role.destroy','')}}'+'/'+id,
                    data:{'_token':'{{ csrf_token() }}','_method':'Delete'},
                    datatype:'json',
                    success:function(resposnse)
                    {

                        toastr["success"]("Record Deleted Successfully");
                        $('#datatable-example').DataTable().draw(false)
                    }
                });
            });    
        }
        

        //Function for edit modal

        $(document).on('click','#EditBtn',function(){
            
            var editdata = jQuery.parseJSON($(this).attr('editdata'));        
            var url = $(this).attr('editurl');
            // console.log(editdata.name);

            $('#edit_role_name').val(editdata.name);
            $('#RoleId').val(editdata.id);
            $('#EditRoleForm').attr('action',url);
            $('#EditRoleModal').modal('show');   
        })

        $('#EditRoleForm').submit(function(e){
            e.preventDefault();

            var edit_role_name = $('#edit_role_name').val();

            var edit_url = $(this).attr('action');

            $.ajax({
                type:'post',
                url: edit_url,
                data:{'_token':'{{ csrf_token() }}',
                'role_name':edit_role_name,
                '_method': 'put' },
                datatype:'json',
                success:function(response) {
                   if(response.error) 
                   {     
                        //toastr for Error message
                        toastr["error"](response.error);
                   }
                   else
                   { 
                        //toastr for success message
                        $('#EditRoleModal').modal('toggle');
                        $('#edit_role_name').val("");
                        toastr["success"](response.success);
                        $('#datatable-example').DataTable().draw(false)
                   }
                }
            })

        });

    </script>

@endsection

