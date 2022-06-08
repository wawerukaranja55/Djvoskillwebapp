
@extends('frontend.master')
@section('title','Confirm Mpesa Payment')
@section('content')
<div class="container">
    <section class="panel panel-default">
        <div class="panel-heading mt-5" style="text-align: center;"> 
            <h3 class="mb-2 panel-title">Confirm Mpesa Payment</h3> 
        </div>
        @if ($message=Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="panel-body">
            <form action="{{ route('confirm_transaction') }}" class="form-horizontal" role="form" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <!-- form-group // -->
                        <div class="form-group">
                            <label for="transaction_id" class=" control-label">Mpesa Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control text-white bg-dark" name="transaction_id" id="transaction_id" placeholder="Enter the Mpesa Code in the payment Message">
                            </div>
                        </div>

                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="col-sm-offset-9 col-sm-10">
                        <button type="submit" class="confirm_pay btn btn-primary">Confirm Transaction</button>
                    </div>
                </div> 
            </form>
        </div>    
    </section>
</div>
@endsection
