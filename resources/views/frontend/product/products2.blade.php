<?php use App\Models\Merchadise; 
// $url=Route::current()->uri();
?>
@extends('frontend.master')
@section('title','Our Merchadise')
@section('content')

<div class="ps-shop ps-shop--grid">
    <ul class="ps-breadcrumb">
        <li class="ps-breadcrumb__item"><a href="index.html">Home</a></li>
        <li class="ps-breadcrumb__item"><a href="index.html">Shop</a></li>
        <li class="ps-breadcrumb__item"><a class="active" aria-current="page" href="#">Women</a></li>
    </ul>
    <div class="row">
        <div class="col-md-4 right-sidebar">
            <!-- right sidebar -->
            <div class="row">
                <!-- /.widget -->
                <div class="col-md-12 widget widget-category">
                    <!-- widget -->
                    <div class="well-box">
                        <h3 class="widget-title">Categories</h3>
                        <ul class="listnone angle-double-right">
                            @foreach ( $productcategories as $category)
                                <li><a href="#">{{ $category->merchadisecat_title }}</a> <span>({{ $category->products->count() }})</span></li>
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
                                <label for="amount">Price range:</label>
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
                    <h3 class="widget-title">Search Product By Filter</h3>
                    <!-- widget -->
                    <div class="well-box">
                        <h4 class="widget-title">Fabric</h4>
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
                        <h4 class="widget-title">Occasion</h4>
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
            // sort products on dropdown
            $("#sort").on('change',function(){
                var sortproducts=$(this).val();
                var fabric= get_filter(this.class_name);
                var producturl=$("#url").val();

                $.ajax({
                    url:url,
                    method:"get",
                    data:{
                        fabric:fabric,
                        url:producturl,
                        sort:sortproducts
                    },
                    success:function(data){
                        $('.showproducts').html(data);
                    }
                });
            });

                    // show products based on the filter selected
            $(".fabric").on('click',function(){
                var fabric= get_filter(this.class_name);
                var sortmerchads=$("#sort option:selected").val();
                var urlmerchads=$("#url").val();

                $.ajax({
                    url:url,
                    method:"get",
                    data:{
                        fabric:fabric,
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

                        var fabric= get_filter(this.class_name);
                        $.ajax({
                            method:"get",
                            dataType:'html',
                            url:'',
                            data:{
                                start:start,
                                end:end,
                                fabric:fabric,
                            },

                            success:function(response){
                                console.log(response)
                                
                                $('.showproducts').html(response);
                            }
                        })
                    }
                });
            });

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
                        
                            $("#showcalculatedattrprice").html(`sh:${  resp['final_price']}`);
                        }
                        if( resp['merch_price']!=null){
                        
                            $("#showattrprice").html(`sh:${  resp['merch_price']}`);
                        }
                        
                    }
                        ,error: function(error){
                            console.error(error)
                        }
                    
                });
                
            });

            // add product to cart using Jquery in the listing page
            <?php $maxp = count($productscategory); 
                for($i=0;$i<$maxp; $i++){?>
                $('#successmsg<?php echo $i;?>').hide();

                $('.add-to-cart<?php echo $i;?>').click(function(e)
                {
                    e.preventDefault();

                    var prod_id<?php echo $i;?>=$(this).closest('.ps-shop').find('.prod_id<?php echo $i;?>').val();

                    var prod_qty=$(this).closest('.ps-shop').find('.prod_qty').val();

                    var prod_size=$(this).closest('.ps-shop').find('.prodsize').val();
                
                    alert(prod_size)
                    if(prod_size==""){
                        alert("Please Select An Attribute");
                        return false;
                    }
                // alert(prod_id<?php echo $i;?>);

                    $.ajax({
                        method:"post",
                        url:"add-to-cart",
                        data:{
                            'productattrsize':prod_size,
                            'product_id':prod_id<?php echo $i;?>,
                            'quantity':prod_qty,
                        },
                        success:function(response){
                            // console.log(response)
                            $('.add-to-cart<?php echo $i;?>').hide();

                            $('#successmsg<?php echo $i;?>').show();
                            $('#successmsg<?php echo $i;?>').append('product has been added to cart');
                        }
                    });

            });
            <?php }?>
        });
    </script>
@stop
