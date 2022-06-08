<!-- Cart Table -->
<?php use App\Models\Merchadise; ?>
<?php use App\Models\Cart; ?>

    <div class="col-lg-12 text-center">
        <div class="section-title">
            <h3>MY CART PRODUCT DETAILS</h3>
        </div>
    </div>
    <table id="userdatatables" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
        </thead>
         <tbody>
            <?php $total_price=0; ?>
            <?php $attributetotal_price=0; ?>
            <?php $noattributetotal_price=0; ?>
            @forelse ($cartitems as $item)

                @if ($item->product->is_attribute==1)
                    <?php $attrpric=Merchadise::getdiscountedattrprice($item['product_id'],$item['size']);
                        
                    ?>,
                @else
                    <?php $discountedprice=Merchadise::getdiscountedprice($item['product_id']);
                                
                    ?>
                @endif
                
                <tr>
                    <td>{{ $item->product->merch_name }}</td>
                    @if ($item->product->is_attribute==1)
                        <td>{{ $attrpric['merch_price'] }}</td>
                    @else
                        <td>{{ $item->product->merch_price }}</td>
                    @endif
                    
                    <td>
                        <img src="{{ asset ('images/productimages/small/'.$item->product->merch_image) }}" style="width:100px; height:100px;" alt="Product">
                    </td>
                    <td>
                        <button class="itemupdate qtyminus" type="button" data-cartid="{{ $item->id }}">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </button>
                        <input data-id={{ $item->id }} class="quantity" min="1" name="quantity[]" value="{{ $item->quantity }}" type="number">
                        <button class="itemupdate qtyplus" type="button" data-cartid="{{ $item->id }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </td>
                    @if ($item->product->is_attribute==1)
                        <td>sh.{{ $attrpric['discount'] * $item['quantity'] }}</td>
                        <td>sh.{{ $attrpric['final_price'] * $item['quantity'] }}</td>
                    @elseif($item->product->is_attribute==0)
                        
                        <td>{{ ($item->product->merch_price-$discountedprice) * $item['quantity'] }}</td>
                        <td>{{ $discountedprice * $item['quantity'] }}</td>
                    @endif
                    
                    <td>
                        <form method="POST" action="{{ route('deletecartitem', $item->id) }}">
                            @csrf
                            <input name="method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-xs btn-danger btn-flat show_confirm" data-toggle="tooltip" title='Delete'>Delete</button>
                        </form>
                    </td>
                </tr>
                @if ($item->product->is_attribute==1)
                    <?php $attributetotal_price=$total_price+($attrpric['final_price'] * $item['quantity'] );
                    ?>
                @elseif($item->product->is_attribute==0)
                    <?php $noattributetotal_price=$total_price+($discountedprice * $item['quantity'] );?>
              @endif
            
            @empty
                <P style="font-size: 15px; text-align:center;margin:40px;">Your Cart is Empty.Click <a href="{{url('products')}}">here</a> to shop for products</p>
            @endforelse
        </tbody>
    </table>

    @if ($message=Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="coupon-all">
                <form class="coupon" id="applycoupon" method="POST" action="javascript:void(0);"
                    @if(Auth::check())
                        couponuser="1"
                    @endif>
                    @csrf
                    <input id="couponcode" class="input-text" name="couponcode" placeholder="Enter Your Coupon code" type="text">
                    <button type="submit" class="btn btn-secondary" id="couponbtn">Apply Coupon</button>
                </form>
                <div class="coupon2">
                    <a href="{{ url('products') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 ml-auto">
            <div class="cart-page-total">
                <h2>Cart totals</h2>
                <ul class="mb-20">
                    <li>Coupon Discount
                        <span class="couponAmount">
                            @if (Session::has('couponAmount'))
                            -Sh.{{ Session::get('couponAmount') }}
                            @else
                            sh.0   
                            @endif
                        </span>
                    </li>
                    <li>Grand Total 
                        <span class="grand_total">Sh.{{ $attributetotal_price+$noattributetotal_price-Session::get('couponAmount') }}</span>
                    </li>
                </ul>
                @auth
                    <a href="{{ url('checkout') }}" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a>
                @else
                    <p>To proceed to checkout create or log in to your account...</p>
                    <span href="#" data-toggle="modal" data-target="#RegistrationModal" class="btn btn-success btn-block">Create/Login an Account<i class="fa fa-angle-right"></i></span>
                @endauth
            </div>
        </div>
    </div> 