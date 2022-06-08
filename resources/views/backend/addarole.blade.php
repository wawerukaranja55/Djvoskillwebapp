@extends('backend.adminmaster')
@section('title','Admin Roles')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <h2>Add A Role</h2>
            <div class="container mt-5">
                <!-- Success message -->
                @if(Session::has('success'))
                <p class="text-success">{{session('success')}}</p>
                @endif

                
                
                <form method="post" action="{{ url('admin/roles') }}">
                    @csrf
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Admin Role">
                    </div>

                    <button type="submit" class="btn btn-dark btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
    
@endsection