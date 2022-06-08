@extends('backend.adminmaster')
@section('title','Show Admin')
@section('content')
    <div class="content-wrapper">
        <h2 class="ml-3"> {{ $admin->id }}.{{ $admin->name }}</h2>
        <!-- Success message -->
        @if(Session::has('success'))
        <p class="text-success">{{session('success')}}</p>
        @endif
        <form method="post" action="{{ url('admin/admins/'.$admin->id) }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control disabled" value="{{ $admin->name }}" id="name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control disabled" value="{{ $admin->email }}" id="email">
            </div>
            <div class="form-group">
                <label for="Role_name">Roles</label>
                <select name="rolename" class="form-control" id="rolename">
                    @foreach($roles as $role)
                        @if ($role->id==$admin->rolename)
                            <option selected value="{{ $role->id }}">{{ $role->Role_name }}</option>
                        @else
                            <option value="{{ $role->id }}">{{ $role->Role_name }}</option>
                        @endif
                    @endforeach
                </select>
                
            </div>

            <button type="submit" class="btn btn-dark">Change Role</button>
            <button class="btn btn-warning"><a href="{{ url('admin/admins') }}">cancel</a></button>
        </form>
        
    </div>
    
@endsection
