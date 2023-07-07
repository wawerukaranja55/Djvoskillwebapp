
@extends('frontend.master')
@section('title','Pay With Paypal')
@section('content')
    <!-- Paypal Page Start -->
<p>Click the button below to pay the grand total</p>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="sb-ah17j8265266@business.example.com">
        <input type="hidden" name="item_name">
        <input type="hidden" name="email">
        <input type="hidden" name="first_name">
        <input type="hidden" name="last_name">
        <input type="hidden" name="county">
        <input type="hidden" name="town">
        {{-- <input type="hidden" name="item_number" value=" "> --}}
        <input type="hidden" name="amount">
        <input type="hidden" name="no_shipping" value="1">
        <input type="hidden" name="no_note" value="1">
        <input type="hidden" name="currency_code" value="USD">
        {{-- <input type="hidden" name="upload" value="1"> --}}
        <input type="hidden" name="lc" value="US">
        <input type="hidden" name="return" value="{{ url('payment/success') }}">
        <input type="hidden" name="cancel_return" value="{{ url('paypal/fail') }}">
        {{-- <input type="hidden" name="bn" value=" "> --}}
        <input type="image" src="https://www.paypal.com/en_AU/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
        <img alt="" border="0" src="https://www.paypal.com/en_AU/i/scr/pixel.gif" width="1" height="1">
    </form>
@endsection
