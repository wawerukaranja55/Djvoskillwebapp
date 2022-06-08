@extends('backend.adminmaster')
@section('title','All Admins')
@section('content')
    <div class="content-wrapper">
        <h2>Assign a Role A User</h2>
        @if ($errors)
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif
    
        <!-- Success message -->
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif
        <form method="post" action="{{ url('admin/admins') }}">
            @csrf
            <div class="form-group">
                <label>User Name</label>
                <input type="text" class="form-control" value="{{ $admins->name }}">
            </div>
            <div class="form-group">
                <label>Admin Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="FormControlSelect">Admin Roles</label>
                <select name="adminroles" class="form-control" id="FormControlSelect">
                    @foreach($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->Role_name }}</option>
                    @endforeach
                </select>
            </div>
    
            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form> 
    </div>
@endsection
    