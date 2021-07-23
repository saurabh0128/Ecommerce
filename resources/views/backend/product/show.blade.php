@extends('backend.layout.app')

@section('title')
Product Details	
@endsection

@section('css')
@endsection



@section('content')
<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center ">Product Details </div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Product Image</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <img src="{{asset('backend_asset/product_images/'.$product->product_img)}}" alt="product images" width="200" height="150" name="product_image" >  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="product_name" class="form-label">Product Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->product_name}}  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="current_price" class="form-label">Product Current Price</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->current_price}}  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="special_price" class="form-label">Product Special Price</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->special_price}}  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="Category Name" class="form-label">Category Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->category->category_name}}  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="Category Name" class="form-label">Seller Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->user->name}}  
		    </div>
		    <div class="col-1"></div>
		</div>



		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="product_stock" class="form-label">Product Stock</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->stock}}  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="product_stock" class="form-label">Is avilable</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 
		    	 @if($product->is_avilable == 0)
		    	  <p>yes</p>
		    	 @else
		    	 <p>no</p>
		    	 @endif   
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="product_stock" class="form-label">Is display</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 
		    	 @if($product->is_display == 0)
		    	  <p>yes</p>
		    	 @else
		    	 <p>no</p>
		    	 @endif   
		    </div>
		    <div class="col-1"></div>
		</div>



		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="product_sort_desc" class="form-label">Product Sort Description</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->product_sort_desc}}  
		    </div>
		    <div class="col-1"></div>
		</div>



			
		<div class="row">
			<div class="col-1" ></div>
			<div class="col-2">
				<label for="product_long_desc" class="form-label">Product Long Description</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{$product->product_desc}}  
		    </div>
		    <div class="col-1"></div>
		</div>	

	</div>
</div>
@endsection

@section('js')
@endsection