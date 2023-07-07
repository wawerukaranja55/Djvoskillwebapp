
@extends('frontend.master')
@section('title','Forgot Password')
@section('content')
<div class="container">
    <!-- Start User Area -->
		<section class="user-area-style log-in-style ptb-100">
			<div class="container">
				<div class="contact-form-action">
					<div class="account-title">
						<h2>Reset Password</h2>
					</div>

					@if(Session::has('error_message'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

					<form id="frgtpassform" method="post" action="{{ url('forgotpassord') }}">
						@csrf
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label>Email</label>
									<input class="form-control" type="text" name="email">
								</div>
							</div>

							<div class="col-12">
								<button class="default-btn" type="submit">
									<span>Submit</span>
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

@section('frgtpasswordpagescripts')
    <script type="text/javascript">
        $(document).ready(function(){
           // validate signup form on keyup and submit
            $("#frgtpassform").validate({
                rules: {
                    email: "required"
                },
                messages: {
                    name: "Please enter your Email",
                    email: {
                        required: "Please provide your Valid Email Address"
                    }
                }
            }); 
        });
    </script>
@stop
