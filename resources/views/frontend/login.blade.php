
@extends('frontend.master')
@section('title','Login')
@section('content')
<div class="container">
    <!-- Start User Area -->
		<section class="user-area-style log-in-style ptb-100">
			<div class="container">
				<div class="contact-form-action">
					<div class="account-title">
						<h2>Log in</h2>
					</div>

					@if(Session::has('error_message'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

					<form id="loginform" method="post" action="{{ url('signin') }}">
						@csrf
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="text" name="email">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label>Password</label>
									<input class="form-control" type="password" name="password">
								</div>
							</div>

							<div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="current_page" value="{{ Request::getRequestUri() }}">
                                </div>
                            </div>

							<div class="col-12">
								<div class="login-action">
									{{-- <span class="log-rem">
										<input id="remember" type="checkbox">
										<label for="remember">Remember me!</label>
									</span> --}}
									
									<span class="forgot-login">
										<a href="recover-password.html">Forgot your password?</a>
									</span>
								</div>
							</div>

							<div class="col-12">
								<button class="default-btn" type="submit">
									<span>Log In</span>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!-- End User Area -->
</div>
@endsection

@section('loginpagescripts')
    <script type="text/javascript">
        $(document).ready(function(){
           // validate signup form on keyup and submit
            $("#loginform").validate({
                rules: {
                    email: "required",
                    password: {
                        required: true,
                        minlength: 5
                    }
                },
                messages: {
                    name: "Please enter your Email",
                    email: {
                        required: "Please provide your Valid Email Address"
                    },
                    password: {
                        required: "Please provide Your Account password",
                        minlength: "Your password is Invalid"
                    },
                }
            }); 
        });
    </script>
@stop
