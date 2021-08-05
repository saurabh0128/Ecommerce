@extends('backend.layout.app')

@section('css')

	<!-- toaster css -->
    <link rel="stylesheet" href="{{URL::asset('backend_asset/css/toastr.css')}}" type="text/css">

@endsection

@section('content')

<div class="card m-3 ">
	<div class="card-body">	
		
		<form id="SettingForm" method="post"  action="{{ route('admin.setting.store') }}" enctype="multipart/form-data" >
			@csrf

			<div class="row">
				<div class="col-1"></div>
				<div class="col-10" >
					<div class="row">

						<div class="card-title text-center">General Setting</div>
						<hr>
						<div class="mb-3 col-12 ">
					    	<label for="home_title" class="form-label">Home Title* </label>
					    	<input type="text" class="form-control" id="home_title" name="home_title" value="{{ old('home_title',$AllSettingsData[array_search('home_title',array_column($AllSettingsData,'setting_name'))]['setting_value']) }}" autofocus >
					    	@error('home_title')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="home_desc" class="form-label">Home Description* </label>
					    	<textarea  class="form-control" id="home_desc" name="home_desc" >{{ old('home_desc',$AllSettingsData[array_search('home_desc',array_column($AllSettingsData,'setting_name'))]['setting_value']) }}  </textarea>
					    	@error('home_desc')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="logo" class="form-label">Logo* </label>
					    	<input type="file"  class="form-control" id="logo" name="logo" >
					    	@error('logo')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="card-title text-center">Email Setting</div>
						<hr>

						<div class="mb-3 col-12 ">
					    	<label for="email" class="form-label">Email* </label>
					    	<input type="email"  class="form-control" id="email" name="email" >
					    	@error('email')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>


				    	<div class="card-title text-center">Smtp Setting</div>
						<hr>

						<div class="mb-3 col-12 ">
					    	<label for="mail_driver" class="form-label">Mail Driver* </label>
					    	<input type="text"  class="form-control" id="mail_driver" name="mail_driver" >
					    	@error('mail_driver')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>


				    	<div class="mb-3 col-12 ">
					    	<label for="mail_host" class="form-label">Mail host* </label>
					    	<input type="text"  class="form-control" id="mail_host" name="mail_host" >
					    	@error('mail_host')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>


				    	<div class="mb-3 col-12 ">
					    	<label for="mail_port" class="form-label">Mail port* </label>
					    	<input type="number"  class="form-control" id="mail_port" name="mail_port" >
					    	@error('mail_port')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="mail_username" class="form-label">Mail UserName* </label>
					    	<input type="text"  class="form-control" id="mail_username" name="mail_username" >
					    	@error('mail_username')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="mail_password" class="form-label">Mail Password* </label>
					    	<input type="text"  class="form-control" id="mail_password" name="mail_port" >
					    	@error('mail_password')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="mail_encryption" class="form-label">Mail Encryption* </label>
					    	<input type="text"  class="form-control" id="mail_encryption" name="mail_encryption" >
					    	@error('mail_encryption')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="mail_address" class="form-label">Mail from Address* </label>
					    	<input type="email"  class="form-control" id="mail_address" name="mail_address" >
					    	@error('mail_address')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="mail_name" class="form-label">Mail from Name* </label>
					    	<input type="text"  class="form-control" id="mail_name" name="mail_name" >
					    	@error('mail_name')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="col-12 text-center ">
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

	 <!-- toaster js -->
    <script src="{{URL::asset('backend_asset/js/toastr.min.js')}}"></script>

    <script type="text/javascript">
    	 toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": false,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        }

        @if(Session::get('success'))      
            toastr["success"]("{{Session::get('success')}}")
        @endif
    </script>

@endsection