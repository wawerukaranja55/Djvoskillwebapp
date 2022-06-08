
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
                    <div class="col-lg-6">
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

                            @empty($addresses)
                             <h4>1.BILLING DETAILS</h4>

                             
                                <form method="post" action="{{ route('address.store') }}" class="form">
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
                                    
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Company Name</label>
                                            <input type="text" placeholder="Your Company Name" name="company_name" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Phone <span class="required">*</span></label>
                                            <input type="text" placeholder="Your Phone Number" name="phone" class="form-control input-md {{ $errors->has('phone') ? 'error' : '' }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="country-select">
                                            <label>County <span class="required">*</span></label>
                                            <select id="cty_id" class="county form-control" name="countyname">
                                                <option value="0" disabled="true" selected="true">Choose Your County</option>
                                                    @foreach($delivaddresses as $address)
                                                        <option value="{{ $address->id }}">{{ $address->county }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Town / City <span class="required">*</span></label>
                                            <select class="town form-control" name="cityname">
                                                <option value=" " disabled="true" selected="true">Select Your City</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Pick Up Point <span class="required">*</span></label>
                                            <input type="text" name="street_address" class="pickup_point form-control input-md" value=" " />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>price <span class="required">*</span></label>
                                            <input type="text"name="shipping_amount" class="total_amount form-control input-md" value=" " />
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-dark btn-block">Submit</button>
                                </form>
                                 

                            @else                            
                            <h4 class="checkout_title">1.BILLING DETAILS</h4>

                             
                                <div class="card border-2 shadow p-3 mb-5 bg-white rounded">
                                    <div class="card-header" style="position: relative;">
                                        <p class="card-text text-dark">SHIPPING DETAILS</p>
                                        <a href="#" class="float-right" style="position: absolute; 
                                        right: 25px;
                                        top: 25px;">Change</a>
                                        <hr class="my-0">
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-between">
                                            <div class="col-auto mt-0">
                                                <p><b>
                                                    {{ $addresses->shipcharges->county }}
                                                </b></p>
                                            </div>
                                            <br>
                                            <div class="col-auto">
                                                <p><b>{{ $addresses->towns->town }},{{ $addresses->towns->pickuppoint }}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                            @endempty
                        </div>


                    </div>
                    <div class="col-lg-6">
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
                                                    <img class=" img-fluid" src="{{ asset ('images/productimages/small/'.$item->product->merch_image) }}" width="62" height="62">
                                                    <div class="media-body my-auto">
                                                        <div class="row ">
                                                            <div class="col-auto">
                                                                <p class="mb-0"><b>{{ $item->product->merch_name }}</b></p><small class="text-muted">{{ $item->product->merch_code }}</small>
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
                                    <li>Total Price <span id="sub_total" class="sub_total" style="float:right">{{ $total_price }}</span></li>
                                        {{-- shiping price --}}
                                    @empty ($addresses)
                                    <li>Shipping Cost <span id="shipping_amount" class="shipping_amount" style="float:right">0</span></li>
                                        
                                    @else
                                    <li>Shipping Cost <span style="float:right" >{{ $addresses->shipping_cost }}</span></li>
                                    @endempty

                                        {{-- Coupon Amount --}}
                                    @empty ($addresses)
                                        <li>Coupon Amount <span class="coupon_amount" value="coupon_amount" style="float:right">
                                            @if (session()->has('couponAmount'))
                                                Sh.{{ Session::get('couponAmount') }}
                                            @else
                                                sh.0
                                            @endif
                                        </span></li>
                                    @else
                                        <li>Coupon Amount <span style="float:right">Sh.{{ Session::get('couponAmount') }}</span></li>
                                    @endempty
                                        {{-- shows the grand total on calculation --}}
                                    @empty ($addresses)
                                        <li>Grand Total Price(sh.{{ $total_price }}+<span id="sub_total" class="shipping_amount">0</span>-0{{ Session::get('couponAmount') }})=<span id="grand_total" class="grand_total" style="float:right">{{ $total_price-Session::get('couponAmount') }}</span></li>   
                                    @else
                                        <li>Grand Total Price(sh.{{ $total_price }}+<span>sh.{{ $addresses->shipping_cost }}</span>-<span>sh.{{ Session::get('couponAmount') }}</span>)=<span class="grand_total" style="float:right">{{ $grand_total=$total_price+$addresses->shipping_cost-Session::get('couponAmount') }}<?php Session::put('grand_total',$grand_total);?></span>
                                        </li>
                                    @endempty
                                </ul>
                            </div>  

                            @empty ($addresses)
                                
                            @else
                                <h4>3.PAYMENT METHODS</h4>
                               
                               
                                <form method="post" action="{{url('/addtoorder')}}">
                                    @csrf
                                    @foreach($payment_methods as $payment_method)
                                        <p>
                                            <input type="radio" id="test1" value="{{ $payment_method->payment_name}}" name="payment_method" class="{{ $errors->has('payment_name') ? 'error' : '' }}" required >
                                            <label for="test1">{{ $payment_method->payment_name}}</label>
                                        </p>
                                    @endforeach
                                    <div class="row mb-5 mt-4 ">
                                        <div class="col-md-7 col-lg-6 mx-auto">
                                            <button type="submit" class="btn btn-block btn-outline-primary btn-lg">Proceed</button>
                                        </div>
                                    </div>
                                </form>   

                            @endempty
                        </div>
                        </ol>
                    </div>
                    
                </div>
            </div>
        </section>
@endsection
