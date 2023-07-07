this is the registertaion page

@extends('frontend.master')
@section('title','Sign Up For An Account')
@section('content')
<div class="container">
    
    <section class="panel panel-default">
        <div class="panel-heading mt-5" style="text-align: center;"> 
            <h3 class="mb-2 panel-title">Pay With Mpesa</h3> 
        </div>
        
        <div class="panel-body">
            <form action="{{route('stkpush')}}" class="form-horizontal" role="form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <!-- form-group // -->
                        <div class="form-group">
                            <label for="product_discount" class=" control-label">Amount To Pay</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control text-white bg-dark" name="total_amount" id="total_amount" value="{{ Session::get('grand_total') }}">
                            </div>
                        </div>

                        <input type="text" class="form-control text-white bg-dark" name="user" id="user" value="{{ Auth::user() }}" hidden>

                        <div class="form-group">
                            <label for="merch_code" class=" control-label">Phone Number</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control text-white bg-dark" required name="phone_number" id="phone_number" placeholder="Phone Number To Charge Amount">
                            </div>
                        </div>

                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-9 col-sm-10">
                        <button type="submit" class="btn btn-primary">Upload Product Information</button>
                    </div>
                </div> 
            </form>
        </div>    
    </section>
</div>
@endsection



{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
