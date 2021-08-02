@extends('backend.layout.app') 

@section('title')
    Category
@endsection

@section('css')
    <!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

    <!-- Prism -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/prism/prism.css')}}" type="text/css">

    <!-- toaster css -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/toastr.css')}}" type="text/css">

    <link rel="stylesheet" href="{{ asset('backend_asset/libs/select2/css/select2.min.css')}}" type="text/css">

@endsection

@section('content')
    <!-- content -->
    <div class="content ">
        
    <div class="row">
        <div class="col-lg-12 bd-content">
            
        <div class="p-3">
            <h4 class="d-inline" >Category Detail</h4>    
            @can('Add Categories')
            <button class="btn btn-primary btn-icon d-inline float-end" data-bs-toggle="modal" data-bs-target="#newCategoryModal" >
                        <i class="bi bi-plus-circle"></i> Add Category
            </button>
            @endcan
        </div>

            <div class="card">
                <div class="card-body">
                    <table id="CategoryDatatable" class="table">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category Name</th>
                            <th>Parent Category Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                   
                        <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>Category Name</th>
                            <th>Parent Category Name</th>
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

    <!-- Add Category Model -->
    <div class="modal fade" id="newCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="AddCategoryForm" >

                        <div class="mb-3 row ">
                            <label for="Category" class="col-sm-3 form-label">Parent Category</label>
                            <div class="col-sm-9" >
                                <select id="Category" name="Category" class="select2-example" >
                                    <option value="">Please select Category</option>
                                    @foreach($Categorys as $category_detail)
                                        <option value="{{ $category_detail->id }}">{{ $category_detail->category_name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="category_name" class="form-control"   >
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

    <!--/ Add Category Model -->


    <!-- Edit Category Model -->
    <div class="modal fade" id="EditCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="btn_close"  aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" id="EditCategoryForm" >
                        <div class="mb-3 row ">
                            <label for="Category" class="col-sm-3 form-label">Parent Category</label>
                            <div class="col-sm-9" >
                                <select id="EditCategory" name="EditCategory" class="select2-example" >
                                    <option value="">Please select Category</option>
                                    @foreach($Categorys as $category_detail)
                                        <option value="{{ $category_detail->id }}">{{ $category_detail->category_name }}</option>
                                    @endforeach 
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Category Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="edit_category_name" class="form-control"   >
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
    <!--/ Edit Category Model -->



@endsection

@section('js')

 <!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>

    <!-- toaster js -->
    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

    <script src="{{asset('backend_asset/libs/select2/js/select2.min.js')}}"></script>


    <script type="text/javascript">


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


        $(document).ready(function(){

            //To display category Details
            $('#CategoryDatatable').DataTable({ 
                processing: true,
                serverSide: true,
                ajax:{
                    type:'post',
                    url:'{{ route('admin.category.ajax')}}',
                    data:{'_token':'{{ csrf_token() }}','data':'datatable'}
                },
                columns:[
                    {data:'id',name:'DT_RowIndex'},
                    {data:'category_name', name:'name'},
                    {data:'Parent_Category_Name'},
                    {
                        data:'action',
                        name:'action',
                        searchable:false,
                        orderable:false
                    }
                ]
            });
        });

        //To insert Category
        $('#AddCategoryForm').submit(function(e){
            e.preventDefault();

            var category_name = $('#category_name').val();
            var Category = $('#Category').val();
            $.ajax({
                type:'post',
                url:'{{ route('admin.category.store') }}',
                data:{
                    '_token':'{{ csrf_token() }}',
                    'category_name':category_name,
                    'Category':Category
                },
                datatype:'json',
                success:function(response){
                    if(response.error)
                    {
                        let Errorstring =""

                        for(let i=0;i<$(response.error).length;i++)
                        {
                            Errorstring += response.error[i]+"<br>";
                        }

                        toastr["error"](Errorstring);
                    }
                    else{


                        $('#newCategoryModal').modal('toggle');
                        $('#category_name').val("");
                        toastr["success"](response.success);
                        $('#CategoryDatatable').DataTable().draw(false);


                       if(response.text)
                       {
                            var option1 = new Option(response.text,response.id,false,false);
                            $('#Category').append(option1).trigger('change');
                            var option2 = new Option(response.text,response.id,false,false);
                            $('#EditCategory').append(option2).trigger('change');
                            $('#EditCategory').val(null).trigger('change');
                       }     
                        
                    }
                }
            })    
        })


        //For a delte a category
        function DeleteFunc(id){

        //For remove a progressbar and set a closebutton
            toastr.options = {
                "progressBar":false,
                "closeButton":true,
            }

            //confirmation toaster
            toastr["info"]("Are you sure you want to Delete Record?<br /><br /><button id='cnf_del_btn'  type='button' class='btn btn-light btn-sm'>Yes</button>");
            $("#cnf_del_btn").click(function(){

                $.ajax({
                    type:'post',
                    url: '{{ route('admin.category.destroy','') }}'+'/'+id,
                    data:{
                        '_token':'{{ csrf_token() }}',
                        '_method':'Delete'
                    },
                    datatype:'json',
                    success:function(response){

                        if(response.error)
                        {
                            toastr["error"](response.error);
                        }else{
                            toastr["success"]("Record Deleted Successfully");
                            $('#CategoryDatatable').DataTable().draw(false);
                        }    
                    }
                }); 
            });

        }

        //code for click on edit button and show modle
        $(document).on('click','#EditBtn',function(){
            var Editurl = $(this).attr('editurl');
            var Editdata = jQuery.parseJSON($(this).attr('editdata'));
            $('#edit_category_name').val(Editdata.category_name);
            $('#EditCategoryForm').attr('action',Editurl);
            $('#EditCategory').val(Editdata.parent_category_id)
            $('#EditCategory').trigger('change');
            $('#EditCategoryModal').modal('show');
        });

        //run the script when edit form is submited
        $('#EditCategoryForm').submit(function(e){
              e.preventDefault();  

            var Updateurl = $(this).attr('action');
            var category_name = $('#edit_category_name').val();
            var edit_category = $('#EditCategory').val();

            $.ajax({
                type:'post',
                url:Updateurl,
                data:{
                    '_token':'{{ csrf_token() }}',
                    '_method':'put',
                    'category_name':category_name,
                    'edit_category':edit_category
                },
                datatype:'json',
                success:function(response){
                   if(response.error)
                    {
                        let Errorstring =""

                        for(let i=0;i<$(response.error).length;i++)
                        {
                            Errorstring += response.error[i]+"<br>";
                        }

                        toastr["error"](Errorstring);
                    }
                    else{


                        $('#EditCategoryModal').modal('toggle');
                        $('#category_name').val("");
                        toastr["success"](response.success);
                        $('#CategoryDatatable').DataTable().draw(false);
                    }
                }

            }); 
        });

    </script>

@endsection

