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
		<div class="card-title text-center">Add Seller Form </div>
		<form id="AddProduct" method="post"  action="{{ route('admin.seller.store') }}" enctype="multipart/form-data" >

			@csrf
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="name" class="form-label">Name*</label>
			    	<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autofocus  >
			    	@error('name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="user_name" class="form-label">UserName*</label>
			    	<input type="text" class="form-control" id="user_name" name="user_name" value="{{ old('user_name') }}" autofocus  >
			    	@error('user_name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>   
			
			    <div class="mb-3 col-5 ">
			    	<label for="contect_no" class="form-label">Contectn No*</label>
			    	<input type="text" class="form-control" id="contect_no" name="contect_on" value="{{ old('contect_no') }}" autofocus  >
			    	@error('contect_no')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-1"></div>
					
			    <div class="mb-3 col-5 ">
			    	<label for="contect_no" class="form-label">User profile*</label>
			    	<input type="file" class="form-control" id="contect_no" name="user_profile" >
			    	@error('user_profile')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>

			    <div class="mb-3 col-5">
			    	<label for="companie_name" class="form-label">Companie Name*</label>
			    	<input type="text" class="form-control" id="companie_name" name="companie_name" value="{{ old('companie_name') }}" autofocus  >
			    	@error('companie_name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="address" class="form-label">Address*</label>
			    	<textarea class="form-control" id="address" name="address">{{old('address')}}</textarea>
			    	@error('address')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-1"></div>
			    <div class="mb-3 col-5 ">
			    	<label for="state" class="form-label">State Name*</label>
			    	<select id="state" name="state" class="select2-example" >
			    		<option value="">Please select State</option>
			    			@foreach($state as $value)
			    			<option value="{{$value->id}}">{{$value->StateName}}</option>
			    			@endforeach
			    	</select>
			    	@error('state')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			   

			    <div class="mb-3 col-5 ">
			    	<label for="city" class="form-label">City Name*</label>
			    	<select id="city" name="city" class="select2-example" >
			    		<option value="">Please select City</option>
			    	
			    			<option value="">s</option>
			    		
			    	</select>
			    	@error('city')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="email_id" class="form-label">Email Id*</label>
			    	<input type="text" class="form-control" id="email_id" name="email_id" value="{{ old('email_id') }}" autofocus  >
			    	@error('email_id')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
					
			    <div class="mb-3 col-5 ">
			    	<label for="password" class="form-label">Password*</label>
			    	<input type="password" class="form-control" id="password" name="password" value="{{ old('passsword') }}" autofocus  >
			    	@error('password')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			<div class="row">
				<div class="col-1"></div>	
		
			    <div class="mb-3 col-5 ">
			    	<label for="gst_no" class="form-label">Gst No*</label>
			    	<input type="text" class="form-control" id="gst_no" name="gst_no" >
			    	@error('gst_no')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>

			     <div class="mb-3 col-5 ">
			    	<label for="back_name" class="form-label">Back Name*</label>
			    	<input type="text" class="form-control" id="back_name" name="back_name" >
			    	@error('back_name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>

			    <div class="col-1"></div>	
			</div>
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="account_no" class="form-label">Account No*</label>
			    	<input type="text" class="form-control" id="account_no" name="account_no" >
			    	@error('account_no')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="mb-3 col-5 ">
			    	<label for="ifc_code" class="form-label">Ifc Code*</label>
			    	<input type="text" class="form-control" id="ifc_code" name="ifc_code" >
			    	@error('ifc_code')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>	
			</div>
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="account_holedr_name" class="form-label">Account Holedr Name*</label>
			    	<input type="text" class="form-control" id="account_holedr_name" name="account_holedr_name" >
			    	@error('account_holedr_name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="mb-3 col-5 ">
			    	<label for="id_proof_no" class="form-label">Id Proof No*</label>
			    	<input type="text" class="form-control" id="id_proof_no" name="id_proof_no" >
			    	@error('id_proof_no')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>	
			</div>
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="id_proof" class="form-label">Id Proof*</label>
			    	<input type="text" class="form-control" id="id_proof" name="id_proof" >
			    	@error('id_proof')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="mb-3 col-5  ">
				    	<label  for="is_display" class=" d-block form-label">Is Permission Sell?*</label>
			    	<div class="form-check form-check-inline " >	
				    	<input class="form-check-input" type="radio"  id="is_permission_sell_yes" name="is_permission_sell" value="0" >
				    	<label class="form-check-label" for="is_permission_sell_yes">
						    Yes
						</label>
			    	</div>

				    <div class="form-check form-check-inline ">
				    	<input class="form-check-input" type="radio"  id="is_permission_sell_no" name="is_permission_sell" value="1" >
				    	<label class="form-check-label" for="is_permission_sell_no">
						    No
						</label>
					</div>
					@error('is_permission_sell')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
				</div>
			    <div class="col-1"></div>	
			</div>
		
			<div class="row">
				<div class="col-1"></div>	
			    <div class="col-10 text-center ">
			    	<button type="submit" class="btn btn-primary">Submit</button>
			    </div>
			    <div class="col-1"></div>
			</div>

		</form>
	</div>
</div>

@endsection


@section('js')

<script src="{{asset('backend_asset/libs/select2/js/select2.min.js')}}"></script>

	<script type="text/javascript" charset="utf-8" >
		$('.select2-example').select2({});
	</script>

<script>

	$(document).ready(function(){


		$('#state').change(function(){
			var id = $(this).val();
			
			$.ajax({
				type:'post',
				url:'{{ route('admin.seller.ajax')}}',
				data:{'state_id':id,'_token':'{{csrf_token()}}','mode':'chek_state'},
				datatype:'text',
				success:function(response)
				{
					$('#city').html(response);
				}


			});
	

		});
	});
</script>

@endsection