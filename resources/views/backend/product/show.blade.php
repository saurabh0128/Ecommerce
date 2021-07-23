@extends('backend.layout.app')

@section('title')
Product Details	
@endsection

@section('css')
@endsection



@section('content')
<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Product Details </div>

	
			

		@foreach($productdata as $product_item)
		<div class="row">
			<div class="col-1" ></div>
			<div class="col-1">
				<label for="product_name" class="form-label">User Profile</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-8 ">
		    	 {{-- $product_item->product_name  --}}
		    </div>
		    <div class="col-1"></div>
		</div>
		@endforeach

	</div>
</div>
@endsection

@section('js')
@endsection