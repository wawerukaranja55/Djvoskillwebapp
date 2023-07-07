
@extends('frontend.master')
@section('title','Paypal Failed')
@section('content')
    <!-- Paypal Success Page -->
<div class="container" style="margin-top:5%;">
	<div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">YOUR PAYMENT HAS FAILED TO COMPLETE ON  
                @if ($paymentmethod=="MPESA")
                    MPESA
                @elseif (($paymentmethod=="PAYPAL"))
                    PAYPAL
                @endif</h2>
            <p class="text-center">Kindly have a look on the paypal details again</span></p>
        </div>
	</div>
</div>
@endsection
