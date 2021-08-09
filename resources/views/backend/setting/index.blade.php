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

						<div class="card-title text-left">General Setting</div>
						<hr>
							<div class="mb-3 col-12 ">
					    	<label for="home_title" class="form-label">Home Title* </label>
					    	<input type="text" class="form-control" id="home_title" name="home_title" value="{{ old('home_title',SettingValue($AllSettingsData,'home_title')) }}" autofocus >
					    	@error('home_title')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-12 ">
					    	<label for="home_desc" class="form-label">Home Description* </label>
					    	<textarea  class="form-control" id="home_desc" name="home_desc" >{{ old('home_desc',SettingValue($AllSettingsData,'home_desc')) }}</textarea>
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


				    <div class="card-title text-left">Currency Setting</div>
						<hr>
							<div class="mb-3 col-6 ">
					    	<label for="currency" class="form-label">Currency </label>
					    	<select  class="form-control" id="currency" name="currency" >
					    		<option @if(old('currency',SettingValue($AllSettingsData,'currency')) == 'usd' )selected  @endif  value="usd">US Dollar</option>
					    		<option @if(old('currency',SettingValue($AllSettingsData,'currency')) == 'inr' )selected  @endif value="inr">Rupees</option>
					    	</select>
					    	@error('currency')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-6 ">
					    	<label for="currency_symbol_placement" class="form-label">Currency Symbol Placement  </label>
					    	<select  class="form-control" id="currency_symbol_placement" name="currency_symbol_placement" >
					    		<option @if(old('currency_symbol_placement',SettingValue($AllSettingsData,'currency_symbol_placement')) == 'before' )selected  @endif  value="before">Before</option>
					    		<option @if(old('currency_symbol_placement',SettingValue($AllSettingsData,'currency_symbol_placement')) == 'after' )selected  @endif value="after">After</option>
					    	</select>
					    	@error('currency_symbol_placement')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>					


				    <div class="card-title text-left">Email Setting</div>
						<hr>

						<div class="mb-3 col-12 ">
					    	<label for="email" class="form-label">Email  </label>
					    	<input type="email"  class="form-control" id="email" name="email" value="{{ old('email',SettingValue($AllSettingsData,'email')) }}" >
					    	@error('email')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>


				    <div class="card-title text-left">Smtp Setting</div>
						<hr>

						<div class="mb-3 col-6 ">
					    	<label for="mail_driver" class="form-label">Mail Driver </label>
					    	<input type="text"  class="form-control" id="mail_driver" name="mail_driver" value="{{ old('mail_driver',SettingValue($AllSettingsData,'mail_driver')) }}"  >
					    	@error('mail_driver')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>


				    	<div class="mb-3 col-6 ">
					    	<label for="mail_host" class="form-label">Mail Host </label>
					    	<input type="text"  class="form-control" id="mail_host" name="mail_host" value="{{ old('mail_host',SettingValue($AllSettingsData,'mail_host')) }}" >
					    	@error('mail_host')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>


				    	<div class="mb-3 col-6 ">
					    	<label for="mail_port" class="form-label">Mail Port </label>
					    	<input type="number"  class="form-control" id="mail_port" name="mail_port" value="{{ old('mail_port',SettingValue($AllSettingsData,'mail_port')) }}" >
					    	@error('mail_port')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-6 ">
					    	<label for="mail_username" class="form-label">Mail UserName </label>
					    	<input type="text"  class="form-control" id="mail_username" name="mail_username" value="{{ old('mail_username',SettingValue($AllSettingsData,'mail_username')) }}" >
					    	@error('mail_username')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-6 ">
					    	<label for="mail_password" class="form-label">Mail Password </label>
					    	<input type="text"  class="form-control" id="mail_password" name="mail_password" value="{{ old('mail_password',SettingValue($AllSettingsData,'mail_password')) }}" >
					    	@error('mail_password')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-6 ">
					    	<label for="mail_encryption" class="form-label">Mail Encryption </label>
					    	<input type="text"  class="form-control" id="mail_encryption" name="mail_encryption" value="{{ old('mail_encryption',SettingValue($AllSettingsData,'mail_encryption')) }}"  >
					    	@error('mail_encryption')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-6 ">
					    	<label for="mail_address" class="form-label">Mail From Address </label>
					    	<input type="email"  class="form-control" id="mail_address" name="mail_address" value="{{ old('mail_address',SettingValue($AllSettingsData,'mail_address')) }}" >
					    	@error('mail_address')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="mb-3 col-6 ">
					    	<label for="mail_name" class="form-label">Mail From Name </label>
					    	<input type="text"  class="form-control" id="mail_name" name="mail_name" value="{{old('mail_name',SettingValue($AllSettingsData,'mail_name')) }} " >
					    	@error('mail_name')
					    		<p class="text-danger">{{ $message }}</p>
					    	@enderror
				    	</div>

				    	<div class="card-title text-left">Payment Setting</div>
							<hr>	

							<div class="mb-3 col-12">
								<ul class="nav nav-tabs" id="myTab" role="tablist">
								  <li class="nav-item" role="presentation">
								  		<a class="nav-link active" id="cod-tab" data-bs-toggle="tab" href="#cod" role="tab" aria-controls="cod" aria-selected="true">COD</a>  
								  </li>

								  <li class="nav-item" role="presentation">
								    	<a class="nav-link" id="paypal-tab" data-bs-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false">Paypal</a>
								  </li>
								  
								  <li class="nav-item" role="presentation">
								    	<a class="nav-link" id="Stripe-tab" data-bs-toggle="tab" href="#Stripe" role="tab" aria-controls="Stripe" aria-selected="false">Stripe</a>
								  </li>
								</ul>

								<div class="tab-content" id="myTabContent">
								  
								  <div class="tab-pane fade show active m-3" id="cod" role="tabpanel" aria-labelledby="cod-tab">
								  		<div class="form-check form-switch">
								  				<label for="cod_active"  class="form-check-label" >Active</label>
								  				<input type="checkbox" @if(old('cod_active',SettingValue($AllSettingsData,'cod_active'))) checked @endif class="form-check-input" value="1"  name="cod_active" id="cod_active">
								  		</div>
								  </div>
								  
								  <div class="tab-pane fade m-3 " id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
								  		<div class="form-check form-switch mb-2">
								  				<label for="paypal_active"  class="form-check-label" >Active</label>
								  				<input type="checkbox" @if(old('paypal_active',SettingValue($AllSettingsData,'paypal_active'))) checked @endif  class="form-check-input" value="1"  name="paypal_active" id="paypal_active">
								  		</div>

								  		<div class="mb-2 row ">
								  			<div class="col-6 mode-center">
								  			
										    		<label class="form-check-label test-css " for="paypal_mode" >test  </label>
								  			  <div class="form-check form-switch ">							  				
										    		<input type="checkbox"  @if(old('paypal_mode',SettingValue($AllSettingsData,'paypal_mode'))) checked @endif   class="form-check-input " value="1"  id="paypal_mode" name="paypal_mode" >
										    		<label class="form-check-label" for="paypal_mode" >live </label>
										      </div>
								  			</div>
								  			<div class="col-6 ">
											    	<label for="paypal_app_id" class="form-label">app id </label>
											    	<input type="text" value="{{ old('paypal_app_id',SettingValue($AllSettingsData,'paypal_details')['app_id']) }}"  class="form-control form-control-sm" id="paypal_app_id" name="paypal_app_id">
										    </div>
								    	</div>
								    	
								    	<div class="mb-2 row">
								    			<div class="col-6 ">
											    	<label for="paypal_username" class="form-label">Username </label>
											    	<input type="text" value="{{ old('paypal_username',SettingValue($AllSettingsData,'paypal_details')['username']) }}"  class="form-control form-control-sm" id="paypal_username" name="paypal_username">
										    	</div>

										    	<div class="col-6 ">
											    	<label for="paypal_password" class="form-label">Password </label>
											    	<input type="text" value="{{ old('paypal_password',SettingValue($AllSettingsData,'paypal_details')['password']) }}" class="form-control form-control-sm" id="paypal_password" name="paypal_password">
										    	</div>
								    	</div>

								    	<div class="mb-2 row">
								    			<div class="col-6 ">
											    	<label for="paypal_secret" class="form-label">Secret </label>
											    	<input type="text" value="{{ old('paypal_secret',SettingValue($AllSettingsData,'paypal_details')['secret']) }}"  class="form-control form-control-sm" id="paypal_secret" name="paypal_secret">
										    	</div>

										    	<div class="col-6 ">
											    	<label for="paypal_certificate" class="form-label">certificate </label>
											    	<input type="text"  value="{{ old('paypal_certificate',SettingValue($AllSettingsData,'paypal_details')['certificate']) }}"  class="form-control form-control-sm" id="paypal_certificate" name="paypal_certificate">
										    	</div>
								    	</div>

								  </div>
								  
								  <div class="tab-pane fade m-3" id="Stripe" role="tabpanel" aria-labelledby="Stripe-tab">
								  		<div class="mb-2 row ">
								  			<div class="col-6 ">
											    	<div class="form-check form-switch mb-2">
											  				<label for="stripe_active"  class="form-check-label" >Active</label>
											  				<input type="checkbox" @if(old('stripe_active',SettingValue($AllSettingsData,'stripe_active'))) checked @endif class="form-check-input" value="1"  name="stripe_active" id="stripe_active">
											  		</div>
										    </div>	
								  			
								  			<div class="col-6 mode-center">
										    		<label class="form-check-label test-css " for="stripe_mode" >test  </label>
								  			  <div class="form-check form-switch ">							  				
										    		<input type="checkbox" @if(old('stripe_mode',SettingValue($AllSettingsData,'stripe_mode'))) checked @endif   class="form-check-input " value="1"  id="stripe_mode" name="stripe_mode" >
										    		<label class="form-check-label" for="stripe_mode" >live </label>
										      </div>
								  			</div>
								    	</div>

								    	<div class="mb-2 row">

								    			<div class="col-6 ">
											    	<label for="live_stripe_key" class="form-label">live Stripe Key </label>
											    	<input type="text" value="{{ old('live_stripe_key',SettingValue($AllSettingsData,'stripe_details')['live_stripe_key']) }}"  class="form-control form-control-sm" id="live_stripe_key" name="live_stripe_key">
										    	</div>

										    	<div class="col-6 ">
											    	<label for="live_stripe_secret_key" class="form-label">live secret </label>
											    	<input type="text"  class="form-control form-control-sm"  
                                                    value="{{ old('live_stripe_secret_key',SettingValue($AllSettingsData,'stripe_details')['live_secret_key']) }}"  id="live_stripe_secret_key" name="live_stripe_secret_key">
										    	</div>

								    	</div>

								    	<div class="mb-2 row">
								    			<div class="col-6 ">
											    	<label for="test_stripe_key" class="form-label">test Stripe Key </label>
											    	<input type="text" value="{{ old('test_stripe_key',SettingValue($AllSettingsData,'stripe_details')['test_stripe_key']) }}"  class="form-control form-control-sm" id="test_stripe_key" name="test_stripe_key">
										    	</div>

										    	<div class="col-6 ">
											    	<label for="test_stripe_secret_key" class="form-label">test secret </label>
											    	<input type="text" value="{{ old('test_stripe_secret_key',SettingValue($AllSettingsData,'stripe_details')['test_secret_key']) }}"  class="form-control form-control-sm" id="test_stripe_secret_key" name="test_stripe_secret_key">		
										    	</div>	
								    	</div>
								  </div>
								</div>

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