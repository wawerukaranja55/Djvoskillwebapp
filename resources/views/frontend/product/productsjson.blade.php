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
        No Products Found At the Moment
    @else 
        @foreach ($productscategory as $product)
            <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-5">
                <div class="card"> 
                    <img class="card-img-top" src="{{ asset ('images/productimages/small/'.$product->merch_image) }}">
                    <div class="card-body">
                        <h6 class="font-weight-bold pt-1">{{ $product->id }}.{{ $product->merch_name }}</h6>
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