@extends('backend.adminmaster')
@section('title','Show User')
@section('content')
    <div class="content-wrapper">
        <h2 class="ml-3"> {{ $user->id }}.{{ $user->name }}</h2>
        <form method="post" action="{{ url('admin/users/'.$user->id) }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control disabled" value="{{ $user->name }}" id="name">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control disabled" value="{{ $user->email }}" id="email">
            </div>
            {{-- <div class="form-group">
                <label for="FormControlSelect">Roles</label>
                <select name="rolename" class="form-control" id="FormControlSelect">
                    <option>Choose a Role</option>
                    @foreach($roles as $role)
                        <option selected value="{{ $role->id }}">{{ $role->Role_name }}</option>
                    @endforeach
                </select>
            </div> --}} 
            <div class="form-group">
                <label>Role of the user</label>
                @foreach($user->roles as $role)
                     {{ $role->id }}
                @endforeach
            
            </div>

            <div class="form-group">
                <label for="FormControlSelect">Roles</label>
                <select name="rolename" class="form-control" id="FormControlSelect">
                    <option>ReAssign The Role</option> 
                    @foreach($allroles as $role)
                        @if ($role->id==$user->role_id)
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
