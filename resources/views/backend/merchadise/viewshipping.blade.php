@extends('backend.adminmaster')
@section('title','Shipping Charges')
@section('content')
    <div class="content-wrapper">
        <h2>All The Shipping Charges
        </h2>
        <!-- Success message -->
        @if(Session::has('success'))
        <p class="text-success">{{session('success')}}</p>
        @endif
        <div id="notific" style="z-index: 10000;display:none;background:green;font-weight:450;width:350px;position:fixed;top:80%;left:5%;color:white;padding:5px 20px;"></div>
        @if (!empty($shippingcharges))
        <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>County</th>
                        <th>Town</th>
                        <th>Charges</th>
                        <th>Status</th>
                        <th>Edit Charges</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shippingcharges as $shippingcharge)
                    <tr>
                        <td>{{$shippingcharge->id}}</td>
                        <td>{{$shippingcharge->county}}</td>
                        <td>{{$shippingcharge->town}}</td>
                        <td>{{$shippingcharge->shipping_charges}}</td>
                        <td>
                            <input data-id="{{ $shippingcharge->id }}" class="toggle-class shippingstatus" type="checkbox" 
                                    data-onstyle="success" data-offstyle="danger" data-toggle="toggle" 
                                    data-on="Active" data-off="In Active" {{ $shippingcharge->is_shipping ? 'checked':'' }}>
                        </td>
                        <td>
                            <a class="btn btn-info" href="{{ route('editshippingcharge',$shippingcharge->id)}}">Edit the Charges</a>
                        </td>
                        @empty
                            <strong style="font-size: 20px;">No Shipping Charges Added</strong>
                        @endforelse
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
@endsection

