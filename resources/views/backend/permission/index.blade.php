@extends('backend.layout.app')

@section('title')
    Pemission
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
                <h4 class="d-inline" >Permission Detail</h4>
                <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#newPermissionModal" >
                        <i class="bi bi-plus-circle"></i> Add Permission
                </button>
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
                                <input type="text" id="permission_name" autofocus  class="form-control" >
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


@endsection

@section('js')

 <!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

   {{--  <!-- Examples -->
    <script src="{{URL::asset('backend_asset/js/examples/datatable.js')}}"></script> --}}

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>

    <script type="text/javascript" >
        
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
                    alert(resposne.error);
                }
            });
        });       

    </script>

@endsection

