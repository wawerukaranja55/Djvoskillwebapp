
@extends('frontend.master')
@section('title','paypal success')
@section('content')
    <!-- Paypal Success Page -->
<div class="container" style="margin-top:5%;">
	<div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">Thank You For Shopping at DJ Voskill Website</h2>
            <p class="text-center">Your Order is has been shipped and will be delivered within 7 days.</p>
            <center>
                <div class="btn-group" style="margin-top:50px;">
                    <a href="#clientprofile" class="btn btn-lg btn-warning">Order Status</a>
                </div>
            </center>
            {{-- <p class="text-center">You will receive an order confirmation email with details of your order and a link to track your process.</p> --}}
            <center>
                <div class="btn-group" style="margin-top:50px;">
                    <a href="#clientprofile" class="btn btn-lg btn-warning">Order Status</a>
                </div>
            </center>
        </div>
	</div>
</div>
@endsection
