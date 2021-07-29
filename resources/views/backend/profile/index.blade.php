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
   <!-- content -->
    <div class="content ">
        
    <div class="row flex-column-reverse flex-md-row">
        <div class="col-1"></div>
        <div class="col-md-10">
            <form action="{{route('admin.profile.update',auth()->user()->id)}}" method="post" accept-charset="utf-8">
                @method('PUT')
                @csrf
                <div class="mb-4">
                    <div class="d-flex flex-column flex-md-row text-center text-md-start mb-3">
                        <figure class="me-4 flex-shrink-0">
                            <img width="150" height="150" class="rounded-pill"
                                 src="{{asset_img(auth()->user()->profile_img,'user_img')}}" alt="...">
                        </figure>
                        <div class="flex-fill">
                            <h5 class="mb-3">{{auth()->user()->user_name}}</h5>
                            <div class="col-9">
                                <input type="file" name="profile_img" class="form-control"id="profile_img">
                            </div>
                            
                        </div>
                    </div>
                   
                    <div class="card mb-4">
                        <div class="card-body">
                            <h6 class="card-title mb-4">Basic Information</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control"name="name" value="{{old('name',auth()->user()->name)}}" >
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" value="{{old('username',auth()->user()->user_name)}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Contect No</label>
                                    <input type="text" class="form-control" name="contect" value="{{old('contect',auth()->user()->phone_no)}}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{old('email',auth()->user()->email_id)}}">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
    
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Change Password</h6>
                        <div class="mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                            @if(Session::get('error'))
                                <p class="text-danger">{{Session::get('error')}}</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control" name="new_password">
                            @error('new_password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password Repeat</label>
                            <input type="password" class="form-control" name="confirm_password">
                            @error('confirm_password')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="submit" value="submit" class="btn btn-primary me-2 mt-3">
                    </div>
                </div>
            </form>  
        </div>
        <div class="col-1"></div>
    </div>

    </div>
    <!-- ./ content -->


@endsection


@section('js')

    <!-- Datatable -->
    <script src="{{URL::asset('backend_asset/libs/dataTable/datatables.min.js')}}"></script>

    <!-- Toastr -->
    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

@endsection