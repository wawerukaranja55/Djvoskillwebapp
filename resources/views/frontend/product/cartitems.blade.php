<!-- Cart Table -->
<?php use App\Models\Merchadise; ?>
<?php use App\Models\Cart; ?>

    <div class="col-lg-12 text-center">
        <div class="section-title">
            <h3>MY CART PRODUCT DETAILS</h3>
        </div>
    </div>

    <table class="userdatatable table table-striped table-bordered nowrap" style="width:100%;">
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
            <?php $attributetotal_price=0; ?>
            <?php $noattributetotal_price=0; ?>
            @foreach($cartitems as $item)
                <tr>
                    @if ($item->product->is_attribute=="1")
                        <?php $attrpric=Merchadise::getdiscountedattrprice($item['product_id'],$item['size']);
                            
                        ?>,
                    @else
                        <?php $discountedprice=Merchadise::getdiscountedprice($item['product_id']);
                                    
                        ?>
                    @endif
                    <td>{{ $item->product->merch_name }}</td>
                    @if ($item->product->is_attribute=="1")
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
                        <input data-id={{ $item->id }} class="quantity" min="1" name="quantity[]" value="{{ $item->quantity }}" type="number" readonly>
                        <button class="itemupdate qtyplus" type="button" data-cartid="{{ $item->id }}">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        </button>
                    </td>
                    @if ($item->product->is_attribute==1)<td>sh.{{ $attrpric['discount'] * $item['quantity'] }}</td>
                        <td>sh.{{ $attrpric['final_price'] * $item['quantity'] }}</td>
                    @elseif($item->product->is_attribute==0)
                        
                        <td>{{ ($item->product->merch_price-$discountedprice) * $item['quantity'] }}</td>
                        <td>{{ $discountedprice * $item['quantity'] }}</td>
                    @endif
                    <td>
                        <a class="btn btn-primary btn-xs" onclick="confirm return('Are you Sure You want to Delete?')" href="{{ route('deletecartitem', $item->id) }}"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                    {{-- show cart total --}}
                @if ($item->product->is_attribute==1)
                    <?php $attributetotal_price=$attributetotal_price+($attrpric['final_price'] * $item['quantity'] );
                    ?>
                @elseif($item->product->is_attribute==0)
                    <?php $noattributetotal_price=$noattributetotal_price+($discountedprice * $item['quantity'] );?>
                @endif
            @endforeach
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
                            sh.0
                        </span>
                    </li>
                    <li>Grand Total 
                        <span class="grand_total">Sh.{{ $attributetotal_price + $noattributetotal_price-0 }}</span>
                    </li>
                </ul>
                <a href="{{ url('checkout') }}" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a>
                {{-- @auth
                    <a href="{{ url('checkout') }}" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a>
                @else
                    <p>To proceed to checkout create or log in to your account...</p>
                    <span href="#" data-toggle="modal" data-target="#RegistrationModal" class="btn btn-success btn-block">Create/Login an Account<i class="fa fa-angle-right"></i></span>
                @endauth --}}
            </div>
        </div>
    </div> 