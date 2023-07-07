<?php use App\Models\Merchadise; ?>
@extends('frontend.master')
@section('title','Merchadise')
@section('content')
<div class="container">
    <ul class="ps-breadcrumb">
        <li class="ps-breadcrumb__item"><a href="{{ route('index') }}">Home</a></li>
        <li class="ps-breadcrumb__item"><a href="{{ route('merchadise') }}">{{ $singleproduct->merchadisecategor->merchadisecat_title }}</a></li>
        <li class="ps-breadcrumb__item active" aria-current="page">{{ $singleproduct->merch_name }}</li>
    </ul>
    <div class="ps-product--detail">
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="entry-date-media">
                    <div class="entry-media" style="border: 5px solid black">
                      <img src="{{ asset ('images/productimages/large/'.$singleproduct->merch_image) }}" class="img img-responsive img-rounded" style="width:100%; height:500px;">
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
            <div class="col-12 col-md-5">
                <div class="ps-product__info">
                    <div class="ps-product__branch"><a href="{{ url($singleproduct->merchadisecategor->url) }}">{{ $singleproduct->merchadisecategor->merchadisecat_title }}</a></div>
                    <h4 class="ps-product__title">{{ $singleproduct->merch_name }}</h4>
                    <div class="ps-product__type">
                        <div class="ps-product__item"><span class="text">Product code</span><span class="text-bold">{{ $singleproduct->merch_code }}</span></div>
                        <div class="ps-product__item"><span class="text">Availability</span><span class="text-bold">3 in stock</span></div>
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
                    <div class="ps-product__available">
                        <div class="ps-product__text">{{ $singleproduct->product_views }} views</div>
                        <div class="ps-product__text">Hurry! Only 3 left in stock</div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        {{-- <div class="ps-product__sale"> <img src="img/icon/fire.svg" alt="" />28 sold in last 24 hours</div> --}}
                    </div>

                    <div class="ps-product__quantity">
                        <h6>Quantity</h6>
                        <div class="d-flex align-items-center">
                            <div class="def-number-input number-input safari_only">
                                <input class="quantity" min="0" name="quantity" value="1" type="number" />
                            </div>
                        </div>
                    </div>

                    <input id="prod_id" type="hidden" name="product_id" value="{{ $singleproduct->id }}">

                    @if ($singleproduct->is_attribute==1)
                        <div class="ps-product__feature">
                            <div class="ps-product__group">
                                <h6>Size</h6>
                                
                                <div class="input-group mb-3">
                                    <select class="custom-select" product-id="{{ $singleproduct['id'] }}" id="getProductSize" name="productsize">
                                        <option value="">select size</option>
                                        @foreach ($singleproduct->merchadiseattributes as $attribute )
                                            <option value="{{ $attribute->productattr_size }}">{{ $attribute->productattr_size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @else
                        <input id="getProductSize" type="hidden" name="productsize" value="small">
                    @endif
                    
                    <p id="msg" style="font-size: 17px;"></p>

                    <button id="add_product_to_cart"><i class="fas fa-shopping-cart"></i>Add to cart</button>

                    <div class="ps-product__social">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

  