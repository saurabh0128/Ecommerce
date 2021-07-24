@extends('backend.layout.app')

@section('title')
    State
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
            
            <h4>State Detail</h4>

            <div class="card">
                <div class="card-body">
                    <table id="datatable-state" class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>State Name</th>
                        </tr>
                        <tfoot>
                            <tr>
                                <th>Id</th>                           
                                <th>State Name</th>
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

    <!-- Examples -->
    <script src="{{URL::asset('backend_asset/js/examples/datatable.js')}}"></script>

    <!-- Prism -->
    <script src="{{URL::asset('backend_asset/libs/prism/prism.js')}}"></script>

    <script>
        $('document').ready(function(){
            $('#datatable-state').DataTable({
                processing:true,
                serverSide:true,
                ajax: {
                    type:'post',
                    url:"{{ route('admin.state.ajax')}}",
                    data:{'_token':'{{csrf_token()}}','model':'datatable'}
                },
                columns: [
                        {data: 'id', name: 'DT_RowIndex'},
                        {data: 'StateName', name: 'StateName'},
                       
                       
                    ]
            });


        });

    </script>


@endsection

