@extends('backend.adminmaster')
@section('title','Shipping Charges')
@section('content')
<?php use App\Models\shipping_charge; ?>
    <div class="content-wrapper">
        <form action="javascript:void(0)" id="addshippingprice" class="form-horizontal" role="form" method="POST" style="margin: 5px;">
            @csrf
            <div class="card padding-card product-card">
                <div class="card-body">
                    <h5 class="card-title mb-4" style="color: black; font-size:18px;">Add a Shipping Price For Each Town</h5>
                    <ul class="alert alert-warning d-none" id="shippingprice_errorlist"></ul>
                    <div class="row section-groups">
                        <div class="form-group inputdetails col-sm-6">
                            <label>Select County<span class="text-danger inputrequired">*</span></label>
                            <br>
                            <select name="county" id="selectcounty" class="adminselect2 form-control text-white bg-dark" style="width:100%;" required>
                                
                                <?php
                                    $all_counties=shipping_charge::where('is_shipping',1)->get();
                                ?>
                                <option value="" disabled selected>Select A County</option>
                                @foreach($all_counties as $county)
                                    <option value="{{ $county->id }}">{{ $county->county }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group inputdetails col-sm-6">
                            <label>Name Of The Town<span class="text-danger inputrequired">*</span></label>
                            <input type="text" class="form-control text-white bg-dark" required required name="county_town" id="county_town" placeholder="Write The Town of The County">
                        </div>
                    </div>
                    <div class="row section-groups">
                     <div class="form-group inputdetails col-sm-6">
                         <label>Pick Up Point Name<span class="text-danger inputrequired">*</span></label>
                         <input type="text" class="form-control text-white bg-dark" required required name="pick_up_point" id="pick_up_point" placeholder="Write The Name of the Pick up Point">
                     </div>
                     <div class="form-group inputdetails col-sm-6">
                         <label>Shipping Charge Price<span class="text-danger inputrequired">*</span></label>
                         <input type="number" class="form-control text-white bg-dark" required required name="town_price" id="town_price" placeholder="Write The Price for that town delivery">
                     </div>
                 </div>
                </div>
                <button type="submit" style="text-align: center;width:50%;margin:1px auto;" class="btn btn-success">Add The Pick Up Point With Price</button>
            </div>
            
        </form>

        <div class="row" style="margin-top:20px;"> 
            <div class="col-md-8">
                <h3 style="color: black; font-size:23px;text-align:center;font-weight:600;">Shipping Costs For Towns</h3>
                <table class="table table-striped table-bordered pickuppointstable" style="margin-top:10px;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>County</th>
                            <th>Town</th>
                            <th>Pick_Up Point</th>
                            <th>Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h3  style="color: black; font-size:23px;text-align:center;font-weight:600;">Counties To Ship</h3>
                <table class="table table-striped table-bordered countiestable" style="margin-top:10px;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>County</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection

    @section('viewshippingscript')
      <script>
    
    
          // show all shipping prices in a datatable
          var shippingpricestable = $('.pickuppointstable').DataTable({
             processing:true,
             serverside:true,
             responsive:true,
    
             ajax:"{{ route('get_shippingprices') }}",
             columns: [
                { data: 'id' },
                {data: 'county_id', name:'county_id.shippingcounty', orderable:true,searchable:true},
                { data: 'town' },
                { data: 'pickuppoint' },
                { data: 'shipping_charges' },
                { data: 'status',
                   render: function ( data, type, row ) {
                      if ( type === 'display' ) {
                            return '<input class="toggle-class townshippingstatus" disabled type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                      }
                      return data;
                   }
                },
                { data: 'action',name:'action',orderable:false,searchable:false },
             ],
    
             rowCallback: function ( row, data ) {
                $('input.townshippingstatus', row)
                .prop( 'checked', data.status !== 1 )
                .bootstrapToggle();
             }
          });

          // show all shipping counties in a datatable
          var shippingcountiestable = $('.countiestable').DataTable({
             processing:true,
             serverside:true,
             responsive:true,
    
             ajax:"{{ route('get_shippingcounties') }}",
             columns: [
                { data: 'id' },
                {data: 'county'},
                { data: 'status',
                   render: function ( data, type, row ) {
                      if ( type === 'display' ) {
                            return '<input class="toggle-class shippingcountystatus" disabled type="checkbox" checked data-toggle="toggle" data-id="' + row.id + '" data-on="Active" data-off="Not Active" data-onstyle="success" data-offstyle="danger">';
                      }
                      return data;
                   }
                }
             ],
    
             rowCallback: function ( row, data ) {
                $('input.shippingcountystatus', row)
                .prop( 'checked', data.status !== 1 )
                .bootstrapToggle();
             }
          });

          $(document).ready(function(){
                // add a new shipping location
            $("#addshippingprice").on("submit",function(e){
               e.preventDefault();
               var url = '{{ route("addshippingprice") }}';

               $.ajax({
                  url:url,
                  type:"POST",
                  data:$("#addshippingprice").serialize(),
                  success:function(response){
                     shippingpricestable.ajax.reload();
                     alertify.set('notifier','position', 'top-right');
                     alertify.success(response.message);
                  },
                  error:function(response){
                     console.log(response);
                     if(error){
                           alertify.set('notifier','position', 'top-right');
                           alertify.success(response.message);
                     }
                  }
               });
            })
          });

          //  update rental tag status from active to inactive
        $(document).on('change','.townshippingstatus',function(e)
        {
            var townshippingstatus=$(this).prop('checked')==true? 1:0;

            var shippingstatusid=$(this).data('id');

            alert(townshippingstatus);

            var url = '{{ route("updateshipping.status") }}';
            $.ajax({
                type:"GET",
                dataType:"json",
                url:url,
                data:{
                    'status':townshippingstatus,
                    'id':shippingstatusid
                },
                success:function(res){
                    console.log(res);
                    alertify.set('notifier','position', 'top-right');
                    alertify.success(res.message);
                }
            });
        });
          
          </script>
    @stop

