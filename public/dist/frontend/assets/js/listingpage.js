$(document).ready(function(){
    // add product to cart using Jquery in the listing page
    <?php $maxp = count($products); 
        for($i=0;$i<$maxp; $i++){?>
            $('#successmsg<?php echo $i;?>').hide();
            $('.add-to-cart<?php echo $i;?>').click(function(e)
            {
        e.preventDefault();

        var prod_id<?php echo $i;?>=$(this).closest('.ps-shop').find('.prod_id<?php echo $i;?>').val();

        var prod_qty=$(this).closest('.ps-shop').find('.prod_qty').val();

        var prod_size=$(this).closest('.ps-shop').find('.prod_size').val();
        
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

