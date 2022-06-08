@extends('backend.adminmaster')
@section('title','Add a Blog Tag')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Add A New Blog Tag</h2>
    <div class="container mt-5">
        @if ($errors)
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif
        <form method="post" action="{{ url('admin/blogtags') }}" role="form">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="blogtag_title">Tag Name</label>
                <input type="text" class="form-control" name="blogtag_title" placeholder="blotag_title">
            </div>
            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
    </div>
</div>
@endsection
