@extends('backend.adminmaster')
@section('title','Coupons')
@section('content')
    <div class="content-wrapper">
        <h2>All Available Coupons</h2>
        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                <strong>{{ session::get('success') }}</strong>
            </div>
        @endif
        <div class="notific"></div>
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ url('admin/coupons/create')}}">Add A Coupon</a>
            </div>
        </div>
        @if (!empty($allcoupons))
        <div class="table-responsive" style="border: 2px solid green;">
            <table class="table table-striped table-bordered dt-responsive nowrap  order-column dataTables-example" >
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Coupon_Option</th>
                        <th>Coupon_Type</th>
                        <th>Coupon_Name</th>
                        <th>Amount_Type</th>
                        <th>Amount</th>
                        <th>Expiry Date</th>
                        <th>Categories</th>
                        <th>Users</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allcoupons as $coupon)
                    <tr>
                        <td>{{$coupon->id}}</td>
                        <td>{{$coupon->coupon_option}}</td>
                        <td>{{$coupon->coupon_type}}</td>
                        <td>{{$coupon->coupon_code}}</td>
                        <td>{{$coupon->amount_type}}</td>
                        <td>{{$coupon->amount}}</td>
                        <td>{{$coupon->expiry_date}}</td>
                        <td>{{$coupon->categories}}</td>
                        <td>{{$coupon->users}}</td>
                        <td>
                            <input data-id="{{ $coupon->id }}" class="couponstatus toggle-class" type="checkbox" 
                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle" 
                                    data-on="Active" data-off="In Active" {{ $coupon->status ? 'checked':'' }}>
                        </td>
                        <td>
                            <form action="{{route('events.destroy',$coupon->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <a class="btn" href="{{ route('events.show',$coupon->id)}}"> Show </a>
                                <a class="btn" href="{{ route('coupons.edit',$coupon->id)}}"> Edit </a>
                                <input type="submit" class="btn" value="DELETE">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Coupon_Option</th>
                        <th>Coupon_Type</th>
                        <th>Coupon_Name</th>
                        <th>Amount_Type</th>
                        <th>Amount</th>
                        <th>Expiry Date</th>
                        <th>Categories</th>
                        <th>Users</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
        {{-- @if (!empty($allcoupons))
        <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Coupon_Option</th>
                        <th>Coupon_Type</th>
                        <th>Coupon_Name</th>
                        <th>Amount_Type</th>
                        <th>Amount</th>
                        <th>Expiry Date</th>
                        <th>Categories</th>
                        <th>Users</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allcoupons as $coupon)
                    <tr>
                        <td>{{$coupon->id}}</td>
                        <td>{{$coupon->coupon_option}}</td>
                        <td>{{$coupon->coupon_type}}</td>
                        <td>{{$coupon->coupon_code}}</td>
                        <td>{{$coupon->amount_type}}</td>
                        <td>{{$coupon->amount}}</td>
                        <td>{{$coupon->expiry_date}}</td>
                        <td>{{$coupon->categories}}</td>
                        <td>{{$coupon->users}}</td>
                        <td>
                            <input data-id="{{ $coupon->id }}" class="toggle-class" type="checkbox" 
                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle" 
                                    data-on="Active" data-off="In Active" {{ $coupon->status ? 'checked':'' }}>
                        </td>
                        <td>
                            <form action="{{route('events.destroy',$coupon->id)}}" method="post">
                                {{csrf_field()}}
                                {{method_field('DELETE')}}
                                <a class="btn" href="{{ route('events.show',$coupon->id)}}"> Show </a>
                                <a class="btn" href="{{ route('coupons.edit',$coupon->id)}}"> Edit </a>
                                <input type="submit" class="btn" value="DELETE">
                            </form>
                        </td>
                        @empty
                            <strong style="font-size: 20px;">No Coupon Discounts Added</strong>
                        @endforelse
                    </tr>
                </tbody>
            </table>
        @endif --}}
    </div>
@endsection

