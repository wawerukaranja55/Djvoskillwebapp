
@extends('backend.adminmaster')
@section('title','Show Role')
@section('content')
    <div class="content-wrapper">
        {{-- <h2 class="ml-3">show Role</h2>
        <form method="patch" action="{{ url('admin/roles') }}">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control read-only" value="{{ $role->name }}" id="Role_name">
            </div>
            <button type="submit" class="btn btn-dark btn-block">Change Role</button>
        </form> --}}
    
        <h2>{{$role->Role_name}}</h2>
    <div class="container mt-5">
        <!-- Success message -->
        @if(Session::has('success'))
           <p class="text-success">{{session('success')}}</p>
        @endif

        @if($errors)
            @foreach($errors->all() as $error)
            <p class="text-danger">{{$error}}</p>
            @endforeach
        @endif

        <form method="post" action="{{ url('admin/roles/'.$role->id) }}">
            @csrf
            @method('put') 
            <div class="form-group">
                <label>Admin Role Title</label>
                <input type="text" class="form-control" value="{{ $role->Role_name }}" name="Role_name" id="Role_name">
            </div>

            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
    </div>
    </div>
    
@endsection
