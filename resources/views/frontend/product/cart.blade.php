
@extends('frontend.master')
@section('title','My Cart')
@section('content')
<!-- Cart Page Start -->
<div class="page-section section pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                  {{-- cart table   --}}
                <div id="appendcartitems" style="border: 2px solid black">
                    @include('frontend.product.cartitems')
                </div>
                
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End --> 
@endsection

@section('cartpagescripts')
    <script type="text/javascript">
        // update items in the cart page
        $(document).on('click','.itemupdate',function(){
            
            if($(this).hasClass('qtyminus')){
                var quantity=$(this).next().val();
                console.log("the quantity is ",quantity);
                new_qty=parseInt(quantity)-1;
                if(quantity<=1){
                    alert("item must be greater or equal to 1");
                    return false;
                }else{
                    new_qty=parseInt(quantity)-1;
                }
            }

            if($(this).hasClass('qtyplus')){
                // console.log($(this).prev());
                var quantity=$(this).prev().val();
                new_qty=parseInt(quantity)+1;
            }

            var cartid=$(this).data('cartid');
            
            $.ajax({
                // $.ajax().always(function(data){
                data:{"cartid":cartid,"quantity":new_qty},
                url:'/updatecartitemquantity',
                type:'post',
                success:function(resp){
                    $("#appendcartitems").html(resp.view);
                },error:function(){
                    alert("error");
                }
            })
        });

        $(document).ready(function(){
           // apply customer coupon
           $("#applycoupon").submit(function(){
                var user=$(this).attr("couponuser");
                
                if(user==1){

                }else{
                    alert("Please Login To Apply Coupon");
                    return false;
                }
                var code=$("#couponcode").val();
                $.ajax({
                    type:'post',
                    data:{code:code},
                    url:'/apply-coupon',
                    success:function(resp){
                        if(resp.message!=""){
                            alert(resp.message);
                        }
                        $("#appendcartitems").html(resp.view);
                        // if(resp.couponAmount>=0){
                        //     $(".couponAmount").text(resp.couponAmount);
                        // }else{
                        //     $(".couponAmount").text("sh.0");
                        // }
                        $(".couponAmount").text(resp.couponAmount);
                        // if(resp.grand_total>=0){
                        //     $(".grand_total").text(resp.grand_total);
                        // }
                        $(".grand_total").text(resp.grand_total);
                    },error:function(){
                        alert("Error");
                    }
                })

            }); 
        });

    </script>
@stop