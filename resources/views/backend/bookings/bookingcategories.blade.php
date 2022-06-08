@extends('backend.adminmaster')
@section('title','Booking Categories')
@section('content')
    <div class="content-wrapper mt-2">
        <div class="row">
            <div class="col-md-3">
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
            
            <div class="col-md-9" style="border: 2px solid black;">
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
                        @forelse($bookingcat as $bookcat)
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
        
    </div>
    
@endsection
