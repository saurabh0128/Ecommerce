@extends('backend.layout.app')

@section('title')
	Users
@endsection

@section('css')

   <!-- DataTable -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/libs/dataTable/datatables.min.css')}}" type="text/css">

@endsection


@section('content')

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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td>$320,800</td>
                            <td>ssdf</td>
                        </tr>
                        <tr>
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>Tokyo</td>
                            <td>63</td>
                            <td>2011/07/25</td>
                            <td>$170,750</td>
                            <td>sdasdas</td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>



@endsection


@section('js')

<!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

    <!-- Examples -->
    <script src="{{URL::asset('backend_asset/js/examples/datatable.js')}}"></script>


   

@endsection
