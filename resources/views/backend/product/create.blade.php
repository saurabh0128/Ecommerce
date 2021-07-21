@extends('backend.layout.app')

@section('title')
Add Product
@endsection

@section('css')

	<link rel="stylesheet" href="{{ asset('backend_asset/libs/select2/css/select2.min.css')}}" type="text/css">

@endsection


@section('content')


<div class="card ">
	<div class="card-body">	
		<div class="card-title text-center">Add Product Form </div>
		<form id="AddProduct">
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="product_name" class="form-label">Product Name</label>
			    	<input type="text" class="form-control" id="product_name" name="product_name" >
			    </div>
			    <div class="col-1"></div>
			</div>
			
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="current_price" class="form-label">Current Price</label>
			    	<input type="text" class="form-control" id="current_price" name="current_price" >
			    </div>
			    <div class="col-1"></div>
			</div>  
			
			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="special_price" class="form-label">Special  Price</label>
			    	<input type="text" class="form-control" id="special_price" name="special_price" >
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="Category" class="form-label">Category Name</label>
			    	<select name="Category" name="Category" class="select2-example" >
			    		<option value="0">electronic</option>
			    		<option value="1">Smart phone</option>
			    	</select>
			    </div>
			    <div class="col-1"></div>
			</div>

			<div class="row">
				<div class="col-1"></div>	
			    <div class="mb-3 col-10 ">
			    	<label for="Seller" class="form-label">Seller Name</label>
			    	<select name="Seller" name="Seller" class="select2-example" >
			    		<option value="0">electronic</option>
			    		<option value="1">Smart phone</option>
			    	</select>
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
		    placeholder: 'Select'
		});
	</script>

@endsection