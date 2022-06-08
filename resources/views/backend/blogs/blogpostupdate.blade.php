@extends('backend.adminmaster')
@section('title','Edit Blog Post')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Edit The Blog Post</h2>
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

        <form method="post" action="{{ url('admin/blogpost/'.$data->id) }}" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="form-group">
                <label>Blog Post Title</label>
                <input type="text" class="form-control" value="{{ $data->blo_title }}" name="blo_title" id="blo_title">
            </div>

            <div class="form-group">
                <label for="FormControlSelect">Blog Category</label>
                <select name="blocategory" class="form-control" id="FormControlSelect">
                    <option>Choose a Blog Category</option>
                    @foreach($blogcats as $BlogCategory)
                        @if ($BlogCategory->id==$data->cat_id)
                            <option selected value="{{ $BlogCategory->id }}">{{ $BlogCategory->blogcat_title }}</option>
                        @else
                        <option value="{{ $BlogCategory->id }}">{{ $BlogCategory->blogcat_title }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group shadow-textarea">
                <label>Main story</label>
                <textarea id="blo-details" name="blo_details"  class="form-control">{{ $data->blo_details }}</textarea>
               
            </div>

            <div class="form-group">
                {{-- <div class="form-line {{ $errors->has('tags') ? 'focused error' : '' }}">
                    <label for="tag">Select Tags</label>
                    <select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true" multiple>
                        @foreach($tags as $tag)
                            <option
                                    @foreach($post->tags as $postTag)
                                        {{ $postTag->id == $tag->id ? 'selected' :'' }}
                                    @endforeach
                                    value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <label for="tags">Post Tags</label>
                <select name="tags[]" class="blogtags form-control" multiple="multiple">
                    @foreach($blogtags as $blogtag)
                        <option
                            @foreach($data->blogtags as $postTag)
                                {{ $postTag->id == $blogtag->id ? 'selected' :'' }}
                            @endforeach
                            value="{{ $blogtag->id }}">{{ $blogtag->name }}</option>
                    @endforeach
                    {{-- @foreach($blogtags as $blogtag)
                       <option value="{{ $blogtag->id}}">{{ $blogtag->blogtag_title }}</option>
                    @endforeach --}}
                </select>
            </div>

            <br>
            <!-- Main Image Button--->
            <label for="file">Blog Post Image</label>
            <input type="file" name="blo_image"/>
            <input type="hidden" name="blo_image" value="{{ $data->blo_image }}"/>
            <img id="blo_image" style="width: 100px; height: 80px;" src="{{ asset ('blogposts'.'/'.$data->blo_image) }}"/>
            <br>

            <button type="submit" class="btn btn-dark btn-block">Submit</button>
        </form>
    </div>
</div>
    
    @php
    $tag_ids=[];
    @endphp

    @foreach ($data->blogtags as $blogtag);
    @php
        array_push($tag_ids,$blogtag->id);
    @endphp
    @endforeach
    <script>
            $(document).ready(function(){
            $('.blogtags').select2();
            //
            // data=[];
            // data=<?php echo json_encode($tag_ids);?>;
            //     $('.blogtags') .val(data).trigger('change');
            
            // });
    </script>
@endsection 