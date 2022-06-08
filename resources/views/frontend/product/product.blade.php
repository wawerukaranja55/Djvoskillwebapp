<?php use App\Models\Merchadise; ?>
@extends('frontend.master')
@section('title','Our Merchadise')
@section('content')

<div class="ps-shop ps-shop--grid">
    <ul class="ps-breadcrumb">
        <li class="ps-breadcrumb__item"><a href="index.html">Home</a></li>
        <li class="ps-breadcrumb__item"><a class="active" aria-current="page" href="#">Shop</a></li>
    </ul>

    <!-- PRODUCT DETAILS AREA START -->
    <div class="ltn__product-area ltn__product-gutter mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__shop-options">
                        <ul>
                            <li>
                                <div class="ltn__grid-list-tab-menu ">
                                    <div class="nav">
                                        {{-- <button class="btn btn-info listview" id="list">
                                            List View
                                        </button> --}}
                                        <button class="btn btn-danger active gridview" id="grid">
                                            Grid View
                                        </button>
                                        {{-- <a class="active show" data-bs-toggle="tab" href="#liton_product_grid"><i class="fas fa-th-large"></i></a>
                                        <a data-bs-toggle="tab" href="#liton_product_list"><i class="fas fa-list"></i></a> --}}
                                    </div>
                                </div>
                            </li>
                            {{-- <li>
                                <p>
                                    <label for="amount">Price range:</label>
                                    <input type="text" id="amount_start" name="start_price" value="250" readonly="readonly" style="border:0px; font-weight:bold;">
                                    <input type="text" id="amount_end" name="end_price" value="400" readonly="readonly" style="border:0px; font-weight:bold;">
                                </p>
                                    
                                <div id="slider-range"></div>
                            </li> --}}
                            <li>
                                <div class="showing-product-number text-right">
                                    <form name="sortproducts">
                                        <select name="nice-select" class="nice-select" id="nice-select">
                                            <option value="">Default sorting</option>
                                            <option value="latest_products"
                                                {{-- @if (isset($_GET['nice-select'])&& $_GET['nice-select']=="latest_products")
                                                    selected=" "
                                                @endif --}}
                                            >Sort by new arrivals</option>
                                            <option value="lowest_price"
                                                {{-- @if (isset($_GET['nice-select'])&& $_GET['nice-select']=="lowest_price")
                                                    selected=" "
                                                @endif --}}
                                            >Sort by price: low to high</option>
                                            <option value="highest_price"
                                                {{-- @if (isset($_GET['nice-select'])&& $_GET['nice-select']=="highest_price")
                                                    selected=" "
                                                @endif --}}
                                            >Sort by price: high to low</option>
                                            <option value="product_name_a-z"
                                                {{-- @if (isset($_GET['nice-select'])&& $_GET['nice-select']=="product_name_a-z")
                                                    selected=" "
                                                @endif --}}
                                            >Product Name A-Z></option>
                                            <option value="product_name_z-a"
                                            {{-- @if (isset($_GET['nice-select'])&& $_GET['nice-select']=="product_name_z-a")
                                                selected=" "
                                            @endif --}}
                                            >Product Name Z-A</option>
                                        </select>
                                    </form>
                                </div> 
                            </li>
                        </ul>
                    </div>
                    <div id="showproducts" class="row grid-group">
                        @if (count($products)>0)
                            @foreach ($products as $product)
                                <div class="item col-xs-3 col-lg-3">
                                    <div class="thumbnail card">
                                        <div class="img-event">
                                            <img class="group list-group-image img-fluid" src="{{ asset ('merchadise/'.$product->merch_image) }}" alt="" style="width: 200px; height:100px;" />
                                        </div>
                                        <div class="caption card-body">
                                            <h4 class="group card-title inner list-group-item-heading">{{$product->merch_name }}</h4>
                                            <p class="group inner list-group-item-text">{{$product->merch_details }}</p>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <?php $discountedprice=Merchadise::getdiscountedprice($product->id);?>
                                                    <!-- Product price-->
                                                    @if ($discountedprice>0)
                                                        <del>
                                                            <p class="lead text-muted text-decoration-line-through">sh {{$product->merch_price }}</p>
                                                        </del>
                                                        <p class="lead text-muted text-decoration-line-through" style="float-right">sh {{ $discountedprice }}</p>
                                                    @else
                                                        <p class="lead text-muted text-decoration-line-through">sh {{$product->merch_price }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a>
                                    {{-- <a class="float-left btn btn-outline-dark mt-auto" href="">View Product</a></div> --}}
                                                    <a class="btn btn-success" href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}">View Product</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <h3>No Merchadise has been added At the Moment</h3>
                        @endif
                    </div>
                    <div class="d-flex justify-content-center">
                        @if(isset($_GET['nice-select'])&&!empty($_GET['nice-select']))
                            {{ $products->appends(['nice-select'=>$_GET['nice-select']])->links() }}
                        @else
                            {{ $products->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT DETAILS AREA END -->        
</div>

<!-- Section-->
{{-- <div class="row">
  <section class="py-5" style="border: 2px solid black;">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            @if (count($products)>0)
                @foreach ($products as $product)
                    <div class="col mb-3" style="border: 2px solid black;">
                        <div class="card h-100">
                            <!-- Sale badge-->
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            <!-- Product image-->
                            <img class="card-img-top img-fluid h-100" src="{{ asset ('merchadise/'.$product->merch_image) }}" alt="{{$product->merch_name}}" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{$product->merch_name}}</h5>
                                    <!-- Product reviews-->
                                    {{-- <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div> 
                                    <?php $discountedprice=Merchadise::getdiscountedprice($product->id);?>
                                    <!-- Product price-->
                                    @if ($discountedprice>0)
                                        <del>
                                            <span class="text-muted text-decoration-line-through">sh {{$product->merch_price }}</span>
                                        </del>
                                        
                                        <span class="text-muted text-decoration-line-through">sh {{ $discountedprice }}</span>
                                    @else
                                    <span class="text-muted text-decoration-line-through">sh {{$product->merch_price }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="tag">
                                    <a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a>
                                    <a class="float-left btn btn-outline-dark mt-auto" href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}">View Product</a></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h3>No Merchadise has been added At the Moment</h3>
            @endif

            <div class="d-flex justify-content-center">
                {!!$products->links() !!}
           </div>
        </div>
    </div>
  </section>
</div> --}}
<script>
    
</script>
@endsection