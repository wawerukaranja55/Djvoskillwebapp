<?php use App\Models\Merchadise;
use App\Models\Merchadisecategory;
// $url=Route::current()->uri();
?>
@extends('frontend.master')
@section('title','Our Merchadise')
@section('content')

@if ($message=Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif

<div class="ps-shop ps-shop--grid">
    <div class="row">
        <div class="col-md-3">
            <ul class="ps-breadcrumb">
                <li class="ps-breadcrumb__item"><a href="{{ url('/') }}">Home</a></li>
                <li class="ps-breadcrumb__item active"><?php echo $categorydetails['breadcrumbs']; ?></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 right-sidebar">
            <!-- right sidebar -->
            <div class="row">
                <!-- /.widget -->
                <div class="col-md-12 widget widget-category">
                    <!-- widget -->
                    <div class="well-box">
                        <h4 class="widget-title">Categories</h4>
                        <ul class="listnone angle-double-right">
                            @foreach ( $productcategories as $category)
                                <li><a href="{{ url('/'.$category->url) }}">{{ $category->merchadisecat_title }}</a> <span>({{ $category->products->count() }})</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- /.widget -->
                <div class="col-md-12 widget widget-tag">
                    <!-- widget -->
                    <div class="well-box">
                        <div class="col-md-12">
                            <p class="clearfix">
                                <h4 class="widget-title">Filter Products Based On Prices</h4>
                                <label for="amount_start">Min Price:<input type="text" id="amount_start" name="start_price" value="0" style="border:0; color:#f6931f; font-weight:bold;"></label>
                                <label for="amount_end">Max Price:<input type="text" id="amount_end" name="end_price" value="1000" style="border:0; color:#f6931f; font-weight:bold;"></label>
                            </p>
                               
                            <div id="slider-range"></div> 
                        </div>
                    </div>
                </div>
                <!-- /.widget -->
                <!-- /.widget -->
                <div class="col-md-12 widget widget-category">
                    <h4 class="widget-title">Search Product By Filter</h4>
                    <!-- widget -->
                    <div class="well-box">
                        <h5 class="widget-title">Fabric</h5>
                        <div class="col-md-12 form-group">
                            @foreach ($fabricarray as $fabric)
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" name="fabric[]" id="{{ $fabric }}" value="{{ $fabric }}" class="fabric">
                                    <label for="fabric" class="control-label"> {{ $fabric }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="well-box">
                        <h5 class="widget-title">Occasion</h5>
                        <div class="col-md-12 form-group">
                            @foreach ($occasionarray as $occasion)
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" name="occasion[]" id="{{ $occasion }}" value="{{ $occasion }}" class="occasion">
                                    <label for="occasion" class="control-label"> {{ $occasion }} </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- /.right sidebar -->
        <div class="col-md-8 content-left">
            
            <div class="row">
                <div id="notificdiv"></div>
                <div class="col-md-3 ps-breadcrumb">
                    <!-- form-group // -->
                    <div class="form-group">
                        <form name="sortproducts" id="sortproducts">
                            <input type="text" name="url" id="url" value="{{ $url }}" style="display:none">
                            <select name="sort" class="sortprods" id="sort">
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
                <div class="col-md-9 ps-breadcrumb">
                    <input type="text" id="search_products" style="width:80%;" class="form-control text-light bg-dark float-right" required name="search_products" placeholder="Search for A Product">@csrf
                    <div id="searchedproducts"></div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div style="
                                width: 100%;
                                display: inline-block;
                                text-align: center;
                            ">
                            <h5>{{ $categorydetails['categorydetails']['merchadisecat_title'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="showproducts">
                @include('frontend.product.productsjson')
            </div>
        </div>
    </div>
    <!-- PRODUCT DETAILS AREA END -->
@endsection

@section('listingpagescripts')
    <script type="text/javascript">
        $(document).ready(function(){
            // live search products and show the products as a list the redirect to the product page
            $('#search_products').keyup(function(){
                var query=$(this).val();
                
                if(query!=''){
                    var token=$('input[name="_token"]').val();
                    var urllink="autocomplete/fetch";
                    var producturl=$("#url").val();

                    $.ajax({
                        url:urllink,
                        method:"post",
                        data:{
                            search_products:query,
                            url:producturl,
                            _token:token 
                        },
                        success:function(data){
                            $('#searchedproducts').fadeIn();
                            $('#searchedproducts').html(data);
                        }
                    });
                }
            });

            // upon clicking the selected option its placed inside the input
            $(document).on('click','li',function(){
                $('#search_products').val($(this).text());
                $('#searchedproducts').fadeOut();
            })

            // remove the other options upon selecting the one we wanted
            const input=document.querySelector('#search_products')
            input.addEventListener('blur',function(event){
                var $trigger=(".filter-box");

                if($trigger !==event.target && !$trigger.has(event.target).length){
                    $(".dropdown-menu").slideUp("fast");
                }
            })

            input.addEventListener('focus',function(){
                $(this).find(".dropdown-menu").slideToggle("fast");
            })

            // sort products on dropdown
            $(".sortprods").on('change',function(){
                var sortproducts=$(this).val();
                var fabric= get_filter(this.class_name);
                var occasion= get_occasionfilter(this.class_name);
                var producturl=$("#url").val();

                console.log(sortproducts);

                $.ajax({
                    url:'/'.$url,
                    method:"get",
                    data:{
                        fabric:fabric,
                        occasion:occasion,
                        url:producturl,
                        sort:sortproducts
                    },
                    success:function(data){
                        $('.showproducts').html(data);
                    }
                });
            });

                    // show products based on the fabric filter selected
            $(".fabric").on('click',function(){
                var fabric= get_filter(this.class_name);
                var occasion= get_occasionfilter(this.class_name);
                var sortmerchads=$(".sortprods option:selected").val();
                var urlmerchads=$("#url").val();

                $.ajax({
                    url:'',
                    method:"get",
                    data:{
                        fabric:fabric,
                        occasion:occasion,
                        url:urlmerchads,
                        sort:sortmerchads
                    },
                    success:function(data){
                        $('.showproducts').html(data);
                    }
                });

            });

            function get_filter(class_name)
            {
                var filter= [];

                $('.fabric:checked').each(function(){
                    filter.push($(this).val());
                });

                return filter;
            }

            // show products based on the occasion filter selected
            $(".occasion").on('click',function(){
                var occasion= get_occasionfilter(this.class_name);
                var fabric= get_filter(this.class_name);
                var sortmerchads=$(".sortprods option:selected").val();
                var urlmerchads=$("#url").val();

                $.ajax({
                    url:'',
                    method:"get",
                    data:{
                        occasion:occasion,
                        fabric:fabric,
                        url:urlmerchads,
                        sort:sortmerchads
                    },
                    success:function(data){
                        $('.showproducts').html(data);
                    }
                });

            });

            function get_occasionfilter(class_name)
            {
                var occasionfilter= [];

                $('.occasion:checked').each(function(){
                    occasionfilter.push($(this).val());
                });

                return occasionfilter;
            }

            // slider function
            $( function() {
                $( "#slider-range" ).slider({

                    range: true,
                    min: 0,
                    max: 1000,
                    values: [ 0, 1000 ],
                    slide: function( event, ui ) {
                        $( "#amount_start" ).val(ui.values[ 0 ]);
                        $( "#amount_end" ).val(ui.values[ 1 ]);

                        var start=$('#amount_start').val();
                        
                        var end=$('#amount_end').val();

                        var urlmerchads=$("#url").val();

                        var sortmerchads=$(".sortprods option:selected").val();

                        var fabric= get_filter(this.class_name);

                        var occasion= get_occasionfilter(this.class_name);
                        $.ajax({
                            method:"get",
                            dataType:'html',
                            url:'',
                            data:{
                                sort:sortmerchads,
                                url:urlmerchads,
                                start:start,
                                end:end,
                                fabric:fabric,
                                occasion:occasion,
                            },

                            success:function(response){
                                console.log(response)
                                
                                $('.showproducts').html(response);
                            }
                        })
                    }
                });
            });

            // live search products by ajax then redirect to the product page

            

                        // live search using jquery and ajax..cant use it for now
                    // $('body').on('keyup','#search_products',function(){
                    //     var searchproducts=$(this).val();

                    //     var producturl=$("#url").val();

                    //     console.log(searchproducts);
                    //     $.ajax({
                    //         method:'get',
                    //         url:'',
                    //         dataType:'json',
                    //         data:{
                    //             url:producturl,
                    //             search_products:searchproducts
                    //         },
                    //         success:function(data){
                    //             console.log(data);
                    //             $('.showproducts').html(data);
                    //         }
                    //     })
                    // });

            // change price based on the attribute in the listing page
            $(".prodsize").change(function(){
                var size=$(this).val();

                var productid=$(this).attr("productid");

                $.ajax({
                    url:'/getattrproductprice',
                    data:{
                        productattrsize:size,
                        productid:productid
                    },
                    type:'POST',
                    success: function(resp){
                        console.log(resp);
        

                        if( resp['final_price'] !=null){
                        
                            $("#showcalculatedattrprice"+productid).html(`sh:${  resp['final_price']}`);
                        }
                        if( resp['merch_price']!=null){
                        
                            $("#showattrprice"+productid).html(`sh:${  resp['merch_price']}`);
                        }
                        
                    }
                        ,error: function(error){
                            console.error(error)
                        }
                    
                });
                
            });

            // add product to cart using Jquery in the listing page
            $(".add-to-cart").on('click',function()
            {
                var prdid=$(this).attr("product_id");
                var prdctprice=$("#showcalculatedattrprice"+prdid).text();
                var prdquantity=$("#prod_qty"+prdid).val();
                var prdctsize=$("#productsize"+prdid).val();

                if( prdctsize === "" ){
                    alert("Please Select An Attribute For The Product");
                    return false;
                }

                $.ajax({
                    method:'post',
                    url:'/addtocart',
                    dataType:'json',
                    data:{
                        product_id:prdid,
                        quantity:prdquantity,
                        productattrsize:prdctsize,
                        productprice:prdctprice
                    },
                    success:function(data){
                        console.log(data);
                        $("#msg"+prdid).show();
                        $("#msg"+prdid).addClass("alert alert-warning font-weight-bold").html(data.message);
                        $("#msg"+prdid).fadeOut(6000);

                        $("#cartcount").html(data.itemsincart);
                        
                        // $('#add-to-cart').html(data.message);
                        // $('.showproducts').html(data);
                    }
                })
            });

        });
    </script>
@stop
