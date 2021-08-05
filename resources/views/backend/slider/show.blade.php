@extends('backend.layout.app')


@section('title')
Slide Details
@endsection

@section('css')

@endsection


@section('content')
<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center ">Slide Details </div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Slide Image</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 <img src="{{asset('backend_asset/slide_images/'.$slider->slide_image)}}" height="100" width="500">  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Slide Status</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{ $slider->slide_status == 0?'Active':'Inactive' }}  
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Slide Link</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 "> 
		    	<a href="{{ $slider->slide_link }}" title="">{{ $slider->slide_link }}</a>  
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
		    	{{ $slider->start_date }}
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
		    	{{ $slider->end_date }}   
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Slide Text</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">   
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
		    <div class="mb-3 col-10 ">
			    <textarea name="page_text" rows="5" cols="40" class="form-control ">{{ $slider->slide_text }}</textarea>   
		    </div>
		    <div class="col-1"></div>
		</div>
		

	</div>
</div>
@endsection

@section('js')

	<script src="https://cdn.tiny.cloud/1/9hnavwj4cyi9vnisupkhq5ap4khtaciobugrmynzsirbomw9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


	 <script type="text/javascript">
	 	tinymce.init({
            selector: 'textarea',
            readonly:true,
            height: 500
        });
	 </script>

@endsection


