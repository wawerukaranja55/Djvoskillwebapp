<?php use App\Models\Merchadise; ?>

<div class="row">
    <div class="col-md-3">
        <!-- form-group // -->
        <div class="form-group">
            <form name="sortproducts" id="sortproducts">
                <input type="text" name="url" id="url" value="{{ $url }}" style="display:none">
                <select name="sort" class="sort" id="sort">
                    <option value="">Default Sorting</option>
                    <option value="latest_products"
                        @if (isset($_GET['sort']) && $_GET['sort']=="latest_products")
                            selected=""
                        @endif
                    >Latest Products</option>
                    <option value="most_popular"
                        @if (isset($_GET['sort']) && $_GET['sort']=="most_popular")
                            selected=""
                        @endif
                    >Most Popular</option>
                    <option value="low_to_high"
                        @if (isset($_GET['sort']) && $_GET['sort']=="low_to_high")
                            selected=""
                        @endif
                    >Price:Low to High</option>
                    <option value="high_to_low"
                        @if (isset($_GET['sort']) && $_GET['sort']=="high_to_low")
                            selected=""
                        @endif
                    >Price:High to Low</option>
                    <option value="product_name_a_z"
                        @if (isset($_GET['sort']) && $_GET['sort']=="product_name_a_z")
                            selected=""
                        @endif
                    >Product Name:A to Z</option>
                    <option value="product_name_z_a"
                        @if (isset($_GET['sort']) && $_GET['sort']=="product_name_z_a")
                            selected=""
                        @endif
                    >Product Name:Z to A</option>
                </select>
            </form>
        </div>
    </div>
    <div class="col-md-9">
        <!-- form-group // -->
        <div class="float-right">
            {{ $productscategory->count() }} Products Found
        </div>
    </div>
</div>
<!-- content left -->


 <!-- /.content left -->
<div class="d-flex justify-content-center">
    @if(isset($_GET['nice-select'])&&!empty($_GET['nice-select']))
        {{ $productscategory->appends(['nice-select'=>$_GET['nice-select']])->links() }}
    @else
        {{ $productscategory->links() }}
    @endif
</div>

<div class="row">
    <?php if ($productscategory->isEmpty()) { ?>
        No Products Found At the Moment
    <?php } else 
    {
        $countp=0;?>
        @foreach ($productscategory as $product)
            <div class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-5" style="border: 2px solid green">
                <div class="card"> 
                    <img class="card-img-top" src="{{ asset ('images/productimages/small/'.$product->merch_image) }}">
                    <div class="card-body">
                        <h6 class="font-weight-bold pt-1">{{ $product->id }}.{{ $product->merch_name }}</h6>
                        <div class="d-flex align-content-center justify-content-center">
                            <span class="pt-1">{{ $product->merchadisecategor->merchadisecat_title }}</span>
                        </div>
                        1.<span class="pt-1">{{ $product->fabric }}</span>
                        <hr>
                        2.<span class="pt-1">{{ $product->occasion }}</span>
                        <div class="fs-sm mb-4">
                            <input name="quantity" type="number" value="1" class="prod_qty" >
                            <input class="prod_id<?php echo $countp;?>" name="product_id" type="hidden" value="{{ $product->id }}">
                            @if ($product->is_attribute==0)
                                <input class="prodsize" name="productattrsize" type="text" value="small">
                                <div class="d-flex align-items-center justify-content-between pt-3">
                                    <div class="d-flex flex-row">
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
                                </div>
                    
                            @elseif ($product->is_attribute==1)
                                <select class="custom-select prodsize" productid="{{ $product->id }}" name="productattrsize">
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
                                                <p class="lead text-muted text-decoration-line-through" id="showattrprice">sh {{$product->merch_price }}</p>
                                            </del>
                                            <p class="lead text-muted text-decoration-line-through ml-3" id="showcalculatedattrprice" style="float-right">sh {{ $discountedprice }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="d-flex ">
                                <a href="{{ url('merchadise/'.Str::slug($product->merch_name).'/'.$product->id) }}" class="p-3 bg-dark text-white btn btn-primary ml-2">View Product</a>
                                <a class="p-3 bg-dark text-white btn btn-primary ml-2 add-to-cart<?php echo $countp;?>">Add to Cart</a>
                                <div id="successmsg<?php echo $countp;?>" class="alert alert-message bg-grey text-dark"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $countp++?>
        @endforeach
    <?php } ?> 
</div>