<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Slider - Range slider</title>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount_start" ).val(ui.values[ 0 ]);
        $( "#amount_end" ).val(ui.values[ 1 ]);
      }
    });
  });

  function send(){
    var start=$('#amount_start').val();
    var end=$('#amount_end').val();
    // alert(start);
    $.ajax({
      method:"get",
      url:'post',
      data:"start="+start+"&end="+end,
      beforesend:function(){
        $('#showprice').show("fast");
      },

      complete:function(){
        $('#showprice').hide("fast");
      },

      success:function(html){
        $('#showdiv').show("slow");
        $('#showdiv').html("html");
      }
    })
  }
  </script>
</head>
<body>
 
<p>
  <label for="amount">Price range:</label>
  <input type="text" id="amount_start" name="start_price" value="30" style="border:0; color:#f6931f; font-weight:bold;">
  <input type="text" id="amount_end" name="end_price" value="50" style="border:0; color:#f6931f; font-weight:bold;">
</p>
 
<div id="slider-range"></div>
<button onclick="send()"> click here</button>
<div id="showdiv">
  <div id="showprice"></div>
</div>
 
 
</body>
</html>