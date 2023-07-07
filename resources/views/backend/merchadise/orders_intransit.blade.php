
@extends('backend.adminmaster')
@section('title','Orders Intransit')
@section('content')
@section('order_intransitstyles')
    <style>
        .actionbtn {
            position: relative;
            }

            .actionbtn .tooltip {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 100%;
            left: 50%;
            margin-left: -60px;
            
            /* Fade in tooltip - takes 1 second to go from 0% to 100% opac: */
            opacity: 0;
            transition: opacity 1s;
            }

            .actionbtn:hover .tooltip {
            visibility: visible;
            opacity: 1;
            }

    </style>
@stop
<div class="container">
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif
    {{-- Show all orders --}}
    <div class="container">
        <div class="row shadow mb-5 bg-black rounded">
            <div class="col-lg-12">
              <div class="panel-heading mt-5" style="text-align: center;"> 
                  <h3 class="mb-2 panel-title">Orders In_Transit</h3> 
              </div>
              <table id="adminorderstable" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
                  <thead>
                      <tr>
                          <th>Id</th>
                          <th>Phone</th>
                          <th>Town</th>
                          <th>Order Status</th>
                          <th>Tracking Id</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>
        </div>
    </div>
    <!-- end col -->
</div>
@endsection

@section('adminordersscript')
    
    <script>

        // show all orders in a datatable
        var adminorderstable = $('#adminorderstable').DataTable({
            processing:true,
            serverside:true,
            responsive:true,

            ajax:"{{ route('users.intransitorders') }}",
            columns: [
                { data: 'id' },
                { data: 'phone' },
                { data: 'town' },
                { data: 'order_status' },
                { data: 'tracking_id' },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],
        });

        // show modal to change order status
        $(document).on('click','#orderintransit',function(e){
            e.preventDefault();

            var order_id=$(this).val();
            var url = '{{ route("user.order", ":id") }}';
                    url = url.replace(':id', order_id);
            $('#updateordermodal').modal('show');

            $.ajax({
                type:"GET",
                url:url,
                processData: false,
                contentType: false,
                success:function(response)
                {
                    console.log(response);
                    if (response.status==200)
                    {   
                        $('#order_firstname').val(response.orderdata.first_name);
                        $('#order_lastname').val(response.orderdata.last_name);
                        $('#order_status_id').val(response.orderdata.id);
                        $('#order_tracking_id').val(response.orderdata.tracking_id);
                        $('#vehicle_reg_number').val(response.orderdata.shipping_vehicle.vehicle_reg_no);
                        $('#vehicle_driver').val(response.orderdata.shipping_vehicle.vehicle_driver);
                        $('.orderstatus').append('<option disabled="true">In Transit</option>');
                        $('.orderstatus').append('<option value="Delivered">Delivered</option>');
                    }
                }
            })
        })

        // show modal to change order vehicle or driver
        $(document).on('click','#changedrivervehicle',function(e){
            e.preventDefault();

            var order_id=$(this).val();
            var url = '{{ route("user.order", ":id") }}';
                    url = url.replace(':id', order_id);
            $('#changevehicledrivermodal').modal('show');

            $.ajax({
                type:"GET",
                url:url,
                processData: false,
                contentType: false,
                success:function(response)
                {
                    console.log(response);
                    if (response.status==200)
                    {
                        $('#driver_order_firstname').val(response.orderdata.first_name);
                        $('#driver_order_lastname').val(response.orderdata.last_name);
                        $('#driver_order_id').val(response.orderdata.id);
                        $('#driver_order_tracking_id').val(response.orderdata.tracking_id);
                        $('#driver_order_reg_number').val(response.orderdata.shipping_vehicle.vehicle_reg_no);
                        $('#driver_order_driver').val(response.orderdata.shipping_vehicle.vehicle_driver);
                    }
                }
            })
        })

        // update customer order from a vehicle/driver to another
        $(document).on('submit','#changedrivervehicleform',function(e){
            e.preventDefault();

            var orderid=$('#driver_order_id').val();
            alert(orderid);
            var url = '{{ route("update_order.vehicle_reg", ":id") }}';
                url = url.replace(':id', orderid);

            $.ajax({
                url:url,
                type:"POST",
                data:$("#changedrivervehicleform").serialize(),
                success:function(response){
                    console.log(response);
                    
                    if (response.status==200)
                    {
                        $('#changevehicledrivermodal').modal('hide');
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        $('#driver_order_firstname').val('');
                        $('#driver_order_lastname').val('');
                        $('#driver_order_status_id').val('');
                        $('#driver_order_tracking_id').val('');
                        $('#driver_order_info').val('');
                    }
                }
                ,error: function(error)
                {
                    console.error(error)
                }
            });
        })

        // $(document).on('click','#change_driver_btn',function(e){
        //     e.preventDefault();
        //     $('#shipping_vehicle_div').slideToggle();
        // })

         // update customer order status to Delivered
         $(document).on('submit','#orderstatusform',function(e){
            e.preventDefault();

            var orderid=$('#order_status_id').val();
            var url = '{{ route("update.order", ":id") }}';
                url = url.replace(':id', orderid);

            $.ajax({
                url:url,
                type:"POST",
                data:$("#orderstatusform").serialize(),
                success:function(response){
                    console.log(response);
                    
                    if (response.status==200)
                    {
                        $('#updateordermodal').modal('hide');
                        adminorderstable.ajax.reload(null,false);
                        alertify.set('notifier','position', 'top-right');
                        alertify.success(response.message);
                        $('#order_status_id').val('');
                        $('#orderstatus').val('');
                    }
                }
                ,error: function(error)
                {
                    console.error(error)
                }
            });
        })

    </script>
@stop

