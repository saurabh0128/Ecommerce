@extends('backend.layout.app')

@section('title')
Role Permission
@endsection

@section('css')

	 <!-- DataTable -->
    <link rel="stylesheet" href="{{asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Prism -->
    <link rel="stylesheet" href="{{asset('backend_asset/libs/prism/prism.css')}}" type="text/css">

    <!-- toaster css -->
    <link rel="stylesheet" href="{{asset('backend_asset/css/toastr.css')}}" type="text/css">

    <!-- CSS -->
	<link rel="stylesheet" href="{{asset('backend_asset/libs/select2/css/select2.min.css')}}" type="text/css">
@endsection

@section('content')

	 <div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
            
            <div class="p-3">
                <h4 class="d-inline" >Role Permission Detail</h4>
               
                <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#newRolePermissionModal"   >
                        <i class="bi bi-plus-circle"></i> Add Role Permission
                </button>
                
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="RolePermissionDatatable" class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Role Name</th>
                            <th>Permission Name</th>
                            <th>Action </th>
                        </tr>
                        </thead>
                   
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Role Name</th>
                            <th>Permission Name</th>
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


    <!-- Add RolePermission Model -->
    <div class="modal fade" id="newRolePermissionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="AddRolePermissionForm" >
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="role" id="role"  aria-label="Please Select Role">
                                	@foreach($roles as $role)
                                		<option value="{{ $role->id }}">{{ $role->name }} </option>
                                	@endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Permission</label>
                            <div class="col-sm-9">
                                <select class="select2-example" name="permission" id="permission" multiple >
                                	@foreach($Permissions as $Permission)
                                		<option id="{{ $Permission->name }}">{{ $Permission->name }} </option>
                                	@endforeach
                                </select>
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

    <!--/ Add RolePermission Model -->

    <!-- Edit RolePermission Model -->
    <div class="modal fade" id="EditRolePermissionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="EditRolePermissionForm" >
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="editrole" id="editrole"  aria-label="Please Select Role">
                                
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Permission</label>
                            <div class="col-sm-9">
                                <select class="select2-example" name="Editpermission" id="Editpermission" multiple >
                                    @foreach($Permissions as $Permission)
                                        <option value="{{ $Permission->name }}">{{ $Permission->name }} </option>
                                    @endforeach
                                </select>
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

    <!--/ Edit RolePermission Model -->  	


@endsection

@section('js')
	
	<!-- Datatable -->
    <script src="{{asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

    <!-- Prism -->
    <script src="{{asset('backend_asset/libs/prism/prism.js')}}"></script>

    <!-- toaster js -->
    <script src="{{asset('backend_asset/js/toastr.min.js')}}"></script>

    <!-- Javascript -->
	<script src="{{asset('backend_asset/libs/select2/js/select2.min.js')}}"></script>

	<script  type="text/javascript" >

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

		$('.select2-example').select2({
		});


		

            //To display Role Permission Details
          var table = $('#RolePermissionDatatable').DataTable({ 
                processing: true,
                serverSide: true,
                ajax:{
                    type:'post',
                    url:'{{ route('admin.rolepermission.ajax')}}',
                    data:{'_token':'{{ csrf_token() }}','data':'datatable'}
                },
                columns:[
                    {data:'id',name:'DT_RowIndex'},
                    {data:'name', name:'name'},
                    {data:'permission name', name:'name'},
                    {
                        data:'action',
                        name:'action',
                        searchable:true,
                        orderable:true
                    }
                ]
            });

             $('#btn_close').click(function(){
                $('.select2-selection__choice').remove();
             });


            $('#AddRolePermissionForm').submit(function(e){
            e.preventDefault();

                var role = $('#role').val();
                var Permission = $('#permission').val();

                $.ajax({
                    type:'post',
                    url:'{{ route('admin.rolepermission.store')}}',
                    data:{'_token':'{{csrf_token()}}','role':role,'permission':Permission },
                    datatype:'json',
                    success:function(response){
                        if(response.error){
                            let Errorstring =""
                            for(let i=0;i<$(response.error).length;i++)
                            {
                                Errorstring += response.error[i]+"<br>";
                            }
                            toastr["error"](Errorstring);
                        }
                        else{
                            $('.select2-selection__choice').remove();
                            $('#newRolePermissionModal').modal('toggle');
                            table.ajax.reload()
                            toastr["success"](response.success);
                        }
                    }
                });
            });

       
            $(document).on('click','.EditBtn',function(){
                $('#EditRolePermissionModal').modal('show');
                var editdata = jQuery.parseJSON($(this).attr('editdata'));

                // $('.editrole select ').val(editdata.id).change();

                $('#editrole').html('<option  value="'+ editdata.id +'">'+ editdata.name +'</option>')
                $('#editrole').attr('disabled');

                $('#Editpermission').find('option[value="Add Product"]').attr('selected','selected');
               
            })

	</script>		

@endsection