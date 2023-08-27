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
        <div class="row">
            <div class="col-md-12">
                <div style="width: 100%;
                padding:50%;
                color: white;
                display: flex;
                justify-content: center;">
                <h5>No Products Found At the Moment</h5>
                </div>
            </div>
        </div>
    @else 
        @foreach ($productscategory as $product)
        <div class="col-md-4 col-sm-6 px-2 mb-4">
            <div class="card product-card">
                <span class="badge bg-danger badge-shadow">Featured</span>
                <button class="btn-wishlist btn-sm" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to wishlist">
                    <i class="ci-heart"></i>
                </button>
                <a class="card-img-top d-block overflow-hidden" href="shop-single-v1.html">
                    <img src="img/shop/catalog/02.jpg" alt="Product">
                </a>
              <div class="card-body py-2">
                <a class="product-meta d-block fs-xs pb-1" href="#">Women’s T-shirt</a>
                <h3 class="product-title fs-sm">
                    <a href="shop-single-v1.html">Cotton Lace Blouse</a>
                </h3>
                <div class="d-flex justify-content-between">
                  <div class="product-price">
                    <span class="text-accent">$28.<small>50</small></span>
                    <del class="fs-sm text-muted">38.<small>50</small></del>
                  </div>
                  {{-- <div class="star-rating"><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-filled active"></i><i class="star-rating-icon ci-star-half active"></i><i class="star-rating-icon ci-star"></i>
                  </div> --}}
                </div>
              </div>
              <div class="card-body card-body-hidden">
                {{-- for showing colours --}}
                <div class="text-center pb-2">
                  <div class="form-check form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="color1" id="white" checked>
                    <label class="form-option-label rounded-circle" for="white"><span class="form-option-color rounded-circle" style="background-color: #eaeaeb;"></span></label>
                  </div>
                  <div class="form-check form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="color1" id="blue">
                    <label class="form-option-label rounded-circle" for="blue"><span class="form-option-color rounded-circle" style="background-color: #d1dceb;"></span></label>
                  </div>
                  <div class="form-check form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="color1" id="yellow">
                    <label class="form-option-label rounded-circle" for="yellow"><span class="form-option-color rounded-circle" style="background-color: #f4e6a2;"></span></label>
                  </div>
                  <div class="form-check form-option form-check-inline mb-2">
                    <input class="form-check-input" type="radio" name="color1" id="pink">
                    <label class="form-option-label rounded-circle" for="pink"><span class="form-option-color rounded-circle" style="background-color: #f3dcff;"></span></label>
                  </div>
                </div>

                {{-- for showing sizes --}}
                <div class="d-flex mb-2">
                  <select class="form-select form-select-sm me-2">
                    <option>XS</option>
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                  </select>
                  <button class="btn btn-primary btn-sm" type="button"><i class="ci-cart fs-sm me-1"></i>Add to Cart</button>
                </div>
                <div class="text-center"><a class="nav-link-style fs-ms" href="#quick-view" data-bs-toggle="modal"><i class="ci-eye align-middle me-1"></i>Quick view</a></div>
              </div>
            </div>
            <hr class="d-sm-none">
          </div>



            <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-5">
                <div class="card"> 
                    <img class="card-img-top" alt="{{ $product->merch_name }}" src="{{ asset ('images/productimages/small/'.$product->merch_image) }}">
                    <div class="card-body">
                        <h6 class="font-weight-bold pt-1">{{ $product->merch_name }}</h6>
                        {{-- <div class="d-flex align-content-center justify-content-center">
                            <span class="pt-1">{{ $product->merchadisecategor->merchadisecat_title }}</span>
                        </div> --}}
                        <span class="pt-1">{{ $product->fabric }}</span>
                        <hr>
                        <span class="pt-1">{{ $product->occasion }}</span>
                        <hr>
                        <span class="pt-1">{{ $product->product_views }} Views</span>
                        <div class="fs-sm mb-4">
                            <input name="quantity" type="number" value="1" id="prod_qty{{ $product->id }}" >
                            <input id="prod_id" name="product_id" type="hidden" prodid="{{ $product->id }}">

                            {{-- product has no attribute --}}
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
                            {{-- product has attribute --}}
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
            </div>
        @endforeach
    @endif
</div>

<!-- /.content left -->
<div class="d-flex justify-content-center">
    {!! $productscategory->links() !!}
</div>