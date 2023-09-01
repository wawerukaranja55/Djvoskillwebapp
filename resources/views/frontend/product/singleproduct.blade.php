<?php use App\Models\Merchadise; ?>
@extends('frontend.master')
@section('title','Merchadise')
@section('content')
@section('front_singleproductstyles')
    <style>
        .product_qty_size{
            display: flex;
            justify-content: space-between;
        }

        ul{
            margin-top: 10px;
            padding-left: 20px;
        }

        ul li{
            list-style-type: none;
            margin-bottom: 10px;
        }

        ul li img{
            width: 100px;
            height: 120px;
            opacity: 0.8;
            cursor: pointer;
        }

        ul li img:hover{
            opacity: 1;
        }

        #big_img{
            width:550px;
            height: 640px;
            margin: 10px;
        }

        #big_img_copy{
            z-index: 9;
            width:500px;
            height: 640px;
            margin: 10px;
        }

        .btn-share.btn-twitter {
            background-color: rgba(29,161,242,.08);
            color: #1da1f2;
        }

        .btn-share.btn-instagram {
            background-color: rgba(88,81,219,.08);
            color: #5851db;
        }

        .btn-share.btn-facebook:hover {
            background-color: #3b5998;
        }

        .btn-share:hover {
            color: #fff;
            box-shadow: none;
        }
        .btn-share.btn-facebook {
            background-color: rgba(59,89,152,.08);
            color: #3b5998;
        }
        a:hover {
            color: #fe3638;
            text-decoration: none;
        }
        .btn-share {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            transition: color .25s ease-in-out,background-color .25s ease-in-out;
            border-radius: 0.25rem;
            font-size: .875rem;
            text-decoration: none !important;
            vertical-align: middle;
            margin-right: 0.5rem !important;
            margin-top: 0.5rem !important;
            margin-bottom: 0.5rem !important;
        }

        .btn-share>i {
          margin-top: -0.125rem;
          margin-right: 0.3125rem;
          font-size: 1.1em;
        }
        
    </style>
@stop
<div class="container">
    <ul class="ps-breadcrumb">
        <li class="ps-breadcrumb__item"><a href="{{ route('index') }}">Home</a></li>
        <li class="ps-breadcrumb__item"><a href="{{ route('merchadise') }}">{{ $singleproduct->merchadisecategor->merchadisecat_title }}</a></li>
        <li class="ps-breadcrumb__item active" aria-current="page">{{ $singleproduct->merch_name }}</li>
    </ul>
    <div class="ps-product--detail">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="entry-date-media">
                    <div style="border: 5px solid black;
                    display:flex;" class="entry-media">
                        <ul>
                            <li><img src="{{ asset ('images/productimages/medium/1(1).png') }}" class="small_img" onclick="changeImg(this)"></li>
                            <li><img src="{{ asset ('images/productimages/medium/2(1).png') }}" class="small_img" onclick="changeImg(this)"></li>
                            <li><img src="{{ asset ('images/productimages/medium/3(1).png') }}" class="small_img" onclick="changeImg(this)"></li>
                            <li><img src="{{ asset ('images/productimages/medium/4(1).png') }}" class="small_img" onclick="changeImg(this)"></li>
                            <li><img src="{{ asset ('images/productimages/medium/5(1).png') }}" class="small_img" onclick="changeImg(this)"></li>
                        </ul>
                        <img src="{{ asset ('images/productimages/medium/1(1).png') }}" id="big_img">
                        <img src="{{ asset ('images/productimages/medium/1(1).png') }}" id="big_img_copy">
                    </div>
                  </div>
                {{-- <div class="ps-product--gallery">
                    <div class="entry-media" style="border: 5px solid black">
                        <img src="{{ asset ('productimages/'.$singleproduct->merch_name) }}" class="img img-responsive" style="width:100%; height:500px;">
                      </div>
                    {{-- <div class="ps-gallery--image">
                        <div class="slide">
                        <div class="ps-gallery__item">
                            <img src="{{ asset ('productimages/'.$singleproduct->merch_name) }}" alt="$singleproduct->merch_name" /></div>
                        </div>
                    </div> --}}
                    {{-- <div class="ps-product__thumbnail">
                        <div class="slide"><img src="img/products/3_dt_1.jpg" alt="alt" /></div>
                        <div class="slide"><img src="img/products/3_dt_2.jpg" alt="alt" /></div>
                        <div class="slide"><img src="img/products/3_dt_3.jpg" alt="alt" /></div>
                        <div class="slide"><img src="img/products/3_dt_4.jpg" alt="alt" /></div>
                    </div>
                </div> --}}
            </div>
            <div class="col-12 col-md-4">
                <div class="ps-product__info">
                    <div class="ps-product__branch"><a href="{{ url($singleproduct->merchadisecategor->url) }}">{{ $singleproduct->merchadisecategor->merchadisecat_title }}</a></div>
                    <h4 class="ps-product__title">{{ $singleproduct->merch_name }}</h4>
                    <div class="ps-product__type">
                        <div class="ps-product__item"><span class="text">Product code</span><span class="text-bold">{{ $singleproduct->merch_code }}</span></div>
                        <div class="ps-product__item"><span class="text">Availability</span><span class="text-bold">{{ $singleproduct->stock }} in stock</span></div>
                    </div> 
                    <div class="ps-product__meta">
                        <?php $discountedprice=Merchadise::getdiscountedprice($singleproduct->id);?>
                            <!-- Product price-->
                            @if ($discountedprice>0)
                                <del>
                                    <span class="merch_price sale text-decoration-line-through">
                                        Sh.{{ $singleproduct->merch_price }}
                                    </span>
                                </del>
                                <span class="getattrCalculatedPrice ps-product__price sale">
                                    Sh.{{ $discountedprice }}
                                </span>
                            @else
                            <span class="ps-product__price sale">
                                Sh.{{ $singleproduct->merch_price }}
                            </span>
                            @endif
                    </div>
                    <div class="product_qty_size">
                        <div class="ps-product__quantity">
                            <h6>Quantity</h6>
                            <div class="d-flex align-items-center">
                                <div class="def-number-input number-input safari_only">
                                    <input class="quantity" min="0" name="quantity" value="1" type="number" />
                                </div>
                            </div>
                        </div>
    
                        <div class="ps-product-size">
                            @if ($singleproduct->is_attribute==1)
                                <div class="ps-product__feature">
                                    <div class="ps-product__group">
                                        <h6>Size</h6>
                                        
                                        <div class="input-group mb-3">
                                            <select class="custom-select" product-id="{{ $singleproduct['id'] }}" id="getProductSize" name="productsize">
                                                <option value="" disabled selected>select size</option>
                                                @foreach ($singleproduct->merchadiseattributes as $attribute )
                                                    <option value="{{ $attribute->productattr_size }}">{{ $attribute->productattr_size }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <input id="getProductSize" type="hidden" name="productsize" value="none">
                            @endif
                        </div>
                    </div>
                    
                    <p id="msg" style="font-size: 17px;"></p>

                    <input id="prod_id" type="hidden" name="product_id" value="{{ $singleproduct->id }}">

                    <button id="add_product_to_cart" style="width: 100%;border-radius:5px;">
                        <i class="fas fa-shopping-cart"></i>Add to cart
                    </button>

                  <!-- Sharing-->
                  <label class="form-label d-inline-block align-middle my-2 me-3">
                    Share:</label>
                    <a class="btn-share btn-twitter me-2 my-2" href="#"><i class="fab fa-twitter"></i> Twitter</a>
                    <a class="btn-share btn-instagram me-2 my-2" href="#"><i class="fab fa-instagram"></i> Instagram</a>
                    <a class="btn-share btn-facebook my-2" href="#"><i class="fab fa-facebook-f"></i> Facebook</a>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <p>{!!$singleproduct->merch_details!!}</p>
          </div>
        </div>
    </div>
</div>
@endsection

@section('singleproductpagescripts')
    <script type="text/javascript">
        function changeImg(smallImg)
            {
                var fullImg=document.getElementById("big_img");
                {
                    fullImg.src=smallImg.src;
                }
            }
    </script>
@stop

  