@extends('backend.adminmaster')
@section('title','Post Title Update')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Edit The Blog Tag</h2>
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

        <form method="post" action="{{ url('admin/blogtags/'.$data->id) }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label>Post Tag Title</label>
                <input type="text" class="form-control" value="{{ $data->blogtag_title }}" name="blogtag_title" id="blogtag_title">
            </div>

            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
    </div>
</div>
@endsection 