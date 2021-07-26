@extends('backend.layout.app')

@section('title')
	Users
@endsection

@section('css')

    <!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/toastr.css')}}" type="text/css">
@endsection


@section('content')
<div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
            <div class="p-3">    
                <h4 class="d-inline" >User Detail</h4>
                <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#AddUser" >
                    <i class="bi bi-plus-circle"></i> Add User
                </button>
            </div>
        <div class="card">
            <div class="card-body">
                    <table id="datatable-user" class="table">
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
     <!-- View User Detail Model -->
    <div class="modal fade" id="ViewUserDetail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close_view"  aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                   
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Profile img</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <img src="" id="UserImg" alt="" height="150" width="150">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="Name"></p>
                            </div>
                        </div>
                        <div class="mb-3 row" id="new_address">
                            <label class="col-sm-3 col-form-label">UserName</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="UserName"></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Address Line 1</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="AddressLine1"></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Address Line 2</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="AddressLine2"></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Landmark</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="Landmark"></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Pincode</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="Pincode"></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contect Number</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="UserContect"></p>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email Id</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 col-form-label">
                                <p id="UserEmail"></p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ View User Detail Model -->

    <!-- Add User Model -->
    <div class="modal fade" id="AddUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <form action="" id="AddUsers" accept-charset="utf-8" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="post">

                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Profile img</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 ">
                                <input type="file" id="user_img" name="profile_img" class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 ">
                                <input type="text" id="name"  name="name" class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">UserName</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="text" id="user_name"  name="user_name"class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="password" id="password"  name="password"class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Confirom Password</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="password" id="c_password"  name="c_password"class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contect Number</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                 <input type="number" id="user_contect"  name="phone_no"  class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email Id</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="email" id="user_email"   name="email_id" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center ">
                                <button type="submit" class="btn btn-primary" id="AddUserBtn" >Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Add User Model -->


    <!-- Edit User Model -->
    <div class="modal fade" id="EditModalUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close_edit"  aria-label="Close"> </button>
                </div>
                <div class="modal-body">
                    <form  id="EditFormUsers" accept-charset="utf-8" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="put"> 
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Uploaded Profile img</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 ">
                                <img  src="" id="edituserimg" alt="" height="150" width="150">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Profile img</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 ">
                                <input type="file" id="edit_user_img" name="edit_profile_img" class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8 ">
                                <input type="text" id="edit_name"  name="edit_name" class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">UserName</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="text" id="edit_user_name"  name="edit_user_name" class="form-control" >
                            </div>
                        </div>
                       
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="password" id="edit_password"  name="edit_password"class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="password" id="edit_c_password"  name="edit_c_password"class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Contect Number</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                 <input type="text" id="edit_user_contect"  name="edit_phone_no"  class="form-control" >
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Email Id</label>
                            <div class="col-sm-1 col-form-label">:</div>
                            <div class="col-sm-8">
                                <input type="text" id="edit_user_email"   name="edit_email_id" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="mb-3 row">
                            <div class="col-sm-12 text-center ">
                                <button type="submit" class="btn btn-primary" id="AddUserBtn" >Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/Edit User Model -->


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





    $(document).ready(function(){

        $('.btn-close').click(function(){
           
            $('#name').val("");
            $('#user_name').val("");
            $('#password').val("");
            $('#c_password').val("");
            $('#user_contect').val("");
            $('#user_email').val("");
            $('#user_img').val("");

        });
        $('#btn_close_edit').click(function(){
           
            $('#edit_user_img').val("");
            $('#edit_password').val("");
            $('#edit_c_password').val("");
           
        });

        $('#datatable-user').DataTable({
            processing:true,
            serverSide:true,
            ajax: {
                type:'post',
                url:"{{ route('admin.user.ajax')}}",
                data:{'_token':'{{csrf_token()}}','model':'datatable'}
            },
            columns: [
                    {data: 'id', name: 'DT_RowIndex'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'email_id', name: 'email_id'},
                    {data: 'profile_img', name: 'profile_img'},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
        });

    }); 
       /* $(document).on('click','#ViewBtn',function(){
           
            $('#ViewUserDetail').modal('show');
           // var viewdata = jQuery.parseJSON($(this).attr('editdata'));
            var viewdata = jQuery.parseJSON($(this).attr('viewdata'));

            var img_path = "{{url::to('/')}}/backend_asset/user_img/"+viewdata.profile_img;

            $('#UserImg').attr('src',img_path);
            $('#UserEmail').html(viewdata.email_id);
            $('#UserContect').html(viewdata.phone_no);
            $('#UserName').html(viewdata.user_name);
            $('#Name').html(viewdata.name);
            $('#AddressLine1').html(viewdata.useraddress[0].address_line_1);
            $('#AddressLine2').html(viewdata.useraddress[0].address_line_2);
            $('#Landmark').html(viewdata.useraddress[0].landmark);
            $('#Pincode').html(viewdata.useraddress[0].pincode);
            
            new_address
            var len = ($(viewdata.useraddress).length);
            for(var i=0;i<len;i++)
            {
                $("#new_address").append(""); 
                
            }

        });*/

    // add new user ajax
    $('#AddUsers').submit(function(e){
        
        e.preventDefault();

    
        $.ajax({
            type:'post',
            url:'{{ route('admin.user.store') }}',
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            datatype:'json',
            success:function(response)
            {
               
                if(response.error)
                {
                    let err = "";
                    for(let i=0;i<$(response.error).length;i++)
                    {
                        err += response.error[i]+"<br/>";
                    }
                     //toastr for error message
                        toastr["error"](err);
                }else {
                    toastr["success"](response.success);
                    $('#AddUser').modal('hide');
                    $('#datatable-user').DataTable().draw(false);
                }
            }

        });
    });



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
                url:'{{ route('admin.user.destroy','')}}'+"/"+id,
                data:{'_token':'{{csrf_token()}}','_method':'Delete'},
                datatype:'json',
                success:function(response)
                {
                    toastr["success"]("Record Deleted Successfully");
                    $('#datatable-user').DataTable().draw(false);
                }


            });


        });

    }

    // Function For Edit Modal
    $(document).on('click','#EditBtn',function(){
        var editdata = jQuery.parseJSON($(this).attr('editdata'));
        var editurl = $(this).attr('editurl');
        $('#EditFormUsers').attr('action',editurl);
        var showimgurl = "{{url::to('/')}}/backend_asset/user_img/"+editdata.profile_img;

        $('#edit_name').val(editdata.name);
        $('#edit_user_email').val(editdata.email_id);
        $('#edit_user_contect').val(editdata.phone_no);
        $('#edit_user_name').val(editdata.user_name);
        $('#edituserimg').attr('src',showimgurl);


        $('#EditModalUser').modal('show');
    });

    //Function For Edit model Insert ajax 
    $('#EditFormUsers').submit(function(e){
        e.preventDefault();

        var editurl = $(this).attr('action');

        $.ajax({
            type:'post',
            url:editurl,
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success:function(response)
            {
                if(response.error)
                {
                    //toastr for error message
                    toastr["error"](response.error);
                }else {
                    $('#EditModalUser').modal('hide');
                    toastr["success"](response.success);
                    $('#datatable-user').DataTable().draw(false);
                }
            }

        });


    });


</script>

   

@endsection
