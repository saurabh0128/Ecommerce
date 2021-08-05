@extends('backend.layout.app')

@section('title')
Page Details
@endsection

@section('css')
@endsection

@section('content')

<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center ">Page Details </div>

		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Page Name</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{ $page->page_name }}  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Page Status</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">
		    	 {{ $page->page_status == 0?'Active':'Inactive' }}  
		    </div>
		    <div class="col-1"></div>
		</div>


		<div class="row">
			<div class="col-1"></div>
			<div class="col-2">
				<label for="product_image" class="form-label  ">Page Details</label>
			</div>	
			<div class="col-1">:</div>
		    <div class="mb-3 col-7 ">   
		    </div>
		    <div class="col-1"></div>
		</div>

		<div class="row">
			<div class="col-1"></div>
		    <div class="mb-3 col-10 ">
			    <textarea name="page_text" rows="5" cols="40" class="form-control ">{{ $page->page_text }}</textarea>   
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

