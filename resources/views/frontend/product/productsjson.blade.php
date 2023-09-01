<?php use App\Models\Merchadise; ?>

<div class="row">
    <div class="col-md-3">
        
    </div>
    <div class="col-md-9">
        <!-- form-group // -->
        <div class="float-right">
            {{ $productscategory->count() }} Products Found
        </div>
    </div>
</div>
<!-- content left -->


<div class="row">
    @if ($productscategory->isEmpty())
        <div class="col-md-12">
            <div style="
            color: rgb(7, 6, 6);
            text-align: center; margin:0; padding:20%; width:100%;">
            <h5>No Products Found At the Moment</h5>
            </div>
        </div>
    @else 
        @foreach ($productscategory as $product)
        <div class="col-md-4 col-sm-6 px-2 mb-4">
            <div class="card product-card" style="box-shadow: 5px 5px 5px 5px #888888; background-color:rgb(241, 248, 248); position: relative;">
                <span class="badge bg-danger badge-success badge-shadow p-2 fs-sm" style="position:absolute;top:2px;left:2px;width:30%;">Featured</span>
                {{-- <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist">
                    <i class="ci-heart"></i>
                </button> --}}
                <a class="card-img-top d-block overflow-hidden" href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}">
                    <img src="{{ asset ('images/productimages/small/'.$product->merch_image) }}" alt="{{ $product->merch_name }}" style="object-fit:cover;box-shadow: 5px 4px 3px 3px rgba(233, 139, 139, 0.1);">
                </a>
                <div class="card-body py-2">
                    <a class="product-meta d-block fs-xs pb-1" href="#">{{ $product->merchadisecategor->merchadisecat_title }}</a>
                    <h3 class="product-title fs-sm">
                        <a href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}">
                            {{-- {!!str_limit($product->merch_name,30)!!} --}}
                            {{ Str::limit($product->merch_name, 30, '...') }}
                        </a>
                    </h3>
                    <div class="d-flex justify-content-between">
                    <div class="product-price">
                        @if ($product->is_attribute==0)
                            <?php $discountedprice=Merchadise::getdiscountedprice($product->id);?>
                            <!-- Product price-->
                            @if ($discountedprice>0)
                                <del class="fs-sm text-muted">sh {{$product->merch_price }}</del>
                                <span class="text-accent" name="productprice" id="showcalculatedattrprice{{ $product->id }}">sh:{{ $discountedprice }}</span>
                            @else
                                <span class="text-accent" name="productprice" id="showcalculatedattrprice{{ $product->id }}">sh:{{$product->merch_price }}</span>
                            @endif
                
                        @elseif ($product->is_attribute==1)
                            <?php $discountedprice=Merchadise::getdiscountedprice($product->id);?>
                            <!-- Product price-->
                            @if ($discountedprice>0)
                                <del class="fs-sm text-muted" id="product_merch_price{{ $product->id }}">sh {{$product->merch_price }}</del>
                                <span class="text-accent" name="productprice" id="showcalculatedattrprice{{ $product->id }}">sh:{{ $discountedprice }}</span>
                            @else
                                <span class="text-accent" name="productprice" id="showcalculatedattrprice{{ $product->id }}">sh:{{$product->merch_price }}</span>
                            @endif
                        @endif
                        
                        {{-- <span class="text-accent">sh {{$product->merch_price }}</span>
                        <del class="fs-sm text-muted" name="productprice" id="showcalculatedattrprice{{ $product->id }}">{{ $discountedprice }}</del> --}}
                    </div>
                    <div class="star-rating">
                    <input type="number" id="prod_qty{{ $product->id }}" name="quantity" value="1" placeholder="1" min="1" style="width: 50px;"/> 
                        {{-- <i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-half active"></i><i class="star-rating-icon ci-star"></i> --}}
                    </div>
                    </div>
                </div>
                <div class="card-body product-size-div">
                    {{-- for showing colours --}}
                        {{-- <div class="text-center pb-2">
                            <div class="form-check form-option form-check-inline mb-2">
                                <input class="form-check-input" type="checkbox" name="color1" id="white">
                                <label class="form-option-label rounded-circle" for="white">
                                    <span class="form-option-color rounded-circle"></span>
                                </label>
                            </div>
                            <div class="form-check form-option form-check-inline mb-2">
                                <input class="form-check-input" type="checkbox" name="color2" id="blue">
                                <label class="form-option-label rounded-circle" for="blue"><span class="form-option-color rounded-circle" style="background-color: #eaeaeb;"></span></label>
                            </div>
                            <div class="form-check form-option form-check-inline mb-2">
                                <input class="form-check-input" type="checkbox" name="color3" id="yellow">
                                <label class="form-option-label rounded-circle" for="yellow"><span class="form-option-color rounded-circle" style="background-color: #eaeaeb;"></span></label>
                            </div>
                        </div> --}}

                    {{-- for showing sizes --}}
                    <div class="d-flex mb-2" style="justify-content: space-between;">
                        @if ($product->is_attribute==1)
                            <select class="form-select form-select-sm me-2 prodsize" id="productsize{{ $product->id }}" name="productattrsize" productid={{ $product->id }}>
                                <option value="" disabled selected>Select Size</option>
                                @foreach ($product->merchadiseattributes as $attribute )
                                    <option value="{{ $attribute->productattr_size }}" required>{{ $attribute->productattr_size }}</option>
                                @endforeach
                            </select>
                        @else
                            <input class="prodsize" id="productsize{{ $product->id }}" name="productattrsize" type="hidden" productid={{ $product->id }} value="none">
                        @endif
                    
                        <button class="btn btn-danger btn-sm font-weight-bold add-to-cart" product_id={{$product->id}} type="button">
                            <i class="fa-solid fa-cart-shopping px-2"></i>Add to Cart</button>
                    </div>
                    <div class="text-center">
                        <a class="nav-link-style fs-ms" href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}">
                            <i class="fa-solid fa-eye px-2 align-middle me-1"></i>Quick view
                        </a>
                    </div>
                </div>
            </div>
            <hr class="d-sm-none">
          </div>



            {{-- <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-5">
                <div class="card"> 
                    <img class="card-img-top" alt="{{ $product->merch_name }}" src="{{ asset ('images/productimages/small/'.$product->merch_image) }}">
                    <div class="card-body">
                        <h6 class="font-weight-bold pt-1">{{ $product->merch_name }}</h6>
                        <div class="d-flex align-content-center justify-content-center">
                            <span class="pt-1">{{ $product->merchadisecategor->merchadisecat_title }}</span>
                        </div> 
                        <span class="pt-1">{{ $product->fabric }}</span>
                        <hr>
                        <span class="pt-1">{{ $product->occasion }}</span>
                        <hr>
                        <span class="pt-1">{{ $product->product_views }} Views</span>
                        <div class="fs-sm mb-4">
                            <input name="quantity" type="number" value="1" id="prod_qty{{ $product->id }}" >
                            <input id="prod_id" name="product_id" type="hidden" prodid="{{ $product->id }}">

                            {{-- product has no attribute 
                            @if ($product->is_attribute==0)
                                <input class="prodsize" id="productsize{{ $product->id }}" name="productattrsize" type="text" productid={{ $product->id }} value="small">
                                <div class="d-flex align-items-center justify-content-between pt-3">
                                    <div class="d-flex flex-row">
                                        <?php $discountedprice=Merchadise::getdiscountedprice($product->id);?>
                                        <!-- Product price-->
                                        @if ($discountedprice>0)
                                            <del>
                                                <p class="lead text-muted text-decoration-line-through">sh {{$product->merch_price }}</p>
                                            </del>
                                            <p class="lead text-muted text-decoration-line-through" style="float-right">sh <span name="productprice" id="showcalculatedattrprice{{ $product->id }}">{{ $discountedprice }}</span></p>
                                        @else
                                            <p class="lead text-muted text-decoration-line-through">sh <span name="productprice" id="showcalculatedattrprice{{ $product->id }}">{{$product->merch_price }}</span></p>
                                        @endif
                                    </div>
                                </div>
                    
                            @elseif ($product->is_attribute==1)
                            {{-- product has attribute 
                                <select class="custom-select prodsize" id="productsize{{ $product->id }}" name="productattrsize" productid={{ $product->id }}>
                                    <option value="">Select</option>
                                    @foreach ($product->merchadiseattributes as $attribute )
                                        <option value="{{ $attribute->productattr_size }}" required>{{ $attribute->productattr_size }}</option>
                                    @endforeach
                                </select>
                            
                                <div class="d-flex align-items-center justify-content-between pt-3">
                                    <div class="d-flex flex-row">
                                        <?php $discountedprice=Merchadise::getdiscountedprice($product->id);?>
                                        <!-- Product price-->
                                        @if ($discountedprice>0)
                                            <del>
                                                <p class="lead text-muted text-decoration-line-through showattrprice">sh<span id="showattrprice{{ $product->id }}">{{$product->merch_price }}</span></p>
                                            </del>
                                            <p class="lead text-muted text-decoration-line-through ml-3" style="float-right">sh<span name="productprice" id="showcalculatedattrprice{{ $product->id }}">{{ $discountedprice }}</span></p>
                                        @else
                                            <p class="lead text-muted text-decoration-line-through ml-3" style="float-right">sh<span name="productprice" id="showcalculatedattrprice{{ $product->id }}">{{$product->merch_price }}</span></p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <p id="msg{{ $product->id }}" style="font-size: 17px;"></p>
                            <br>
                            <div class="d-flex ">
                                <a href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}" class="p-3 bg-dark text-white btn btn-primary ml-2">View Product</a>
                                <a class="p-3 bg-dark text-white btn btn-primary ml-2 add-to-cart" product_id={{$product->id}} >Add to Cart</a>
                                <div id="successmsg" class="alert alert-message bg-grey text-dark"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        @endforeach
    @endif
</div>

<!-- /.content left -->
<div class="d-flex justify-content-center">
    {!! $productscategory->links() !!}
</div>