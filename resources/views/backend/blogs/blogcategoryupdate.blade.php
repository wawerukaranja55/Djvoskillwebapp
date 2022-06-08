@extends('backend.adminmaster')
@section('title','Edit Blog Category')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Edit The Blog Category</h2>
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

        <form method="post" action="{{ url('admin/blogcategory/'.$data->id) }}">
            @csrf
            @method('put')
            <div class="form-group">
                <label>Blog Category Title</label>
                <input type="text" class="form-control" value="{{ $data->blogcat_title }}" name="blogcat_title" id="blogcat_title">
            </div>

            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
    </div>
</div>
@endsection 