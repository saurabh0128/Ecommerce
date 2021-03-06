@extends('backend.layout.app')

@section('title')
Add Order
@endsection


@section('css')
	<link rel="stylesheet" href="{{ asset('backend_asset/libs/select2/css/select2.min.css')}}" type="text/css">
	<link rel="stylesheet" href="{{asset('backend_asset/libs/datepicker/daterangepicker.css')}}" type="text/css">
@endsection

@section('content')

<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Add Order Form </div>
		<form id="AddProduct" method="post"  action="{{ route('admin.order.store') }}" enctype="multipart/form-data" >

			@csrf

			<div class="row">
				<div class="col-1"></div>	
				<div class="mb-3 col-10 ">
			    	<label for="user" class="form-label">User*</label>
			    	<select name="user" name="user" id="user" class="select2-example" >
			    		<option value="">Please select user</option>
			    		@foreach($user as $user_detail)
			    			<option value="{{ $user_detail->id }}" data_name="{{ $user_detail->user_name }}" >{{ $user_detail->user_name }}</option>
			    		@endforeach
			    	</select>
			    	@error('user')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="customer_name" class="form-label">Customer Name</label>
			    	<input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" autofocus  >
			    	@error('customer_name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>


			<div class="row">
				<div class="col-1"></div>	
				<div class="mb-3 col-10 ">
			    	<label for="deliveryAddress" class="form-label">Delivery Address*</label>
			    	<select name="deliveryAddress" name="deliveryAddress" id="deliveryAddress" class="select2-example" >
			    		<option value="">Please select Delivery Address</option>
			 	    </select>
			    	@error('deliveryAddress')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
				<div class="mb-3 col-10 ">
			    	<label for="billingAddress" class="form-label">Billing Address*</label>
			    	<select name="billingAddress" name="billingAddress" id="billingAddress" class="select2-example" >
			    		<option value="">Please select Billing Address</option>
			 	    </select>
			    	@error('billingAddress')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>	

			<div class="row">
				<div class="col-1"></div>	
				<div class="mb-3 col-10 ">
			    	<label for="coupon" class="form-label">Coupon </label>
			    	<select name="coupon" name="coupon" id="coupon" class="select2-example" >
			    		<option value="">Please select coupan</option>
			    		@foreach($coupon as $coupon_detail)
			    			<option value="{{ $coupon_detail->id }}">{{ $coupon_detail->coupon_code }}</option>
			    		@endforeach
			    	</select>
			    	@error('coupon')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div> 
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1" ></div>
				<div class="mb-3 col-5 ">
			    	<label for="product" class="form-label">Product*</label>
			    	{{-- <input type="text" class="form-control" id="product" name="product" value="{{ old('product')  }}" > --}}

			    	<select name="product" id="product"  class="select2-example">
			    		<option value="">please select the product</option>
			    		@foreach($products as $product)
			    			<option value="{{ $product->id }}">{{ $product->product_name }}</option> 
			    		@endforeach

			    	</select>
			    	@error('product')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>

			    <div class="mb-3 col-5 ">
			    	<label for="qty" class="form-label">Qty*</label>
			    	<input type="number" class="form-control" id="qty" name="qty" value="{{ old('qty') }}"  >
			    	@error('qty')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>

			    <div class="col-1" ></div>
			</div>



			<div class="row">
				<div class="col-1"></div>
				<div class="mb-3 col-5  ">
				    	<label  for="is_payed" class=" d-block form-label">Payment Is complted?*</label>
			    	<div class="form-check form-check-inline " >	
				    	<input class="form-check-input" type="radio"  id="is_payed_yes" name="is_payed" value="1" >
				    	<label class="form-check-label" for="is_payed_yes">
						    Yes
						</label>
			    	</div>

				    <div class="form-check form-check-inline ">
				    	<input class="form-check-input" type="radio"  id="is_payed_no" name="is_payed" value="0" >
				    	<label class="form-check-label" for="is_payed_no">
						    No
						</label>
					</div>
					@error('is_payed')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
				</div>

				<div class="mb-3 col-5 ">
			    	<label for="payment_mode" class="form-label">Payment Mode*</label>
			    	<select name="payment_mode" name="payment_mode" class="form-select" >
			    		<option value="">Please select Payment Mode</option>
			    		<option value="cash">Cash</option>
			    		<option value="cash">online</option>
			    	</select>
			    	@error('payment_mode')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>	


			<div class="row">
				<div class="col-1" ></div>
				<div class="mb-3 col-10 ">
			    	<label for="transaction_no" class="form-label">Transaction No</label>
			    	<input type="text" class="form-control" id="transaction_no" name="transaction_no" value="{{ old('transaction_no')  }}" >
			    	@error('transaction_no')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1" ></div>
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

	<script src="{{asset('backend_asset/libs/form-repeater/repeater.min.js')}}"></script>

	<script type="text/javascript" charset="utf-8" >
		$('.select2-example').select2({
		});

		$('.repeater-1').repeater();

		
		$('#delivery_date,#purchase_date').daterangepicker({
		   singleDatePicker: true,
		   showDropdowns: true
		});	

		$(document).on('change','#user',function(){

			var id = $(this).val();

		

			$.ajax({
				type:'post',
				url:'{{ route('admin.order.ajax') }}',
				data:{'_token':'{{ csrf_token() }}','mode':'user_address_change','id':id},
				datatype:'json',
				success:function(response)
				{
					$('#deliveryAddress').html(response);
					$('#billingAddress').html(response);
				}
			})
		});
	</script>
@endsection