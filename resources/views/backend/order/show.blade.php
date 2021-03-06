@extends('backend.layout.app')

@section('css')
@endsection

@section('content')

<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Order Details</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">User Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->user->user_name}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Customer Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->customer_name}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		@if(isset($order->coupon->coupon_code))
		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Coupon code </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->coupon->coupon_code}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>
		@endif

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Purchase Date </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->purchase_date}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Delivery Date </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->delivery_date}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Purchase Status </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->purchase_status}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Delivery status </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->delivery_status}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-10">
				<p class="fs-5">Purchased Item</p>
				<hr class="my-4">
			</div>
		</div>


		@foreach($order->purchase_item as $purchase_item )
		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Product Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">      
		    	 <p>{{$purchase_item->product_name}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Product Description</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">      
		    	 <p>{{$purchase_item->product_desc}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>	

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Item  Qty</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">      
		    	 <p>{{$purchase_item->qty}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Price</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">      
		    	 <p>{{$purchase_item->price}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		@endforeach


		<div class="row">
			<div class="col-1"></div>
			<div class="col-10">
				<p class="fs-5">Price Details</p>
				<hr class="my-4">
			</div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Shipping Amount  </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->shipping_amt}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Total Amount </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->total_amt}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		

		<div class="row">
			<div class="col-1"></div>
			<div class="col-10">
				<p class="fs-5">Payment Details</p>
				<hr class="my-4">
			</div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label "> Payment Is complted  </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>@if($order->is_payed == 0) no @elseif($order->is_payed == 1) yes @endif </p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Payment Mode </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->payment_mode}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Transaction No</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->transaction_no}}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-10">
				<p class="fs-5">User Address Details</p>
				<hr class="my-4">
			</div>
		</div>
		

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Address </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->user_address->address_line_1 . " ". $order->user_address->address_line_2   }}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Ladmark </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->user_address->landmark }}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Pincode</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->user_address->pincode }}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">City Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->user_address->city->city_name }}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>



		<div class="row">
			<div class="col-1"></div>
			<div class="col-10">
				<p class="fs-5">Billing Address Details</p>
				<hr class="my-4">
			</div>
		</div>



		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Address </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->billing_address->address_line_1 . " ". $order->billing_address->address_line_2   }}</p> 
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Ladmark </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->billing_address->landmark }}</p> 
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Pincode </label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->billing_address->pincode }}</p> 
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">City Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <p>{{$order->user_address->city->city_name }}</p>  
		    </div>
		    <div class="col-1"></div>
		</div>


	</div>
</div>

@endsection

@section('js')
@endsection

