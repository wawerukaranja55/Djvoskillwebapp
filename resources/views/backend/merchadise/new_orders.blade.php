
@extends('backend.adminmaster')
@section('title','New Orders')
@section('content')
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
                  <h3 class="mb-2 panel-title">New Orders Placed By Clients</h3> 
              </div>
              <table id="adminorderstable" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
                  <thead>
                      <tr>
                          <th>Id</th>
                          <th>Phone</th>
                          <th>Town</th>
                          <th>Payment Method</th>
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

            ajax:"{{ route('users.neworders') }}",
            columns: [
                { data: 'id' },
                { data: 'phone' },
                { data: 'town' },
                { data: 'payment_method' },
                { data: 'order_status' },
                { data: 'tracking_id' },
                { data: 'action',name:'action',orderable:false,searchable:false },
            ],
        });

        // show modal to change order status
        $(document).on('click','#orderstatus',function(e){
            e.preventDefault();

            var order_id=$(this).val();
            var url = '{{ route("user.order", ":id") }}';
                    url = url.replace(':id', order_id);
            $('#updateordermodal').modal('show');
            $('#shipping_vehicle_text').hide();

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
                        $('.orderstatus').append('<option value="In_Transit">In transist</option>');
                    }
                }
            })
        })

         // update customer order status to shipping
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

