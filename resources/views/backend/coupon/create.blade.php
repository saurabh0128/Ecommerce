@extends('backend.layout.app')

@section('title')
Add coupon
@endsection


@section('css')
	<link rel="stylesheet" href="{{ asset('backend_asset/libs/select2/css/select2.min.css')}}" type="text/css">
	<link rel="stylesheet" href="{{asset('backend_asset/libs/datepicker/daterangepicker.css')}}" type="text/css">
@endsection


@section('content')


<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Add Coupon Form </div>
		<form id="AddCoupon" method="post"  action="{{ route('admin.coupon.store') }}"  >

			@csrf
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="coupon_code" class="form-label">Coupon Code* </label>
			    	<input type="text" class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code') }}" autofocus  >
			    	@error('coupon_code')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>


			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="coupon_detail" class="form-label">Coupon Details*</label>
			    	<textarea class="form-control" id="coupon_detail" name="coupon_detail">{{old('coupon_detail')}}</textarea>
			    	@error('coupon_detail')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="coupon_discount" class="form-label">Coupon discount*</label>
			    	<input type="text" class="form-control" id="coupon_discount" name="coupon_discount" value="{{ old('coupon_discount') }}"  >
			    	@error('coupon_discount')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			   
			    <div class="mb-3 col-5 ">
			    	<label for="discount_type" class="form-label">Discount type*</label>
			    	<select name="discount_type" id="discount_type" class="form-select" >
			    		<option value="">Please select discount type</option>
			    		<option  @if(old('discount_type') == "percentage") selected @endif value="Percentage">Percentage</option>
			    		<option  @if(old('discount_type') == "Rupees") selected @endif value="Rupees">Rupees</option>
			    	</select>
			    	@error('discount_type')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="coupon_type" class="form-label">Coupon type*</label>
			    	<select name="coupon_type" id="coupon_type" class="form-select" >
			    		<option value="">Please select discount type</option>
			    		<option @if(old('coupon_type') == "Product") selected @endif  value="Product">Product</option>
			    		<option @if(old('coupon_type') == "Category") selected @endif value="Category">Category</option>
			    	</select>
			    	@error('coupon_type')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="mb-3 col-5 ">
			    	<label for="total_uses" class="form-label">total uses</label>
			    	<input type="NUMBER" class="form-control" id="total_uses" name="total_uses" value="{{ old('total_uses') }}"   >
			    	@error('total_uses')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>	


			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="start_date" class="form-label">start date*</label>
			    	<input type="text" class="form-control datepicker " id="start_date" name="start_date" value="{{ old('start_date') }}"   >
			    	@error('start_date')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>

			    <div class="mb-3 col-5 ">
			    	<label for="end_date" class="form-label">end date*</label>
			    	<input type="text" class="form-control datepicker " id="end_date" name="end_date" value="{{ old('end_date') }}"   >
			    	@error('end_date')
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
	<script src="{{asset('backend_asset/libs/datepicker/daterangepicker.js')}}"></script>

	<script type="text/javascript" charset="utf-8" >
		$('.select2-example').select2({
		});

		$('.datepicker').daterangepicker({
		   singleDatePicker: true,
		   showDropdowns: true
		});
	</script>

@endsection