
@extends('frontend.master')
@section('title','My Checkout')
@section('content')
    <!-- Checkout Page Start -->
    <?php use App\Models\Merchadise; ?>
    <?php use App\Models\Cart; ?> 
        <!-- checkout-area start -->
        <section class="checkout-area pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7">
                        <div class="checkbox-form">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    <div>{{$error}}</div>
                                @endforeach
                            @endif

                            <!-- Success message -->
                            @if(Session::has('success_message'))
                            <div class="alert alert-success">
                                {{Session::get('success_message')}}
                            </div>
                            @endif

                            <div id="checkout">
                                <section id="tabs" class="project-tab">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if (($userid === 0) && ($orderplaced_status[0] === "not_placed"))
                                                <nav>
                                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                        <a class="nav-item nav-link billing-tab active" id="billing_details-tab" 
                                                            data-toggle="tab" href="#billing_details" role="tab" aria-controls="billing_details" aria-selected="true">
                                                            <span id="billingdetails">1.</span>Billing and Shipping Details
                                                        </a>

                                                        <a class="nav-item nav-link order-tab disabled" id="place-order-tab"
                                                            data-toggle="tab" href="#place-order" role="tab" aria-controls="place-order" aria-selected="false">
                                                            <span class="placeorder">2.</span>Place Order
                                                        </a>

                                                        <a class="nav-item nav-link pay-tab disabled" id="payments-tab" 
                                                            data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
                                                            <span id="makepayments">3.</span>Make Payment
                                                        </a>
                                                    </div>
                                                </nav>
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show active" id="billing-details" role="tabpanel" aria-labelledby="billing_details-tab">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div style="margin: 5px auto; text-align:center; padding:5px;">
                                                                    <span>Returning customer?
                                                                        <a href="#" id="customer_login_here" style="margin-left:10px; ">Login here</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                                                    <h4>1.BILLING DETAILS</h4>
                                                                    <form method="post" id="billingform" class="form">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>First Name <span class="required">*</span></label>
                                                                                    <input type="text" placeholder="First Name" name="first_name" class="form-control input-md {{ $errors->has('first_name') ? 'error' : '' }}" required/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Last Name <span class="required">*</span></label>
                                                                                    <input type="text" placeholder="Last Name" name="last_name" class="form-control input-md {{ $errors->has('last_name') ? 'error' : '' }}" required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Company Name<span>(optional)</span></label>
                                                                                    <input type="text" placeholder="Your Company Name" name="company_name" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Phone <span class="required">*</span></label>
                                                                                    <input type="text" placeholder="Phone Number to Use For Paying" name="phone" class="form-control input-md {{ $errors->has('phone') ? 'error' : '' }}" required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Email Address</label>
                                                                                    <input type="email" placeholder="Email Address to Use For Paying" name="email" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="country-select">
                                                                                    <label>County <span class="required">*</span></label>
                                                                                    <select id="cty_id" class="county form-control frontselect2" name="countyname">
                                                                                        <option value="0" disabled="true" selected="true">Choose Your County</option>
                                                                                            @foreach($delivaddresses as $address)
                                                                                                <option value="{{ $address->id }}">{{ $address->county }}</option>
                                                                                            @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Town / City <span class="required">*</span></label>
                                                                                    <select class="town form-control frontselect2" name="cityname">
                                                                                        <option value=" " disabled="true" selected="true">Select Your City</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Pick Up Point <span class="required">*</span></label>
                                                                                    <input type="text" name="street_address" class="pickup_point form-control input-md" readonly value=" " />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>price <span class="required">*</span></label>
                                                                                    <input type="text"name="shipping_amount" class="shippingprice_amount form-control input-md" readonly value=" " />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Password</label>
                                                                                    <input class="form-control" placeholder="Write Your Password Here" required type="password" name="password" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                                                        <button type="submit" class="btn btn-dark btn-block">Proceed</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show" id="place-order" role="tabpanel" aria-labelledby="place-order-tab">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                                                    <h4>2.PLACE ORDER</h4>
                                                                    
                                                                    <form class="coupon" id="applycoupon" method="POST" action="javascript:void(0);" couponuser>
                                                                        @csrf
                                                                        <h5>Do You have a Coupon Voucher?Redeem it here to get the discount </h5>
                                                                        <input type="number" name="total_amount" class="form-control input-md grand_amount_to_pay" readonly />
                                                                        {{-- <input name="total_amount" class="grand_amount_to_pay"> --}}
                                                                        {{-- <input name="user_id" value="" class="shipping_amount_to_pay" readonly> --}}
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Coupon Code</label>
                                                                                    <input type="text" name="couponcode" placeholder="Enter The Coupon code" class="form-control input-md" id="couponcode" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                                                        <button type="submit" id="applycouponbtn" class="btn btn-secondary">Apply Coupon</button>
                                                                    </form>

                                                                    <form method="post" id="place_order_form" class="form">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <h4>Order Details</h4>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Grand Amount To Pay</label>
                                                                                            <input type="number" name="grand_amount" class="form-control input-md grand_amount_to_pay" readonly />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Coupon Amount</label>
                                                                                            <input type="number" 
                                                                                            value="@if (session()->has('couponAmount'))
                                                                                                        {{ Session::get('couponAmount') }}
                                                                                                    @else
                                                                                                        0
                                                                                                    @endif" 
                                                                                            name="coupon_amount" class="form-control input-md" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Shipping Charges</label>
                                                                                            <input type="number" name="shipping_amount" class="form-control input-md order-shipping-charges" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
        
                                                                                <div class="row">
                                                                                    <div class="col-md-4">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>County</label>
                                                                                            <input type="text" class="form-control input-md order-shipping-county" readonly name="county_order" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Town</label>
                                                                                            <input type="text" class="form-control input-md order-shipping-town" readonly name="town_order" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-4">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Pick Up Station</label>
                                                                                            <input type="text" class="form-control input-md order-pickup-station" readonly name="pickup_order" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                            <div class="col-md-4">
                                                                                <h4>Select Your Payment Method</h4>
                                                                                <input type="hidden" name="orderuserid" class="orderuser_id" value=" " />
                                                                                @foreach($payment_methods as $payment_method)
                                                                                    <p>
                                                                                        <input type="radio" id="test1" value="{{ $payment_method->payment_name}}" name="payment_method" class="{{ $errors->has('payment_name') ? 'error' : '' }}" required >
                                                                                        <label for="test1">{{ $payment_method->payment_name}}</label>
                                                                                    </p>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-dark btn-block">Place Order</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                                                        <div class="row">
                                                            <p id="msg" style="font-size: 17px;"></p>
                                                            <p id="order_paid_msg" class="d-none" style="font-size: 17px;"></p>
                                                            <div class="col-md-12"  id="mode_of_payment">
                                                                <input type="hidden" name="order_payment_mode" class="orderpayment_mode" value=" " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                            @elseif (($userid > 0) && ($orderplaced_status[0] === "not_placed"))
                                                <nav>
                                                    <div class="nav nav-tabs nav-fill " id="nav-tab" role="tablist">
                                                        <a class="nav-item nav-link billing-tab disabled " id="billing_details-tab" 
                                                            data-toggle="tab" href="#billing_details" role="tab" aria-controls="billing_details" aria-selected="true">
                                                            <span id="billingdetails">1.</span>Billing and Shipping Details
                                                        </a>

                                                        <a class="nav-item nav-link active confirm-tab" id="payments-tab"
                                                            data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
                                                            <span class="payments">2.</span>Place Order
                                                        </a>
                                                        <a class="nav-item nav-link paid-tab disabled" id="place-order-tab" 
                                                            data-toggle="tab" href="#place-order" role="tab" aria-controls="place-order" aria-selected="false">
                                                            <span id="rentpaid">3.</span>Make Payment</a>
                                                    </div>
                                                </nav>
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show" id="billing-details" role="tabpanel" aria-labelledby="billing_details-tab">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                                                    <h4>1.BILLING DETAILS</h4>
                                                                    <form method="post" id="billingform" class="form">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>First Name <span class="required">*</span></label>
                                                                                    <input type="text" placeholder="First Name" name="first_name" class="form-control input-md {{ $errors->has('first_name') ? 'error' : '' }}" required/>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Last Name <span class="required">*</span></label>
                                                                                    <input type="text" placeholder="Last Name" name="last_name" class="form-control input-md {{ $errors->has('last_name') ? 'error' : '' }}" required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Company Name<span>(optional)</span></label>
                                                                                    <input type="text" placeholder="Your Company Name" name="company_name" />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Phone <span class="required">*</span></label>
                                                                                    <input type="text" placeholder="Your Phone Number" name="phone" class="form-control input-md {{ $errors->has('phone') ? 'error' : '' }}" required/>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Email Address</label>
                                                                                    <input type="email" placeholder="Type Your Email Here" name="email" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="country-select">
                                                                                    <label>County <span class="required">*</span></label>

                                                                                    <select id="cty_id" class="county form-control frontselect2" required name="countyname">
                                                                                        <option value="0" disabled="true" selected="true">Choose Your County</option>
                                                                                            @foreach($delivaddresses as $address)
                                                                                                <option value="{{ $address->id }}">{{ $address->county }}</option>
                                                                                            @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Town / City <span class="required">*</span></label>
                                                                                    <select class="town form-control frontselect2" required name="cityname">
                                                                                        <option value=" " disabled="true" selected="true">Select Your City</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>Pick Up Point <span class="required">*</span></label>
                                                                                    <input type="text" name="street_address" class="pickup_point form-control input-md" value=" " />
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="checkout-form-list">
                                                                                    <label>price <span class="required">*</span></label>
                                                                                    <input type="text"name="shipping_amount" class="shippingprice_amount form-control input-md" value=" " />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Password</label>
                                                                                    <input class="form-control" placeholder="Write Your Password Here" required type="password" name="password" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                                                        <button type="submit" class="btn btn-dark btn-block">Proceed</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show active" id="place-order" role="tabpanel" aria-labelledby="place-order-tab">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                                                    <h4>2.PLACE ORDER</h4>
                                                                    <form class="form" id="applycoupon" method="post" action="javscript:void;"
                                                                        @if(Auth::check())
                                                                            couponuser="1"
                                                                        @endif>
                                                                        @csrf
                                                                        <h5>Do You have a Coupon Voucher?Redeem it here to get the discount </h5>
                                                                        <input name="total_amount" class="grand_amount_to_pay" readonly>
                                                                        {{-- @if (($userid > 0) && ($deliveriesdata === null))
                                                                            <input name="shipping_amount" class="shipping_amount_to_pay" placeholder="Your Shipping Amount">
                                                                        @else
                                                                            <input name="shipping_amount" value={{ $deliveriesdata->shipping_cost }} class="shipping_amount_to_pay" readonly>
                                                                        @endif --}}
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="checkout-form-list">
                                                                                    <input type="text" name="couponcode" placeholder="Enter The Coupon code" style="text-align: center; background-color:black;color:white;" class="form-control input-md" id="couponcode" required />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                                                        <button type="submit" id="applycouponbtn" class="btn btn-secondary">Apply Coupon</button>
                                                                    </form>
                                                                    <form method="post" id="place_order_form" class="form" style="margin-top: 20px;">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-md-8">
                                                                                <h4>Order Details</h4>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Grand Amount To Pay</label>
                                                                                            <input type="text" name="grand_amount" value="" class="form-control input-md grand_amount_to_pay" readonly />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <input id="coupon_discount_code" type="hidden" name="coupon_discount_code" class="form-control input-md" readonly/>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Company Name<span>(optional)</span></label>
                                                                                            <input type="text" placeholder="Your Company Name" name="company_name" />
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Coupon Amount</label>
                                                                                            <input id="coupon_total" type="number" value="0"
                                                                                            name="coupon_amount" class="form-control input-md" readonly/>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="country-select">
                                                                                            @if (($userid > 0) && ($deliveriesdata === null))
                                                                                                <select id="cty_id" class="county form-control frontselect2" required name="countyname">
                                                                                                    <option value="0" disabled="true" selected="true">Choose Your County</option>
                                                                                                        @foreach($delivaddresses as $address)
                                                                                                            <option value="{{ $address->id }}">{{ $address->county }}</option>
                                                                                                        @endforeach
                                                                                                </select>
                                                                                            @else
                                                                                                {{-- <input type="number" value={{ $deliveriesdata->shipping_cost }} name="shipping_amount" class="form-control input-md order-shipping-charges" readonly/> --}}
                                                                                                <input type="text" value={{ $deliveriesdata->shipcharges->county }} class="form-control input-md order-shipping-county" readonly name="county_order" />
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Town / City <span class="required">*</span></label>
                                                                                            @if (($userid > 0) && ($deliveriesdata === null))
                                                                                                <select class="town form-control frontselect2" name="cityname">
                                                                                                    <option value=" " disabled="true" selected="true">Select Your City</option>
                                                                                                </select>
                                                                                            @else
                                                                                                <input type="text" value={{ $deliveriesdata->towns->town }} class="form-control input-md order-shipping-town" readonly name="town_order" />
                                                                                            @endif
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Pick Up Station</label>
                                                                                            @if (($userid > 0) && ($deliveriesdata === null))
                                                                                                <input type="text" placeholder="Pick Up Station" class="form-control input-md order-pickup-station" readonly name="pickup_order" />
                                                                                            @else
                                                                                                <input type="text" value={{ $deliveriesdata->pickuppoint }} class="form-control input-md order-pickup-station" readonly name="pickup_order" />
                                                                                            @endif
                                                                                            
                                                                                        </div>
                                                                                    </div>    
                                                                                    <div class="col-md-6">
                                                                                        <div class="checkout-form-list">
                                                                                            <label>Shipping Charges</label>
                                                                                            @if (($userid > 0) && ($deliveriesdata === null))
                                                                                                <input type="number" name="shipping_amount" class="form-control input-md order-shipping-charges" placeholder="Your Shipping Amount"/>
                                                                                            @else
                                                                                                <input type="number" value={{ $deliveriesdata->shipping_cost }} name="shipping_amount" class="form-control input-md order-shipping-charges" readonly/>
                                                                                            @endif
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
        
                                                                            </div>
                                                                        
                                                                            <div class="col-md-4">
                                                                                <h4>Select Your Payment Method</h4>
                                                                                @if (($userid > 0) && ($deliveriesdata === null))
                                                                                    <input type="number" name="orderuserid" class="orderuser_id" value="0" />
                                                                                @else
                                                                                    <input type="hidden" name="orderuserid" class="orderuser_id" value="{{ $deliveriesdata->user_id }}" /> 
                                                                                @endif
                                                                                @foreach($payment_methods as $payment_method)
                                                                                    <p>
                                                                                        <input type="radio" id="test1" value="{{ $payment_method->payment_name}}" name="payment_method" class="{{ $errors->has('payment_name') ? 'error' : '' }}" required >
                                                                                        <label for="test1">{{ $payment_method->payment_name}}</label>
                                                                                    </p>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-dark btn-block">Place Order</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                                                        <div class="row">
                                                            <p id="msg" style="font-size: 17px;"></p>
                                                            <p id="order_paid_msg" class="d-none" style="font-size: 17px;"></p>
                                                            <div class="col-md-12"  id="mode_of_payment">
                                                                <input type="hidden" name="order_payment_mode" class="orderpayment_mode" value=" " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif (($userid > 0) && ($orderplaced_status[0] === "order_placed"))
                                                <nav>
                                                    <div class="nav nav-tabs nav-fill " id="nav-tab" role="tablist">
                                                        <a class="nav-item nav-link billing-tab disabled " id="billing_details-tab" 
                                                            data-toggle="tab" href="#billing_details" role="tab" aria-controls="billing_details" aria-selected="true">
                                                            <span id="billingdetails">1.</span>Billing and Shipping Details
                                                        </a>

                                                        <a class="nav-item nav-link confirm-tab disabled" id="payments-tab"
                                                            data-toggle="tab" href="#payments" role="tab" aria-controls="payments" aria-selected="false">
                                                            <span class="payments">2.</span>Place Order
                                                        </a>
                                                        <a class="nav-item nav-link paid-tab active" id="place-order-tab" 
                                                            data-toggle="tab" href="#place-order" role="tab" aria-controls="place-order" aria-selected="false">
                                                            <span id="rentpaid">3.</span>Make Payment</a>
                                                    </div>
                                                </nav>
                                                <div class="tab-content" id="nav-tabContent">
                                                    <div class="tab-pane fade show" id="billing-details" role="tabpanel" aria-labelledby="billing_details-tab">
                                                        <div class="row">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show" id="place-order" role="tabpanel" aria-labelledby="place-order-tab">
                                                        <div class="row">
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade show active" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                                                        <div class="row">
                                                            <input type="hidden" id="user_order_id" value="{{ $getorder_id }}">
                                                            <input type="hidden" id="usersid" value="{{ $userid }}">
                                                            <p id="msg" style="font-size: 17px;"></p>
                                                            <p id="order_paid_msg" style="font-size: 17px;"></p>
                                                            @if ($order_details[0]->payment_method === "PAYPAL")
                                                                <div class="paypal-button-container"></div>
                                                            @elseif ($order_details[0]->payment_method === "MPESA")
                                                                <div class="mpesa">
                                                                    <div class="card border-0 ">
                                                                        <div class="card-body pt-0">
                                                                            <ul>
                                                                                <li>1.Open Your Mpesa Tool Kit</li>
                                                                                <li>2.Go to Lipa na M-PESA</li>
                                                                                <li>3.Click Paybill</li>
                                                                                <li>4.Click Business Number.Enter Business no. <b>123456</b></li>
                                                                                <li>5.For Account no. write your first name the click <b>ok</b></li>
                                                                                <li>6.Accept the payment as <b>Wkaranja Shopping Mall</b></li>
                                                                            </ul>
                                                                            <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                                                            <form role="form" method="post" id="mpesa_confirmation_form" >
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Enter the Payment Transaction Code</label>
                                                                                            <br>
                                                                                            <input type="text" placeholder="Enter Payment Transaction Code here" name="mpesa_transaction_code">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <button type="submit" class="btn btn-primary">Submit</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div> 
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @elseif ($order_details[0]->payment_method === "STRIPE")
                                                                <div class="col-md-12" style="background-color: rgb(223, 214, 231)">
                                                                    <div class="card padding-card product-card" style="text-align: center; margin-top:20px; background-color: rgb(223, 214, 231)">
                                                                        <h4>Pay Via Stripe</h4>
                                                                        <form method="post" id="stripeform" role="form">
                                                                            @csrf
                                                                            <input type="hidden" name="stripe_orderid" id="stripe_order_id" value="{{ $getorder_id }}">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="checkout-form-list">
                                                                                        <label>Card Number <span class="required">*</span></label>
                                                                                        <input type="number" placeholder="Enter Your Card Number" id="cardnumber" name="card_number" class="form-control input-md" required/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="checkout-form-list">
                                                                                        <label>Expiry Year <span class="required">*</span></label>
                                                                                        <input type="number" placeholder="YYYY" name="expiry_year" id="exp_year" class="form-control input-md" required/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="checkout-form-list">
                                                                                        <label>Expiry Month <span class="required">*</span></label>
                                                                                        <input type="number" placeholder="MM" name="expiry_month" id="exp_month" class="form-control input-md" required/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="checkout-form-list">
                                                                                        <label>Card Verification Checks(CVC) <span class="required">*</span></label>
                                                                                        <input type="number" placeholder="CVC" name="cvc" id="stripe_cvc" class="form-control input-md" required/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <input id="stripe_amount" type="hidden" name="stripe_amount" value="{{ $order_details[0]->grand_total }}"/>
                                                                            <input id="stripe_description" type="hidden" name="stripe_description" value="{{ $order_details[0]->tracking_id }}"/>
                                                                            <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                                                            <button type="submit" class="btn btn-dark btn-block">Pay <span class="stripe_amount">{{ $order_details[0]->grand_total }}</span></button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-5">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{Session::get('success')}}
                            </div>
                        @endif
                        <div class="your-order mb-30 ">
                            <h4>2.ORDER DETAILS</h4>

                             <div class="card border-0 ">
                                <div class="card-body pt-0">
                                    <?php $total_price=0; ?>
                                    @foreach ($usercartitems as $item )
                                        @if ($item->product->is_attribute==1)
                                            <?php $attrpric=Merchadise::getdiscountedattrprice($item['product_id'],$item['size']);?>
                                        @else
                                            <?php $discountedprice=Merchadise::getdiscountedprice($item['product_id']);            
                                            ?>
                                        @endif
                                    
                                        <div class="row justify-content-between">
                                            <div class="col-auto col-md-7">
                                                <div class="media flex-column flex-sm-row">
                                                    <img class=" img-fluid" style="margin-right: 5px; border-radius:50%;" src="{{ asset ('images/productimages/small/'.$item->product->merch_image) }}" width="62" height="62">
                                                    <div class="media-body my-auto">
                                                        <div class="row ">
                                                            <div class="col-auto">   
                                                                <p class="mb-0"><b>{!!str_limit($item->product->merch_name,15)!!}</b></p><small class="text-muted">{{ $item->product->merch_code }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class=" pl-0 flex-sm-col col-auto my-auto">
                                                <p class="boxed-1">{{ $item->quantity }}</p>
                                            </div>
                                            @if ($item->product->is_attribute==1)
                                                <div class=" pl-0 flex-sm-col col-auto my-auto ">
                                                    <p><b>{{ $attrpric['final_price']*$item['quantity'] }}</b></p>
                                                </div>
                                            @elseif($item->product->is_attribute==0)
                                                <div class=" pl-0 flex-sm-col col-auto my-auto ">
                                                    <p><b>{{ $discountedprice * $item['quantity'] }}</b></p>
                                                </div>
                                            @endif
                                        </div>
                                        <hr class="my-2">
                                        @if ($item->product->is_attribute==1)
                                            <?php $total_price=$total_price+($attrpric['final_price']*$item['quantity']);?>
                                        @elseif($item->product->is_attribute==0)
                                            <?php $total_price=$total_price+( $discountedprice * $item['quantity']);?>
                                        @endif
                                        
                                    @endforeach
                                </div>
                                <ul>
                                    <li>Total Price(sh.) <span id="subtotal" class="sub_total" style="float:right">{{ round($total_price) }}</span></li>
                                        
                                        {{-- shiping price --}}
                                    @if ($userid === 0)
                                        <li>Shipping Cost(sh.) <span id="shippingamount" class="shipping_amount" style="float:right">0</span></li>
                                    @else
                                        @if (($userid > 0) && ($deliveriesdata === null))
                                            <li>Shipping Cost(sh.) <span id="shippingamount" class="shipping_amount" style="float:right" >0</span></li>
                                        @else
                                            <li>Shipping Cost(sh.) <span id="shippingamount" class="shipping_amount" style="float:right" >{{ $deliveriesdata->shipping_cost }}</span></li>
                                        @endif
                                        
                                    @endif

                                    <span>

                                    </span>
                                        {{-- Coupon Amount --}}
                                    @if ($userid === 0)
                                        <li>Coupon Amount(sh.)
                                            <span class="coupon_amount" value="coupon_amount" style="float:right">
                                                0
                                            </span>
                                        </li>
                                    @else
                                        <li>Coupon Amount(sh.) <span class="coupon_amount" value="coupon_amount" style="float:right">0</span></li>
                                    @endif

                                        {{-- shows the grand total on calculation --}}
                                    @if ($userid === 0)
                                        <li>Grand Total Price(sh.{{ round($total_price) }}+
                                            <span id="sub_total" class="shipping_amount">0</span>-0
                                            {{ Session::get('couponAmount') }})=
                                            <span id="grand_total" class="netgrandtotal" name="grandtotal" style="float:right">
                                                {{ round($total_price-Session::get('couponAmount')) }}</span>
                                        </li>   
                                    @else
                                        @if (($userid > 0) && ($deliveriesdata === null))
                                            <li>Grand Total Price(sh.{{ round($total_price)}} + sh.<span class="shipping_amount">0</span>-sh.<span class="coupon_amount" value="coupon_amount">0</span></span>)=
                                                {{-- <span class="netgrandtotal" style="float:right">
                                                    {{ $grand_total= round($total_price) + $deliveriesdata->shipping_cost }}
                                                    <?php Session::put('grand_total',$grand_total);?>
                                                </span> --}}
                                            </li>
                                        @else
                                            <li>Grand Total Price(sh.{{ round($total_price)}}+<span>sh.{{ $deliveriesdata->shipping_cost }}</span>-sh.<span class="coupon_amount" value="coupon_amount">0</span></span>)=
                                                <span class="netgrandtotal" style="float:right">
                                                    {{ $grand_total= round($total_price) + $deliveriesdata->shipping_cost }}
                                                    <?php Session::put('grand_total',$grand_total);?>
                                                </span>
                                            </li>
                                        @endif 
                                    @endif
                                </ul>
                            </div>
                        </div>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </section>
        <section id="mode_of_payments" class="d-none">
            <div id="paypalpayment">
                <div class="paypal-button-container"></div>
            </div>
            <div id="stripe">
                <div class="row">
                    <div class="col-md-12" style="background-color: rgb(223, 214, 231)">
                        <div class="card padding-card product-card" style="text-align: center; margin-top:20px; background-color: rgb(223, 214, 231)">
                            <h4>Pay Via Stripe</h4>
                            <form method="post" id="stripeform" role="form">
                                @csrf
                                <input type="hidden" name="stripe_orderid" id="stripe_order_id" value="{{ $getorder_id }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Card Number <span class="required">*</span></label>
                                            <input type="number" placeholder="Enter Your Card Number" id="cardnumber" name="card_number" class="form-control input-md" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Expiry Year <span class="required">*</span></label>
                                            <input type="number" placeholder="YYYY" name="expiry_year" id="exp_year" class="form-control input-md" required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Expiry Month <span class="required">*</span></label>
                                            <input type="number" placeholder="MM" name="expiry_month" id="exp_month" class="form-control input-md" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Card Verification Checks(CVC) <span class="required">*</span></label>
                                            <input type="number" placeholder="CVC" name="cvc" id="stripe_cvc" class="form-control input-md" required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <input id="stripe_amount" type="hidden" name="stripe_amount" />
                                <input id="stripe_description" type="hidden" name="stripe_description"/>
                                <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                                <button type="submit" class="btn btn-dark btn-block">Pay <span class="grand_amount_to_pay" id="stripe_text_amount"></span></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mpesa">
                <div class="card border-0 ">
                    <div class="card-body pt-0">
                        <ul>
                            <li>1.Open Your Mpesa Tool Kit</li>
                            <li>2.Go to Lipa na M-PESA</li>
                            <li>3.Click Paybill</li>
                            <li>4.Click Business Number.Enter Business no. <b>123456</b></li>
                            <li>5.For Account no. write your first name the click <b>ok</b></li>
                            <li>6.Accept the payment as <b>Wkaranja Shopping Mall</b></li>
                        </ul>
                        <form role="form" method="post" id="mpesa_confirmation_form" >
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter the Payment Transaction Code</label>
                                        <br>
                                        <input type="text" placeholder="Enter Payment Transaction Code here" name="mpesa_transaction_code">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection

@section('checkoutscript')
    
    <script>

        var netgrandtotal = $('.netgrandtotal').text();

        paypal_post_url='{{ url("post_paypal") }}';

        var paymentamount = Number(netgrandtotal);

        $('.grand_amount_to_pay').val(paymentamount);

        $('#stripe_text_amount').text(netgrandtotal);

        var getorder_id =  $('#user_order_id').val();
        
        
        //submit paypal payment form 
        paypal.Buttons({
            style: {
                color: 'gold',
                shape: 'rect',
                label: 'pay',
                layout: 'vertical'
            },

            createOrder: function(data, actions) {
                // Set up the transaction details
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: paymentamount // Total amount for the order
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                // Capture the payment
                return actions.order.capture().then(function(details) {
                // Payment successful, execute further actions

                
                $.ajax({
                    url:paypal_post_url,
                    data:{
                        'email':details.payer.email_address,
                        'amount':details.purchase_units[0].amount.value,
                        'order_id':getorder_id,
                        'paypal_payment_id':details.id,
                        'paypal_payment_status':details.status,
                    },
                    type:'POST',
                    success: function(resp){
                        console.log(resp);

                        if (resp.status==200)
                        {
                            var id = resp.id;
                            var url = "{{ route('userprofile.show', ':id') }}";
                            url = url.replace(':id', id);
                            window.location.href = url;
                            $("#msg").show();
                            $("#msg").addClass("alert alert-warning font-weight-bold").html(resp.message);
                        } 
                        else if (resp.status==500)
                        {
                            
                        }
                        
                    }
                    ,error: function(error){
                        console.error(error)
                    }
                    
                 });
                });
            },
            onError: function(error) {
                // Handle any errors
                console.log(error);
            }
        }).render('.paypal-button-container');

        $(document).ready(function(){

            var total_amount = $('.sub_total').text();
            $('.total_amount_to_pay').val(total_amount);
            
            // apply customer coupon
            $("#applycoupon").on("submit",function(e){
                e.preventDefault();


                var url = '{{ route("apply_coupon") }}';

                var user = $(this).attr("couponuser");

                var copoun_code = $("#couponcode").val();

                if(user !== 0)
                {

                } else {
                    alert("Please Login to Apply the Coupon");
                    return false;
                }
                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#applycoupon").serialize(),
                    success:function(response){
                        console.log(response);
                        
                        if (response.status==200)
                        {
                            $('#coupon_total').val(response.couponamount);
                            $('.coupon_amount').text(response.couponamount);

                            $('.netgrandtotal').text(response.grand_total_payable);
                            $('.grand_amount_to_pay').val(response.grand_total_payable);

                            $('#coupon_discount_code').val(response.couponcode);

                            $('#applycouponbtn').css("pointer-events","none");
                            
                        } 
                        else if (response.status==400)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $('.checkout_errorlist').append('<li>' + response.message + '</li>');
                        }
                        else if (response.status==415)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $('.checkout_errorlist').append('<li>' + response.message + '</li>');
                        }
                        else if (response.status==410)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $('.checkout_errorlist').append('<li>' + response.message + '</li>');
                        }
                        else if (response.status==420)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $('.checkout_errorlist').append('<li>' + response.message + '</li>');
                        }
                        ;
                    }
                    ,error: function(error)
                    {
                        console.error(error)
                    }
                });
            })

            // pay via stripe
            $("#stripeform").on("submit",function(e){
                e.preventDefault();

                var url = '{{ route("stripe-payment") }}';
                
                var cardnumber =  $('#cardnumber').val();
                var cvc =  $('#stripe_cvc').val();
                var expiry_year =  $('#exp_year').val();
                var expiry_month =  $('#exp_month').val();
                var stripe_amt =  $('#stripe_amount').val();
                var order_id =  $('#stripe_order_id').val();
                var stripe_des =  $('#stripe_description').val();

                $.ajax({
                    url:url,
                    data:{
                        'card_number':cardnumber,
                        'stripe_amount':stripe_amt,
                        'cvc':cvc,
                        'expiry_year':expiry_year,
                        'expiry_month':expiry_month,
                        'stripe_orderid':order_id,
                        'stripe_description':stripe_des
                    },
                    type:"POST",
                    data:$("#stripeform").serialize(),
                    success:function(response){
                        console.log(response);
                        var id=response.id.user_id;
                        if (response=="succeeded")
                        {
                            $("#order_paid_msg").show();
                            $("#order_paid_msg").addClass("alert alert-warning font-weight-bold").html("Your Payment on Stripe has been successful");
                            //var id = resp.id;
                         
                            var url = "{{ route('userprofile.show', ':id') }}";
                            url = url.replace(':id', id);
                            window.location.href = url;
                        } 
                        else
                        {
                            $("#order_paid_msg").show();
                            $("#order_paid_msg").addClass("alert alert-warning font-weight-bold").html(response.message);
                        }
                        ;
                    }
                    ,error: function(error)
                    {
                        console.error(error)
                    }
                });
            })

            // add a new shipping location
            $("#billingform").on("submit",function(e){
                e.preventDefault();
                var url = '{{ route("address.store") }}';

                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#billingform").serialize(),
                    success:function(response){
                        console.log(response);
                        
                        if (response.status==415)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('.checkout_errorlist').append('<li>' + err_value + '</li>');
                            })
                        } else if (response.status==400)
                        {
                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);
                        }
                        else if (response.status==200)
                        {
                            $("#applycoupon").attr("couponuser", response.useraddress.user_id);

                            alertify.set('notifier','position', 'top-right');
                            alertify.success(response.message);   

                            $('.addedshipping').html(response.useraddress.shipcharges.county);
                            $('.addedtown').html(response.useraddress.towns.town);
                            $('.addedpickpoint').html(response.useraddress.pickuppoint);
                            $('.addedcost').html(response.useraddress.shipping_cost);

                            $('#place-order-tab').removeClass("disabled").addClass("active");
                            $('#payments-tab').removeClass("active").addClass("disabled");
                            $('#billing_details-tab').removeClass("active").addClass("disabled");

                            
                            var usersid=$('.orderuser_id').val(response.useraddress.user_id);

                            $('.order-shipping-charges').val(response.useraddress.shipping_cost);
                            $('.order-shipping-county').val(response.useraddress.shipcharges.county);
                            $('.order-shipping-town').val(response.useraddress.towns.town);
                            $('.order-pickup-station').val(response.useraddress.pickuppoint);

                            //get the grandtotal to pay
                            var netgrandtotal = $('.netgrandtotal').text();
                            $('.grand_amount_to_pay').val(netgrandtotal);
                            
                            
                            $('#billing-details').hide();
                            $('#place-order').show();
                        };
                    }
                });
            })

            // place order for the user
            $("#place_order_form").on("submit",function(e){
                e.preventDefault();
                var url = '{{ route("place_order") }}';

                $.ajax({
                    url:url,
                    type:"POST",
                    data:$("#place_order_form").serialize(),
                    success:function(response){
                        console.log(response);

                        if (response.status==200)
                        {
                            $("#msg").show();
                            $("#msg").addClass("alert alert-warning font-weight-bold").html(response.message);
                            $("#msg").fadeOut(50000); 

                            //$('.addedshipping').html(response.useraddress.shipcharges.county);

                            $('#payments-tab').removeClass("disabled").addClass("active");
                            $('#place-order-tab').removeClass("active").addClass("disabled");
                            //$('#billing_details-tab').removeClass("active").addClass("disabled");

                            $('#place-order').hide(); 
                            $('#payments').show();

                            $('.orderpayment_mode').val(response.payment_mode);
                            if (response.payment_mode=="MPESA")
                            {
                                $('#mpesa').show();
                                $('#mpesa').appendTo('#mode_of_payment');
                            } 
                            else if (response.payment_mode=="PAYPAL")
                            {
                                $('#paypalpayment').show();
                                $('#paypalpayment').appendTo('#mode_of_payment');
                                $('#paypalorder_id').val(response.orderdetails.id);
                                $('#paypalorder_useremail').val(response.orderdetails.email);
                                $('#paypalorder_firstname').val(response.orderdetails.first_name);
                                $('#paypalorder_lastname').val(response.orderdetails.last_name);
                                $('#paypalorder_usercounty').val(response.orderdetails.county);
                                $('#paypalorder_usertown').val(response.orderdetails.town);
                                $('#paypalorder_useramount').val(response.orderdetails.grand_total);

                                // submit paypal payment form 
                                paypal.Buttons({
                                    style: {
                                        color: 'gold',
                                        shape: 'rect',
                                        label: 'pay',
                                        layout: 'vertical'
                                    },

                                    // Order is created on the server and the order id is returned
                                    createOrder() {
                                        return fetch("/my-server/create-paypal-order", {
                                            method: "POST",
                                            headers: {
                                            "Content-Type": "application/json",
                                            },
                                            // use the "body" param to optionally pass additional order information
                                            // like product skus and quantities
                                            body: JSON.stringify({
                                            cart: [
                                                {
                                                sku: "YOUR_PRODUCT_STOCK_KEEPING_UNIT",
                                                quantity: "YOUR_PRODUCT_QUANTITY",
                                                },
                                            ],
                                            }),
                                        })
                                        .then((response) => response.json())
                                        .then((order) => order.id);
                                    },
                                    // Finalize the transaction on the server after payer approval
                                    onApprove(data) {
                                        return fetch("/my-server/capture-paypal-order", {
                                            method: "POST",
                                            headers: {
                                            "Content-Type": "application/json",
                                            },
                                            body: JSON.stringify({
                                            orderID: data.orderID
                                            })
                                        })
                                        .then((response) => response.json())
                                        .then((orderData) => {
                                            // Successful capture! For dev/demo purposes:
                                            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                                            const transaction = orderData.purchase_units[0].payments.captures[0];
                                            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                                            // When ready to go live, remove the alert and show a success message within this page. For example:
                                            // const element = document.getElementById('paypal-button-container');
                                            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                                            // Or go to another URL:  window.location.href = 'thank_you.html';
                                        });
                                    }
                                }).render('.paypal-button-container');
                            }               
                            else if (response.payment_mode=="STRIPE")
                            {             
                                $('#stripe').show();
                                $('#stripe').appendTo('#mode_of_payment');
                                
                                //$('#stripe_value_amount').text(response.orderdetails.grand_total);
                                $('#stripe_amount').val(response.orderdetails.grand_total);
                                $('#stripe_description').val(response.orderdetails.tracking_id);
                            }
                        };
                    }
                    ,error: function(error)
                    {
                        console.error(error)
                    }
                });
            })

            // buyer confirm mpesa transaction code 
            $("#mpesa_confirmation_form").on("submit",function(e){
                e.preventDefault();
                var mpesaconfirmationurl = '{{ route("mpesa.confirmation") }}';

                $.ajax({
                    url:mpesaconfirmationurl,
                    type:"POST",
                    data:$("#mpesa_confirmation_form").serialize(),
                    success:function(response){
                        console.log(response);
                        var userid=response.userid;
                        if (response.status==415)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('.checkout_errorlist').append('<li>' + err_value + '</li>');
                            })
                        } 
                        else if (response.status==200)
                        {
                            $("#order_paid_msg").show();
                            $("#order_paid_msg").addClass("alert alert-warning font-weight-bold").html(response.message);
                            
                            var url = "{{ route('userprofile.show', ':id') }}";
                            url = url.replace(':id', userid);
                            window.location.href = url;
                        } 
                        else if (response.status==500)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('.checkout_errorlist').append('<li>' + err_value + '</li>');
                            })
                        }  
                        else if (response.status==450)
                        {
                            $('.checkout_errorlist').html(" ");
                            $('.checkout_errorlist').removeClass('d-none');
                            $.each(response.message,function(key,err_value)
                            {
                                $('.checkout_errorlist').append('<li>' + err_value + '</li>');
                            })
                        }
                        
                        
                    }
                });
            })

        });

        $(document).on('click','#customer_login_here',function(e){
            e.preventDefault();

            $('#LogInModal').modal('show');
        })
        
    </script>
@stop
