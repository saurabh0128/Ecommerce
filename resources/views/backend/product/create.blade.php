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
		<form id="AddProduct" method="post"  action="{{ route('admin.product.store') }}" enctype="multipart/form-data" >

			@csrf
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="product_name" class="form-label">Product Name* </label>
			    	<input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}" autofocus  >
			    	@error('product_name')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
			
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="current_price" class="form-label">Current Price*</label>
			    	<input type="number" class="form-control" id="current_price" name="current_price" step="any"  value="{{ old('current_price') }}"  >
			    	@error('current_price')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			   
			    <div class="mb-3 col-5 ">
			    	<label for="special_price" class="form-label">Special Price*</label>
			    	<input type="number" class="form-control" id="special_price" name="special_price" step="any" value="{{ old('special_price') }}" >
			    	@error('special_price')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="product_desc" class="form-label">Product Description*</label>
			    	<textarea class="form-control" id="product_desc" name="product_desc">{{old('product_desc')}}</textarea>
			    	@error('product_desc')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="product_sort_desc" class="form-label">Product Sort Description*</label>
			    	<textarea class="form-control" id="product_sort_desc" name="product_sort_desc">{{ old('product_sort_desc') }}</textarea>
			    	@error('product_sort_desc')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>


			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="Category" class="form-label">Category Name*</label>
			    	<select name="Category" name="Category" class="select2-example" >
			    		<option value="">Please select Category</option>
			    		@foreach($categorys as $category_detail)
			    			<option value="{{ $category_detail->id }}">{{ $category_detail->category_name }}</option>
			    		@endforeach
			    	</select>
			    	@error('Category')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			
			    <div class="mb-3 col-5 ">
			    	<label for="Seller" class="form-label">Seller Name*</label>
			    	<select name="Seller" name="Seller" class="select2-example" >
			    		<option value="">Please select Seller</option>
			    	@foreach($sellers as $seller_detail)	
			    		<option value="{{ $seller_detail->id }}">{{ $seller_detail->name }}</option>
			    	@endforeach	
			    	</select>
			    	@error('Seller')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5 ">
			    	<label for="product_image" class="form-label">Product Image*</label>
			    	<input type="file" class="form-control" id="product_image" name="product_image" >
			    	@error('product_image')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    
			    <div class="mb-3 col-5 ">
			    	<label for="stock" class="form-label">Total Stock*</label>
			    	<input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock')  }}" >
			    	@error('stock')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
			    </div>
			    <div class="col-1"></div>
			</div>
   

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-5  ">
				    	<label  for="is_display" class=" d-block form-label">Is Display?*</label>
			    	<div class="form-check form-check-inline " >	
				    	<input class="form-check-input" type="radio"  id="is_display_yes" name="is_display" value="0" >
				    	<label class="form-check-label" for="is_display_yes">
						    Yes
						</label>
			    	</div>

				    <div class="form-check form-check-inline ">
				    	<input class="form-check-input" type="radio"  id="is_display_no" name="is_display" value="1" >
				    	<label class="form-check-label" for="is_display_no">
						    No
						</label>
					</div>
					@error('is_display')
			    		<p class="text-danger">{{ $message }}</p>
			    	@enderror
				</div>
			
			    <div class="mb-3 col-5 ">
			    	<label for="is_avilable" class="d-block form-label">Is Avilable?*</label>	
			    	<div class="form-check form-check-inline " >
				    	<input class="form-check-input" type="radio"  id="is_avilable_yes" name="is_avilable" value="0" >
				    	<label class="form-check-label" for="is_avilable_yes">
						    Yes
						</label>
			    	</div>
			    

			    	<div class="form-check form-check-inline ">
				    	<input class="form-check-input" type="radio"  id="is_avilable_no" name="is_avilable" value="1" >
				    	<label class="form-check-label" for="is_avilable_no">
						    No
						</label>
					</div>
					@error('is_avilable')
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
		$('.select2-example').select2({
		});
	</script>

@endsection