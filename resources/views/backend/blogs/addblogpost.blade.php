
@extends('backend.adminmaster')
@section('title','Add A Blog Post')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Add A New Blog Post</h2>
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
        <form method="post" action="{{ url('admin/blogpost') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Blog Name</label>
                <input type="text" class="form-control" name="blo_title">
            </div>
            
            <div class="form-group">
                <label for="FormControlSelect">Blog Category</label>
                <select name="blocategory" class="form-control" id="FormControlSelect">
                    <option>Choose a Blog Category</option>
                    @foreach($blogcats as $BlogCategory)
                       <option value="{{ $BlogCategory->id }}">{{ $BlogCategory->blogcat_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group shadow-textarea">
                <label>Main story</label>
                <textarea id="blo-details" name="blo_details" class="form-control" placeholder="Write The Content Here..."></textarea>
                
            </div>

            <div class="form-group">
                <label for="tags">Post Tags</label>
                <select name="tags[]" class="blogtags form-control" multiple="multiple">
                    @foreach($blogtags as $blogtag)
                       <option value="{{ $blogtag->id  }}">{{ $blogtag->blogtag_title }}</option>
                    @endforeach
                </select>
            </div>
            
            <br>
            <!-- Main Image Button--->
            <label for="file">Blog  Post Image</label>
            <input type="file" name="blo_image" onchange="readURL(this);"/>
            <img id="blo_image" style="width: 100px;"  src="{{asset('/blogposts')}}"/>
            <br>

            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
</div>
@endsection
