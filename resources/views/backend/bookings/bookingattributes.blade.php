@extends('backend.adminmaster')
@section('title','Booking Attributes')
@section('content')
    <div class="content-wrapper mt-2">
        <h2 style="text-align:center; margin:5px;">Booking Categories</h2>
        <div class="row">
            
            <div class="col-md-4">
                <!-- Success message -->
                @if(Session::has('success'))
                <p class="text-success">{{session('success')}}</p>
                @endif
                <form method="post" action="{{ url('admin/bookingcategory') }}">
                    @csrf
                    <div class="form-group">
                        <label>Create A Booking Category</label>
                        <input type="text" class="form-control" name="booking_category" id="booking_category" placeholder="Booking Category">
                    </div>
    
                    <button type="submit" class="btn btn-dark btn-block">Submit</button>
                </form>
            </div>
            
            <div class="col-md-8">
                <!-- Success message -->
                @if(Session::has('role-deleted'))
                   <p class="text-success">{{session('role-deleted')}}</p>
                @endif
                <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Booking Category</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingcats as $bookcat)
                            <tr>
                                <td>{{$bookcat->id}}</td>
                                <td>{{$bookcat->booking_category }}</td>
                                <td>{{$bookcat->created_at->diffForHumans()}}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('bookingcategory.show',$bookcat->id)}}">Update</a>
                                    <form method="post" action="{{ route('bookingcategory.destroy',$bookcat->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <strong style="font-size: 20px;">Booking Categories Not Created</strong>
                            @endforelse
                    </tbody>
                </table>
                
            </div>
        </div>
    <div style="border:2px solid black;"></div>
        <h2 style="text-align:center; margin-top:15px;">Booking Packages</h2>
        <div class="row">
            
            <div class="col-md-4">
                <!-- Success message -->
                @if(Session::has('success'))
                <p class="text-success">{{session('success')}}</p>
                @endif
                <form method="post" action="{{ url('admin/bookingcategory') }}">
                    @csrf
                    <div class="form-group">
                        <label>Create A Booking Package</label>
                        <input type="text" class="form-control" name="booking_category" id="booking_category" placeholder="Booking Package">
                    </div>
    
                    <button type="submit" class="btn btn-dark btn-block">Submit</button>
                </form>
            </div>
            
            <div class="col-md-8">
                <!-- Success message -->
                @if(Session::has('role-deleted'))
                   <p class="text-success">{{session('role-deleted')}}</p>
                @endif
                <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
                    <thead class="thead-dark">
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Package Description</th>
                        <th scope="col">Package Price</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse($bookingspack as $bookpack)
                            <tr>
                                <td>{{$bookpack->id}}</td>
                                <td>{{$bookpack->package_name }}</td>
                                <td>{{$bookpack->package_description }}</td>
                                <td>{{$bookpack->package_price }}</td>
                                <td>{{$bookpack->created_at->diffForHumans()}}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('bookingcategory.show',$bookpack->id)}}">Update</a>
                                    <form method="post" action="{{ route('bookingcategory.destroy',$bookpack->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <strong style="font-size: 20px;">Booking Categories Not Created</strong>
                            @endforelse
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
    
@endsection
