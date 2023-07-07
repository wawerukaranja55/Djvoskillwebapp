

$.ajaxSetup({
    beforeSend: function(xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        }
    },
});

$(function(){
    var navbar = $('.header-inner');
    $(window).scroll(function(){
        if($(window).scrollTop() <=40){
        navbar.removeClass('navbar-scroll');
        }else{
        navbar.addClass('navbar-scroll');
        }
    });
});

$(document).ready(function(){
    
    $(".dropdown").hover(function(){
        var dropdownMenu = $(this).children(".dropdown-menu");
        if(dropdownMenu.is(":visible")){
            dropdownMenu.parent().toggleClass("open");
        }
    });

    // change price based on the attribute in the product page
    $('#getprice').change(function(){
        var productattr_size=$(this).val();

        if(productattr_size==""){
            alert("Please Select price");
            return false;
        }
        var product_id=$(this).attr("product-id");
        
        $.ajax({
            url:'/getproductprice',
            data:{
                productsize:productattr_size,
                product_id:product_id
            },
            type:'POST',
            success: function(resp){
                console.log(resp);
 

                if( resp['final_price'] !=null){
                
                    $(".getattrCalculatedPrice").html(`sh:${  resp['final_price']}`);
                }
                if( resp['merch_price']!=null){
                
                    $(".merch_price").html(`sh:${  resp['merch_price']}`);
                }
                
            }
                ,error: function(error){
                    console.error(error)
                }
            
        });
    });

    // add product to cart inthe product's page
    $("#add_product_to_cart").on('click',function()
    {
        var prdid=$("#prod_id").val();

        var prdquantity=$(".quantity").val();
        var prdctsize=$("#getProductSize").val();
        
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
                productsize:prdctsize,
            },
            success:function(data){
                console.log(data);
                $("#msg").show();
                $("#msg").addClass("alert alert-warning font-weight-bold").html(data.message);
                $("#msg").fadeOut(6000);

                $("#cartcount").html(data.itemsincart);
                
                // $('#add-to-cart').html(data.message);
                // $('.showproducts').html(data);
            }
        })
    });
});

$('.show_confirm').click(function(event) {
    var form =  $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
        title: `Are you sure you want to delete this item?`,
        text: "This will delete the cart from the basket.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
        form.submit();
    }
    });
});

// select Dynamic dropdown for the shipping counties
$(document).on('change','.county',function(){
    var cnty_id=$(this).val();
    var div=$(this).parent();
    $.ajax({
        type:'get',
        url:'getshippingprice',
        data:{'id':cnty_id},
        success:function(data){

            console.log(data);
            $('.town').html('<option disabled selected value=" ">Select Your City</option>');
            
            console.log("the data is ",data);
            data.forEach((town)=>{
                console.log(town);
                $('.town').append('<option value="'+town.id+'">'+town.town+'</option>');
            });
            
        },error:function(){

        }
    });
});


// show the price based on the town
$(document).on('change','.town',function(){
    var tow_id=$(this).val();
    $.ajax({
        type:'get',
        url:'displayshippingprice',
        data:{'id':tow_id},
        dataType:'json',
        success:function(data){
            console.log(data);
            $('.shippingprice_amount').val(data.shipping_charges);

            var total_amount=$('#subtotal').text();

            var shipping_charges=$('#shippingamount').val(data.shipping_charges);

            $('.pickup_point').val(data.pickuppoint);
            $('.shipping_amount').html(data.shipping_charges);
            var coupon_amount=$('.coupon_amount').val();

            var grand_total=parseInt(total_amount)+parseInt(data.shipping_charges)-coupon_amount;
            //here am displaying the grand_total in the browser
            $('#grand_total').html(grand_total);
            
        },
        error:function(){

        }
    });

    


});

