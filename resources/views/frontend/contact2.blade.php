







@extends('frontend.master')
@section('title','Contact-Us')
@section('content')
<!-- container -->
	<div class="container" style="border: 2px solid black;">
		<div class="row">
			<div class="col-md-6">
				<div class="well-box">
					<h2>Contact us directly</h2>
					@if(Session::has('success'))
						<div class="alert alert-success">
							{{Session::get('success')}}
						</div>
					@endif
					<form action="{{ url('/contact') }}" method="POST" id="contactFormSendMail" class="form" >
						{{csrf_field()}}
						<!-- Text input-->
						<div class="form-group">
							<label class="control-label" for="name">Your Full Name
								<span class="required">*</span>
							</label>
							<input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control input-md {{ $errors->has('name') ? 'error' : '' }}" required>
							<!-- Error -->
							@if ($errors->has('name'))
							<div class="error">
								{{ $errors->first('name') }}
							</div>
							@endif
						</div>
						
						<!-- Text input-->
						<div class="form-group">
							<label class=" control-label" for="email">E-Mail <span class="required">*</span></label>
							<input name="email" type="email" value="{{ old('email') }}" class="form-control input-md {{ $errors->has('email') ? 'error' : '' }}" required>
							<!-- Error -->
							@if ($errors->has('email'))
							<div class="error">
								{{ $errors->first('email') }}
							</div>
							@endif
						</div>

						<!-- Text input-->
						{{-- <div class="form-group">
							<label class="control-label" for="phone">Your Phone Number
								<span class="required">*</span>
							</label>
							<input name="phone" type="number" placeholder="Your Phone Number" class="form-control input-md {{ $errors->has('phone') ? 'error' : '' }}" required>
							<!-- Error -->
							@if ($errors->has('phone'))
							<div class="error">
								{{ $errors->first('phone') }}
							</div>
							@endif
						</div> --}}
						
						<!-- Textarea -->
						<div class="form-group">
							<label class="  control-label" for="message">Message</label>
							<textarea class="form-control {{ $errors->has('message') ? 'error' : '' }}" rows="6" id="message" name="message">{{ old('messae') }}"</textarea>
							<!-- Error -->
							@if ($errors->has('message'))
							<div class="error">
								{{ $errors->first('message') }}
							</div>
							@endif
						</div>
						
						<!-- Button -->
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-lg">Submit</button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-6 contact-info">
				<div class="well-box">
					<ul class="listnone">
						<li class="address">
							<h2><i class="fa fa-map-marker"></i>Location</h2>
							<p>Ruiru Town,along Thika Road</p>
						</li>
						<li class="email">
							<h2><i class="fa fa-envelope"></i>E-Mail</h2>
							<p>Info@voskill.com</p>
						</li>
						<li class="call">
							<h2><i class="fa fa-phone"></i>Contact</h2>
							<p>+254702521351</p>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
@endsection