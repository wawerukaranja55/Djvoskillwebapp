
@extends('frontend.master')
@section('title','Mpesa Payment Success')
@section('content')
    <!-- Paypal Success Page -->
<div class="container" style="margin-top:5%;">
	<div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">YOUR PAYMENT HAS BEEN MADE SUCCESSFUL ON MPESA</h2>
            <p class="text-center">Your Payment of Ksh.<span class="font-weight-bold">{{ Session::get('grand_total') }} </span>has been paid successfully.Your order number is:<span class="font-weight-bold">{{ Session::get('order_id') }}</span></p>
            <center>
                <div class="btn-group" style="margin-top:50px;">
                    <a href="{{ url('thankyou') }}" class="btn btn-lg btn-warning">CONFIRM ORDER</a>
                </div>
            </center>
        </div>
	</div>
</div>
@endsection
