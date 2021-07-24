@extends('backend.layout.app')

@section('title')
Add Product
@endsection

@section('css')

	<link rel="stylesheet" href="{{ asset('backend_asset/libs/select2/css/select2.min.css')}}" type="text/css">

@endsection


@section('content')


<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Add Product Form </div>
			@foreach($UserData as $data)
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">User Profile</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<img src="{{asset('/backend_asset/user_img/'.$data->profile_img)}}" height="150" width="150" alt="">
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Name</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$data->name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">UserName</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$data->user_name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			
			@if(count($data->userAddress)>0)
				
				@for($i=0;$i < count($data->userAddress);$i++)

					<div class="row">
						<div class="col-2">
							<label for="product_name" class="form-label">Address </label>
						</div>	
						<div class="col-1">:</div>
					    <div class="mb-3 col-8 ">
					    	<lable>{{$data->userAddress[$i]->address_line_1}}</lable>
					    </div>
					    <div class="col-1"></div>
					</div>
					<div class="row">
						<div class="col-2">
							<label for="product_name" class="form-label">Address </label>
						</div>	
						<div class="col-1">:</div>
					    <div class="mb-3 col-8 ">
					    	<lable>{{$data->userAddress[$i]->address_line_2}}</lable>
					    </div>
					    <div class="col-1"></div>
					</div>
					<div class="row">
						<div class="col-2">
							<label for="product_name" class="form-label">Landmark</label>
						</div>	
						<div class="col-1">:</div>
					    <div class="mb-3 col-8 ">
					    	<lable>{{$data->userAddress[$i]->landmark}}</lable>
					    </div>
					    <div class="col-1"></div>
					</div>
					<div class="row">
						<div class="col-2">
							<label for="product_name" class="form-label">Pincode</label>
						</div>	
						<div class="col-1">:</div>
					    <div class="mb-3 col-8 ">
					    	<lable>{{$data->userAddress[$i]->pincode}}</lable>
					    </div>
					    <div class="col-1"></div>
					</div>
					
						<div class="row">
							<div class="col-2">
								<label for="product_name" class="form-label">City</label>
							</div>	
							<div class="col-1">:</div>
						    <div class="mb-3 col-8 ">
						    	<lable>{{$data->userAddress[$i]->city->city_name}}</lable>
						    </div>
						    <div class="col-1"></div>
						</div>
							
					
				@endfor
			@endif

			

			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Contect Us</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$data->phone_no}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Email Id</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$data->email_id}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			
			@endforeach
	
	</div>
</div>

@endsection


@section('js')

<script src="{{asset('backend_asset/libs/select2/js/select2.min.js')}}"></script>

	<script type="text/javascript" charset="utf-8" >
		$('.select2-example').select2({
		});
	</script>

@endsection