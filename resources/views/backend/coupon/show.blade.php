@extends('backend.layout.app')


@section('title')
coupon Details
@endsection

@section('css')
@endsection

@section('content')

<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Coupon Details</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Copon Code</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->coupon_code}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Copon Discount</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->coupon_discount}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Discount Type</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->discount_type}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Coupon Type</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->coupon_type}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Start Date</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->start_date}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">End Date</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->end_date}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Total Uses</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->total_uses}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Coupon Details</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$coupon->coupon_details}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

	</div>
</div>		
@endsection

@section('js')
@endsection