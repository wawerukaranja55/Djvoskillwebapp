
@extends('frontend.master')
@section('title','My Cart')
@section('content')
<!-- Cart Page Start -->
<div class="page-section section pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                  {{-- cart table   --}}
                <div id="appendcartitems">
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
                    console.log(resp);
                    $("#cartcount").html(resp.totalitemsincart);
                    $("#appendcartitems").html(resp.view);
                },error:function(){
                    alert("error");
                }
            })
        });

    </script>
@stop