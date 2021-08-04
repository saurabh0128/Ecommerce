@extends('backend.layout.app')


@section('title')
Slide Create
@endsection

@section('css')

	<!-- CSS -->
	<link rel="stylesheet" href="{{asset('backend_asset/libs/datepicker/daterangepicker.css')}}" type="text/css">

@endsection

@section('content')
<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Add Slide Form </div>
		<form id="AddProduct" method="post"  action="{{ route('admin.slide.store') }}" enctype="multipart/form-data" >

			@csrf
			<div class="row">
				<div class="col-1"></div>	
			    <div class=" col-10 ">
			    <div class="row">
			    		
			    	<div class="mb-3 col-6 " >
				    	<label for="slide_image" class="form-label">Slide Image* </label>
				    	<input type="file" class="form-control" id="slide_image" name="slide_image" 
				    	 autofocus  >
				    	@error('slide_image')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
			    	</div>

			    	<div class="mb-3 col-6 ">
				    	<label  for="slide_status" class=" d-block form-label">Is Active?*</label>
				    	<div class="form-check form-check-inline " >	
					    	<input class="form-check-input" type="radio"  id="is_active_yes" name="slide_status" value="0" >
					    	<label class="form-check-label" for="is_active_yes">
							    Yes
							</label>
				    	</div>

					    <div class="form-check form-check-inline ">
					    	<input class="form-check-input" type="radio"  id="is_active_no" name="slide_status" value="1" >
					    	<label class="form-check-label" for="is_active_no">
							    No
							</label>
						</div>
						@error('slide_status')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
					</div>


					<div class="mb-3  " >
				    	<label for="slide_url" class="form-label">Slide link* </label>
				    	<input type="url" class="form-control" id="slide_url" name="slide_url" 
				    	 autofocus  >
				    	@error('slide_url')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
			    	</div>

			    	<div class="mb-3 col-6" >
				    	<label for="start_date" class="form-label">Start Date* </label>
				    	<input type="text" class="form-control datepicker " id="start_date" name="start_date" 
				    	 autofocus  >
				    	@error('start_date')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
			    	</div>

			    	<div class="mb-3 col-6 " >
				    	<label for="end_date" class="form-label">End Date* </label>
				    	<input type="text" class="form-control datepicker " id="end_date" name="end_date" 
				    	 autofocus  >
				    	@error('end_date')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
			    	</div>

			    
					<div class="mb-3 ">
						<label for="slide_text" class="form-label">Slide text* </label>
							 <textarea name="slide_text" rows="5" cols="40" class="form-control tinymce-editor"></textarea>
						</div>

						@error('slide_text')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
					</div>
					<div class="text-center" >	
			    		<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>	
			    </div>
			    <div class="col-1"></div>
			</div>

		</form>
	</div>
</div>
@endsection

@section('js')

	<script src="https://cdn.tiny.cloud/1/9hnavwj4cyi9vnisupkhq5ap4khtaciobugrmynzsirbomw9/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    
    <!-- Javascript -->
	<script src="{{asset('backend_asset/libs/datepicker/daterangepicker.js')}}"></script>

    <script type="text/javascript">

    	$('.datepicker').daterangepicker({
		   singleDatePicker: true,
		   showDropdowns: true
		});

	  tinymce.init({
            selector: 'textarea',
            height: 500,
            setup: function (editor) {
                editor.on('init change', function () {
                    editor.save();
                });
            },
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table  paste "
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent ",
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
            ]
        });
    </script>

@endsection

