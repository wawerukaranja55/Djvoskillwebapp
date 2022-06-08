@extends('backend.adminmaster')
@section('title','All Admins')
@section('content')
    <div class="content-wrapper">
        <h3>All The Admins
        </h3>
        <!-- Success message -->
        @if(Session::has('success'))
        <p class="text-success">{{session('success')}}</p>
        @endif
        @if (!empty($admins))
        <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                    <tr>
                        <td>{{$admin->id}}</td>
                        <td>{{$admin->name}}</td>
                        <td>{{$admin->email}}</td>
                        <td>
                            @foreach($admin->roles as $role)
                             {{ $role->Role_name }}
                            @endforeach
                        </td>
                        <td>{{$admin->created_at->diffforhumans()}}</td>
                        <td>
                            <a class="btn btn-info" href="{{route('admins.show',$admin->id)}}">Re-Assign Role</a>
                        </td>
                    </tr>
                    @empty
                    <strong style="font-size: 20px;">No Available Admins</strong>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
@endsection

