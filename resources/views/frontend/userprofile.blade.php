@extends('frontend.master')
@section('title','User Profile Page' )
@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>
    <!-- /Breadcrumb -->

    <p id="orderupdate" style="font-size: 17px;"></p>
    <div class="row">
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link user-tab active" id="user_details-tab" 
                        data-toggle="tab" href="#user_details" role="tab" aria-controls="user_details" aria-selected="true">
                        <span id="userdetails">1.</span>User Profile
                    </a>

                    <a class="nav-item nav-link orders-tab" id="all-orders-tab"
                        data-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">
                        <span class="userorders">2.</span>Orders
                    </a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="user-details" role="tabpanel" aria-labelledby="user_details-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                <h4>1.User Details</h4>
                                <form method="post" id="userform" class="form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="checkout-form-list">
                                                <label>First Name <span class="required">*</span></label>
                                                <input type="text" value="{{ Auth::User()->first_name }}" name="first_name" class="form-control input-md {{ $errors->has('first_name') ? 'error' : '' }}" required/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="checkout-form-list">
                                                <label>Last Name <span class="required">*</span></label>
                                                <input type="text" value="{{ Auth::User()->last_name }}" name="last_name" class="form-control input-md {{ $errors->has('last_name') ? 'error' : '' }}" required/>
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
                                                    {{-- <option value="0" disabled="true" selected="true">Choose Your County</option>
                                                        @foreach($delivaddresses as $address)
                                                            <option value="{{ $address->id }}">{{ $address->county }}</option>
                                                        @endforeach --}}
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
                                    <button type="submit" class="btn btn-dark btn-block">Edit Your Details</button>
                                    {{-- {{ route('userprofile.edit',Auth::user()->id)}} --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="orders" role="tabpanel" aria-labelledby="all-orders-tab">
                    <div class="row">
                        <div class="col-md-12">

                            <h5 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">Current Order In Progress</h5>
                            <div class="card card-timeline px-2 border-none">
                                {{-- @if ($latest_order === "Paid" && $latest_order === "In_Transit" && $latest_order === "Delivered" && $latest_order === "Picked_From_Station") --}}
                                    <ul class="bs4-order-tracking">
                                        @if ($latest_order === "Paid")
                                            <li class="step active"><div><i class="fas fa-user"></i></div> Order Placed </li>
                                            <li class="step"><div><i class="fas fa-truck"></i></div> In Transit</li>
                                            <li class="step"> <div><i class="fas fa-birthday-cake"></i></div> Delivered to Station </li>
                                            <li class="step"> <div><i class="fas fa-birthday-cake"></i></div> Picked From Station </li> 
                                        @elseif ($latest_order === "In_Transit")
                                            <li class="step"><div><i class="fas fa-user"></i></div> Order Placed </li>
                                            <li class="step active"><div><i class="fas fa-truck"></i></div> In Transit</li>
                                            <li class="step"> <div><i class="fas fa-birthday-cake"></i></div> Delivered to Station </li>
                                            <li class="step"> <div><i class="fas fa-birthday-cake"></i></div> Picked From Station </li> 
                                        @elseif ($latest_order === "Delivered")
                                            <li class="step"><div><i class="fas fa-user"></i></div> Order Placed </li>
                                            <li class="step"><div><i class="fas fa-truck"></i></div> In Transit</li>
                                            <li class="step active"> <div><i class="fas fa-birthday-cake"></i></div> Delivered to Station </li>
                                            <li class="step"> <div><i class="fas fa-birthday-cake"></i></div> Picked From Station </li>
                                        @elseif ($latest_order === "Picked_From_Station")
                                            <li class="step"><div><i class="fas fa-user"></i></div> Order Placed </li>
                                            <li class="step"><div><i class="fas fa-truck"></i></div> In Transit</li>
                                            <li class="step"> <div><i class="fas fa-birthday-cake"></i></div> Delivered to Station </li>
                                            <li class="step active"> <div><i class="fas fa-birthday-cake"></i></div> Picked From Station </li>
                                        @endif
                                        
                                    </ul>
                                {{-- @else
                                    <p>You Do Not have a Pending Order</p>
                                @endif --}}
                            </div>      
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card padding-card product-card" style="text-align: center; margin-top:20px;">
                                <h4 class="mb-2 panel-title ms_heading text-white bg-black" style="padding:10px;">{{ Auth::User()->first_name }} {{ Auth::User()->last_name }} Orders</h4>
                                <table id="userorderstable" class="table table-striped table-bordered" style="width:140%; margin-top:50px;">
                                    <thead>
                                        <tr>
                                            {{-- <td>Id</td> --}}
                                            <td>Order Tracking Id</td>
                                            <td>Total Paid</td>
                                            <td>Town Shipped</td>
                                            <td>Payment Method</td>
                                            <td>Order Status</td>
                                            <td>Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
    {{-- <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ asset('usersimages'.'/'.Auth::User()->avatar) }}" alt="{{ Auth::User()->name }}" width="100" height="100">
                    <div class="mt-3">
                        <h4>{{ Auth::User()->name }}</h4>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Personal Details</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            {{ Auth::User()->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <h4>{{ Auth::User()->email }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a class="btn btn-info "  href="{{ route('userprofile.edit',Auth::user()->id)}}">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            my orders
        </div>
        <div class="col-md-8">
            order details
        </div>
    </div> --}}
</div>
@endsection
@section('userprofilescript')
    
    <script>

        $(document).ready(function(){

            // switch tabs
            $("#user_details-tab").on('click',function(){
                $('#user-details').removeClass("disabled").addClass("active");
                $('#orders').removeClass("active").addClass("disabled");
            });

            $("#all-orders-tab").on('click',function(){
                $('#orders').removeClass("disabled").addClass("active");
                $('#user-details').removeClass("active").addClass("disabled");
            });

            // show all orders for a user in a datatable
            var userorderstable = $('#userorderstable').DataTable({
                processing:true,
                serverside:true,
                responsive:true,

                ajax:"{{ route('user.orders') }}",
                columns: [
                    // { data: 'id' },
                    { data: 'tracking_id' },
                    { data: 'grand_total' },
                    { data: 'town' },
                    { data: 'payment_method' },
                    { data: 'order_status' },
                    { data: 'action',name:'action',orderable:false,searchable:false },
                ],
            });
        });
    </script>
@stop
  