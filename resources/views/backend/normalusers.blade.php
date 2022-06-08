@extends('backend.adminmaster')
@section('title','All Users')
@section('content')
    <div class="content-wrapper">
        <h2>All The Normal Users
        </h2>
        <!-- Success message -->
        @if(Session::has('success'))
        <p class="text-success">{{session('success')}}</p>
        @endif
        
        @if (!empty($users))
        <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>
                            @foreach($user->roles as $role)
                             {{ $role->Role_name }}
                            @endforeach
                        </td>
                        
                        <td>{{$user->created_at->diffforhumans()}}</td>
                        <td>
                            <a class="btn btn-info" href="{{route('users.show',$user->id)}}">Assign Another Role</a>
                            <a onclick="confirm return('Are you Sure You want to Delete?')" class="btn btn-info" href="{{ url('admin/users'.$user->id.'/delete')}}">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <strong style="font-size: 20px;">No Available Users</strong>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
@endsection

