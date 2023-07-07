
@extends('frontend.master')
@section('title','Register')
@section('content')
<div class="container">
    <!-- Start User Area -->
		<section class="user-area-style log-in-area ptb-100">
			<div class="container">
				<div class="contact-form-action">
					<div class="account-title">
						<h2>Registration</h2>
					</div>
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
					<form method="post" action="{{ url('/signup') }}" id="registerform">
                        @csrf
						<div class="row">
                            <div class="col-12">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input class="form-control" type="text" name="first_name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input class="form-control" type="text" name="last_name">
                                    </div>
                                </div>
                            </div>

							<div class="col-12">
								<div class="form-group">
									<label>Email address</label>
									<input class="form-control" type="email" name="email">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label>Mobile no.</label>
									<input class="form-control" type="text" name="phone">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label>Password</label>
									<input class="form-control" type="text" name="password">
								</div>
							</div>

                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="current_page" value="{{Request::getRequestUri()}}">
                                </div>
                            </div>

							<div class="col-12">
								<div class="row align-items-center">
									<div class="col-lg-6 col-sm-6">
										<button class="default-btn register" type="submit">
											<span>Register Now</span>
										</button>
									</div>

									<div class="col-lg-6 col-sm-6">
										<div class="right">
											<input id="remember-1" type="checkbox">
											<label>Show password ?</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!-- End User Area -->
</div>
@endsection

@section('registerpagescripts')
    <script type="text/javascript">
        $(document).ready(function(){
            
           // validate signup form on keyup and submit
            $("#registerform").validate({
                rules: {
                    name: "required",
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength:13,
                        digits:true
                    },
                    email: {
                        required: true,
                        email: true,
                        remote:"/check_email"
                    },
                    password: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    name: "Please enter your Full Name",
                    phone: {
                        required: "Please enter your Phone Number",
                        minlength: "Your Phone Number must consist of at least 10 characters",
                        maxlength: "Your Phone Number should not exceed 10 characters",
                        digits: "Please Enter a Valid Phone Number"
                    },
                    email: {
                        required: "Please provide your Email Address",
                        email: "Please Enter your Valid Email Address",
                        remote: "The Email is already taken"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 5 characters long"
                    },
                }
            }); 
        });
    </script>
@stop
