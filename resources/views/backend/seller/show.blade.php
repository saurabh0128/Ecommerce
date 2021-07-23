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
		<!-- 	@foreach($sellerdata as $user) -->
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">User Profile</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<img src="{{asset('/backend_asset/user_img/'.$user->profile_img)}}" height="150" width="150" alt="">
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Name</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">UserName</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->user_name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Address</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->address}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Contect Us</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->phone_no}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Email Id</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->email_id}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Company Name</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->company_name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Gst Number</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->gst_no}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Bank Name</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->bank_name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Account Number</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->account_no}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Account Holder Name</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->ac_holder_name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Ifsc Code</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->ifsc_code}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Id Proof Number</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->id_proof_no}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Id Proof</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->id_proof}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-2">
					<label for="product_name" class="form-label">Id Proof</label>
				</div>	
				<div class="col-1">:</div>
			    <div class="mb-3 col-8 ">
			    	<lable>{{$user->seller_infos->city->city_name}}</lable>
			    </div>
			    <div class="col-1"></div>
			</div>
			


		<!-- 	@endforeach -->
			
			
		
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