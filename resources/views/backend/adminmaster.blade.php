<!DOCTYPE html>
<html lang="en">

<head>
      <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">  

  <title>
    @yield('title','Admin Layout')
  </title>
  <!-- plugins:css -->

  <link rel="stylesheet" href="{{ asset('dist/backend/vendors/mdi/css/materialdesignicons.min.css') }}">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
 
  <!--     Fonts and icons     -->
   <link href="{{ asset('dist/backend/font-awesome-4.7.0/css/font-awesome.min.css') }}" rel="stylesheet" />

  <!-- CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  {{-- <link href="{{ asset('bootstrap-4.5.3-dist/css/bootstrap.min.css') }}" rel="stylesheet" /> --}}
  
  <link href="{{ asset('dist/backend/assets/css/vendor.bundle.base.css') }}" rel="stylesheet" />
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('dist/backend/css/style.css') }}"/>

  {{-- css for datatables --}}
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/datatables/DataTables-1.10.25/css/jquery.dataTables.min.css') }}"/>
  {{-- <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/datatables/DataTables-1.10.25/css/dataTables.bootstrap.min.css') }}"/> --}}
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/datatables/FixedHeader-3.1.9/css/fixedHeader.bootstrap.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/datatables/Responsive-2.2.9/css/responsive.bootstrap.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/datatables/Buttons-1.7.1/css/buttons.bootstrap4.min.css') }}"/>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.2/css/fixedHeader.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
 
  {{-- Datepicker --}}
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <!--  Switch buttons  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"/>

  {{-- alertify --}}
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/alertifyjs/css/alertify.min.css') }}"/>
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/alertifyjs/css/themes/default.min.css') }}"/>

  {{-- select2 --}}
  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/select2/select2.min.css') }}"/>

  <link rel="stylesheet" href="{{ asset('assets/adminpanel/js/bootstrap-togglemin/bootstrap-toggle.css') }}"/>

  <!-- endinject -->
  <link rel="icon" type="image/png" href="{{ asset('dist/backend/adminimages/DjVoskillLogo.jpg') }}">
  
  @yield('order_intransitstyles')
  
</head>
<body>
  <div class="container-scroller">
    @include('backend.adminnavbar')
    <div class="container-fluid page-body-wrapper">
      @include('backend.adminsidebar')
      <div class="main-panel">
        @yield('content')
        <div class="content-wrapper">
            
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  
  {{-- update an order for a user --}}
  <div class="modal fade" id="updateordermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Order Status For User</h5>
            </div>
            <div class="modal-body">
              <div class="card padding-card product-card" style="margin-top:20px;">
                <form method="post" id="orderstatusform" role="form">
                    @csrf
                    <input type="hidden" name="order_status_id" id="order_status_id">
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>First Name</label>
                                <input id="order_firstname" class="form-control input-md" readonly/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="checkout-form-list">
                              <label>Last Name</label>
                              <input id="order_lastname" class="form-control input-md" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:10px;">
                      <div class="col-md-12">
                          <div class="checkout-form-list">
                              <label>Order Tracking Id</label>
                              <input id="order_tracking_id" class="form-control input-md" readonly/>
                          </div>
                      </div>
                    </div>
                    <div id="shipping_vehicle_driver_div" style="margin-top:10px;" style="transition: 1s ease-in-out;">
                      <div class="row">
                        <div class="col-md-6" id="shipping_vehicle_child">
                            <div class="checkout-form-list">
                                <label>Vehicle Reg Number</label>
                                <input id="vehicle_reg_number" name="vehicle_reg_no" class="form-control input-md" placeholder="Type Vehicle Registration Number" required style="background: rgb(7, 6, 6);color:white;" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="checkout-form-list">
                              <label>Vehicle Driver</label>
                              <input id="vehicle_driver" name="vehicle_driver" class="form-control input-md" placeholder="Type Vehicle Driver" required style="background: rgb(7, 6, 6);color:white;" type="text"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row" style="margin-top:10px;" id="user_order_status">
                      <div class="col-md-12">
                        <div class="checkout-form-list" style="text-align:center;">
                          <label >Update Order Status</label>
                          <br>
                          <select class="orderstatus form-control adminselect2" required name="orderstatus" style="width: 100%;">
                            <option value=" " disabled="true" selected="true">Update Order to Shipping</option>
                            <option value=" " disabled="true">Paid</option>
                          </select>
                        </div>  
                      </div>
                    </div>
                    <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                    <div class="modal-footer" style="margin-top:10px;">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_order_status" class="btn btn-dark">Update Order Status</button>
                    </div>
                </form>
              </div>
            </div> 
       </div>
    </div>
</div>

  {{-- change vehicle/driver for an order --}}
  <div class="modal fade" id="changevehicledrivermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Change Vehicle/Driver For an Order</h5>
            </div>
            <div class="modal-body">
              <div class="card padding-card product-card" style="margin-top:20px;">
                <form method="post" id="changedrivervehicleform" role="form">
                    @csrf
                    <input type="hidden" name="order_status_id" id="driver_order_id">
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>First Name</label>
                                <input id="driver_order_firstname" class="form-control input-md" readonly/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="checkout-form-list">
                              <label>Last Name</label>
                              <input id="driver_order_lastname" class="form-control input-md" readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top:10px;">
                      <div class="col-md-12">
                          <div class="checkout-form-list">
                              <label>Order Tracking Id</label>
                              <input id="driver_order_tracking_id" class="form-control input-md" readonly/>
                          </div>
                      </div>
                    </div>
                    <div id="driver_order_div" >
                      <div class="row" style="margin-top:10px;">
                        <div class="col-md-6" id="shipping_vehicle_child">
                            <div class="checkout-form-list">
                                <label>Change Vehicle Reg Number</label>
                                <input id="driver_order_reg_number" name="vehicle_reg_no" class="form-control input-md" placeholder="Type Vehicle Registration Number" required style="background: rgb(7, 6, 6);color:white;" type="text"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                          <div class="checkout-form-list">
                              <label>Change Vehicle Driver</label>
                              <input id="driver_order_driver" name="vehicle_driver" class="form-control input-md" placeholder="Type Vehicle Driver" required style="background: rgb(7, 6, 6);color:white;" type="text"/>
                          </div>
                        </div>
                      </div>
                      <div class="row" id="shipping_vehicle_text" style="margin-top:10px;">
                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Reason For Changing the Driver/Vehicle</label>
                                <textarea id="driver_order_info" name="vehicle_change_info" class="form-control" placeholder="Type the reason why you changed the order..." style="background:black; color:white" required></textarea>
                            </div>
                        </div>
                      </div>
                    </div>
                    
                    <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                    <div class="modal-footer" style="margin-top:10px;">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit_infor" class="btn btn-dark">Change Driver/Vehicle For an Order</button>
                    </div>
                </form>
              </div>
            </div> 
      </div>
    </div>
  </div>

  {{-- confirm order picking --}}
  <div class="modal fade" id="pickordermodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Order Pick By Recipient</h5>
            </div>
            <div class="modal-body">
              <div class="card padding-card product-card" style="margin-top:20px;">
                <form method="post" id="pickorderform" role="form">
                    @csrf
                    <input type="hidden" name="picked_status_id" id="recipient_order_id">
                    
                    <div class="row" style="margin-top:10px;">
                      <div class="col-md-12">
                          <div class="checkout-form-list" style="text-align: center;">
                              <label>Order Tracking Id</label>
                              <input id="picked_order_tracking_id" style="text-align: center;" class="form-control input-md" readonly/>
                          </div>
                      </div>
                    </div>

                    <div class="row" style="margin-top:10px;">
                      <div class="col-md-6">
                          <div class="checkout-form-list">
                              <label>First Name</label>
                              <input id="recipient_firstname" name="recipient_firstname" style="background: rgb(7, 6, 6);color:white;" class="form-control input-md" required placeholder="Recipient First Name"/>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="checkout-form-list">
                            <label>Last Name</label>
                            <input id="recipient_lastname" name="recipient_lastname" style="background: rgb(7, 6, 6);color:white;" class="form-control input-md" required placeholder="Recipient Last Name"/>
                          </div>
                      </div>
                    </div>
                    <div class="row" style="margin-top:10px;">
                      <div class="col-md-6">
                          <div class="checkout-form-list">
                              <label>Recipient Id Number</label>
                              <input id="recipient_id_number" name="recipient_id_number" class="form-control input-md" placeholder="Type Vehicle Registration Number" required style="background: rgb(7, 6, 6);color:white;" type="text"/>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="checkout-form-list">
                            <label>Recipient Phone Number</label>
                            <input id="recipient_phone" name="recipient_phone" class="form-control input-md" placeholder="Type Vehicle Driver" required style="background: rgb(7, 6, 6);color:white;" type="text"/>
                        </div>
                      </div>
                    </div>

                    <div class="row" style="margin-top:10px;">
                      <div class="col-md-12">
                        <div class="checkout-form-list" style="text-align:center;">
                          <label >Update Order Status</label>
                          <br>
                          <select class="orderstatus form-control adminselect2" required name="orderstatus" style="width: 100%;">
                            <option value=" " disabled="true" selected="true">Update Order to Shipping</option>
                            <option value=" " disabled="true">Paid</option>
                          </select>
                        </div>  
                      </div>
                    </div>
                    
                    <ul class="alert alert-warning d-none checkout_errorlist"></ul>
                    <div class="modal-footer" style="margin-top:10px;">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" id="pick_order" class="btn btn-dark">Confirm Order Picking</button>
                    </div>
                </form>
              </div>
            </div> 
      </div>
    </div>
  </div>

  {{-- <script src="{{ asset('assets/frontuser/js/jquery-3.5.1.js') }}"></script> --}}
  <script src="{{ asset('assets/frontuser/js/jquery-3.5.1.js') }}"></script>
  <script type="text/javascript" src="{{ asset('assets/frontuser/bootstrap/bootstrap.bundle.min.js')}}"></script>

  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/DataTables-1.10.25/js/jquery.dataTables.min.js')}}"></script> 
      {{-- <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/DataTables-1.10.25/js/dataTables.bootstrap.min.js')}}"></script> --}}
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/Responsive-2.2.9/js/dataTables.responsive.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/Buttons-1.7.1/js/dataTables.buttons.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/jszip3.1.3/jszip.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/pdfmake-0.1.36/pdfmake.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/pdfmake-0.1.36/vfs_fonts.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/Buttons-1.7.1/js/buttons.html5.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/adminpanel/js/datatables/Buttons-1.7.1/js/buttons.print.min.js')}}"></script>

  {{-- alertify --}}
  <script src="{{ asset('assets/adminpanel/js/alertifyjs/alertify.min.js') }}"></script>

  {{-- bootsrap date picker --}}
  <script src="{{ asset('assets/adminpanel/js/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/adminpanel/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

  {{-- bootstrap toggle --}}
  <script src="{{ asset('assets/adminpanel/js/bootstrap-togglemin/bootstrap-toggle.min.js') }}"></script>

  {{-- select2 --}}
  <script src="{{ asset('assets/adminpanel/js/select2/select2.min.js') }}"></script>
  {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
  {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> --}}

  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/fixedheader/3.2.2/js/dataTables.fixedHeader.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>

  {{-- datepicker --}}
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


  <!-- Custom js for this page-->
  {{-- <script src="{{ asset('dist/backend/js/dashboard.js') }}"></script> --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="{{asset('assets/adminpanel/js/ckeditor/ckeditor.js')}}"></script>
  <script src="{{asset('assets/adminpanel/js/adminpanelcustom.js')}}"></script>

  {{-- Switch cdns --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

@yield('viewshippingscript')

@yield('adminordersscript')
      
@section('scripts')
<script>	
    // show the date picker
    // $(function(){
    //   $('#datepicker').datepicker({
    //       dateFormat: "mm/dd/yy",
    //       changeMonth: true,
    //       changeYear: true
    //   });
    // });

    $(document).ready(function(){

      $(".adminselect2").select2();


        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div ><div style="height:10px;"></div><input type="text" name="productattr_size[]" style="width:120px" placeholder="productattr_size"/>&nbsp;<input type="text" name="productattr_price[]" style="width:120px" placeholder="productattr_price"/>&nbsp;<input type="text" name="productattr_stock[]" style="width:120px" placeholder="productattr_stock"/>&nbsp;<input type="text" name="productattr_sku[]" style="width:120px" placeholder="productattr_sku"/>&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>';
                        //New input field html 

        var x = 1; //Initial field counter is 1
        
        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){ 
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });

        // empty order modal on closing it
        $("#updateordermodal").on('hide.bs.modal', function(){
            $('#order_firstname').val('');
            $('#order_lastname').val('');
            $('#order_status_id').val('');
            $('#order_tracking_id').val('');
            $('#vehicle_reg_number').val('');
            $('#vehicle_driver').val('');
        });

        // empty vehicle reg modal on closing it
        $("#changevehicledrivermodal").on('hide.bs.modal', function(){
            $('#driver_order_firstname').val('');
            $('#driver_order_lastname').val('');
            $('#driver_order_status_id').val('');
            $('#driver_order_tracking_id').val('');
            $('#driver_order_info').val('');
        });

        // empty vehicle reg modal on closing it
        $("#pickordermodal").on('hide.bs.modal', function(){
            $('#picked_order_tracking_id').val('');
            $('#recipient_order_id').val('');
            $('#recipient_firstname').val('');
            $('#recipient_lastname').val('');
            $('#recipient_id_number').val('');
            $('#recipient_phone').val('');
        });
    });

    $(".updateattributestatus").click(function(){
      var status=$(this).text();
      var attribute_id=$(this).attr("attribute_id");
      $.ajax({
        type:'post',
        url:'admin/updateattributestatus',
        data:{status:status,attribute_id:attribute_id},
        success:function(resp){
          if(resp['productattr_status']==0){
            $("#attribute-"+attribute_id).html("Inactive")
          }else if(resp['productattr_status']==1){
            $("#attribute-"+attribute_id).html("Active")
          }
        } ,error:function(){
          alert("Error");
        }
      });
    });

    // change shipping status to active or inactive
    $(function(){
      $('.shippingstatus').change(function(){
          var status=$(this).prop('checked')==true? 1:0;
          var shipping_id=$(this).data('id');
          $.ajax({
              type:"GET",
              dataType:"json",
              url:'{{ route('updateshippingstatus') }}',
              data:{'status':status,'shipping_id':shipping_id},
              success:function(data){
                  $('#notific').fadein();
                  $('#notific').css('background','green');
                  $('#notific').text('status changed Successfully');
                  setTimeout(() => {
                    $('#notific').fadeout();
                  }, 3000);
              }
          });
      });
    });

    // change coupon status to active or inactive
    $(function(){
      $('.couponstatus').change(function(){
          var status=$(this).prop('checked')==true? 1:0;
          var coupon_id=$(this).data('id');
          $.ajax({
              type:"GET",
              dataType:"json",
              url:'{{ route('updatecouponstatus') }}',
              data:{'status':status,'coupon_id':coupon_id},
              success:function(data){
                  $('#notific').fadein();
                  $('#notific').css('background','green');
                  $('#notific').text('status changed Successfully');
                  setTimeout(() => {
                    $('#notific').fadeout();
                  }, 3000);
              }
          });
      });
    });

    // change section status to active or inactive
    $(function(){
      $('.sectionstatus').change(function(){
          var status=$(this).prop('checked')==true? 1:0;
          var section_id=$(this).data('id');
          $.ajax({
              type:"GET",
              dataType:"json",
              url:'{{ route('updatesectionstatus') }}',
              data:{'status':status,
              'sectionid':section_id},
              success:function(data){
                  $('#notific').fadein();
                  $('#notific').css('background','green');
                  $('#notific').text('status changed Successfully');
                  setTimeout(() => {
                    $('#notific').fadeout();
                  }, 3000);
              }
          });
      });
    });

    // change category status to active or inactive
    $(function(){
      $('.categorystatus').change(function(){
          var status=$(this).prop('checked')==true? 1:0;
          var category_id=$(this).data('id');

          alert(status);
          $.ajax({
              type:"GET",
              dataType:"json",
              url:'{{ route('updatecategorystatus') }}',
              data:{'status':status,
              'category_id':category_id},
              success:function(data){
                  $('#notific').fadein();
                  $('#notific').css('background','green');
                  $('#notific').text('status changed Successfully');
                  setTimeout(() => {
                    $('#notific').fadeout();
                  }, 3000);
              }
          });
      });
    });

    $(document).ready(function(){
      $("#manualcoupon").click(function(){
        $("#coupon_field").show();
      });

      $("#automaticcoupon").click(function(){
        $("#coupon_field").hide();
      });

      $('.couponselect2').select2();

      $('.adminselect2').select2();
      
      $('.usersselect2').select2();

      $(".productid").click(function() {
        var productid=$(this).attr('id');
      }); 
    });

    // $(function(){
    //   $("#expiry_date").datepicker();
    // });

  //  datatables
  $(document).ready(function() {
    var table = $('#products').DataTable( {
        responsive: true
    } );
 
    new $.fn.dataTable.FixedHeader( table );
  });
</script>
    
  
</body>
</html>
