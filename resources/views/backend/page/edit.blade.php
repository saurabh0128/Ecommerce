@extends('backend.layout.app')


@section('title')
Page Edit
@endsection


@section('css')
@endsection


@section('content')
<div class="card m-3 ">
	<div class="card-body">	
		<div class="card-title text-center">Edit Page Form </div>
		<form id="AddProduct" method="post"  action="{{ route('admin.page.store') }}" enctype="multipart/form-data" >
			@method('PUT')
			@csrf
			<div class="row">
				<div class="col-1"></div>	
			    <div class=" col-10 ">
			    	<div class="mb-3" >
				    	<label for="page_name" class="form-label">Page Name* </label>
				    	<input type="text" class="form-control" id="page_name" name="page_name" value="{{ old('page_name',$page->page_name) }}" autofocus  >
				    	@error('page_name')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
			    	</div>
			    	
			    	<div class="mb-3  ">
				    	<label  for="is_active" class=" d-block form-label">Is Active?*</label>
				    	<div class="form-check form-check-inline " >	
					    	<input class="form-check-input" type="radio"  id="is_active_yes" name="is_active" value="0" 
					    	@if(old('is_active') ==0) checked @endif >
					    	<label class="form-check-label" for="is_active_yes"    >
							    Yes
							</label>
				    	</div>

					    <div class="form-check form-check-inline ">
					    	<input class="form-check-input" type="radio"  id="is_active_no" name="is_active" value="1"
					    	@if(old('is_active') ==1) checked @endif  >
					    	<label class="form-check-label" for="is_active_no">
							    No
							</label>
						</div>
						@error('is_active')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
					</div>

					<div class="mb-3 ">
						<label for="page_text" class="form-label">Page text* </label>
							 <textarea name="page_text" rows="5" cols="40" class="form-control tinymce-editor">{{ $page->page_text }}</textarea>
						</div>

						@error('page_text')
				    		<p class="text-danger">{{ $message }}</p>
				    	@enderror
					</div>
					<div class="text-center" >	
			    		<button type="submit" class="btn btn-primary">Submit</button>
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
    

    <script type="text/javascript">
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
                "insertdatetime media table  paste imagetools"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i'
            ],
            image_title: true,
            automatic_uploads: true,
            images_upload_url: '{{route('admin.page.image_upload')}}',
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                };
                input.click();
            }
        });
    </script>

@endsection