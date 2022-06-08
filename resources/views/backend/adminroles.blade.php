@extends('backend.adminmaster')
@section('title','Admin Roles')
@section('content')
    <div class="content-wrapper mt-2">
        <div class="row">
            <div class="col-md-3">
                <!-- Success message -->
                @if(Session::has('success'))
                <p class="text-success">{{session('success')}}</p>
                @endif
                <form method="post" action="{{ url('admin/roles') }}">
                    @csrf
                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" class="form-control" name="Role_name" id="Role_name" placeholder="Admin Role">
                    </div>
                    
                    <button type="submit" class="btn btn-dark btn-block">Submit</button>
                </form>
            </div>
            
            <div class="col-md-9">
                <!-- Success message -->
                @if(Session::has('role-deleted'))
                   <p class="text-success">{{session('role-deleted')}}</p>
                @endif
                @if (!empty($roles))
                <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Role Name</th>
                            <th scope="col">Created at</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->Role_name }}</td>
                            <td>{{$role->created_at->diffForHumans()}}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('roles.show',$role->id)}}">Update</a>
                                <form method="post" action="{{ route('roles.destroy',$role->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <strong style="font-size: 20px;">Roles Not Available</strong>
                        @endforelse
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        
    </div>
    
@endsection
