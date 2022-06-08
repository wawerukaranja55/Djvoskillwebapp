@extends('backend.adminmaster')
@section('title','Shipping Charge')
@section('content')
    <div class="content-wrapper">
        <h2 class="ml-3"> {{ $shippingdetails->id }}.{{ $shippingdetails->county }}</h2>
        <!-- Success message -->
        @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissable fade show" role="alert">
                {{Session::get('success_message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php Session::forget('success_message');?>
        @endif
        <form method="post" action="{{ url('admin/editshippingcharges/'.$shippingdetails->id) }}">
            @csrf
            <div class="form-group">
                <label>County</label>
                <input type="text" class="form-control disabled" readonly="" value="{{ $shippingdetails->county }}" id="county">
            </div>
            <div class="form-group">
                <label>Town</label>
                <input type="text" class="form-control disabled" readonly="" value="{{ $shippingdetails->town }}" id="town">
            </div>
            <div class="form-group">
                <label>Shipping Charges</label>
                <input type="text" class="form-control disabled" value="{{ $shippingdetails->shipping_charges }}" name="shipping_charges" id="shipping_charges">
            </div>

            <button type="submit" class="btn btn-dark">Update</button>
        </form>
        
    </div>
    
@endsection
