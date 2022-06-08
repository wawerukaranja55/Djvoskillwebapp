@extends('backend.adminmaster')
@section('title','All Post Comments')
@section('content')
<div class="container_fluid">
    
    @if (count ($blogcomments) >0)
        <h1>All Blog Comments</h1>
        <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Comment Author</th>
                <th scope="col">Comment Body</th>
                <th scope="col">The Blog Post Page</th>
                <th scope="col">Delete Comment</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($blogcomments as $blogcomment)
                <tr>
                    <td>{{ $blogcomment->id }}</td>
                    <td>{{ $blogcomment->user->name }}</td>
                    <td>{{ $blogcomment->comment }}</td>
                    <td>
                        <a class="btn btn-primary" href="{{ url('blog/post/'.Str::slug($blogcomment->blogposts->blo_title).'/'.$blogcomment->blogposts->id) }}">View Post</a>
                    <td>
                        <a class="btn btn-info" href="{{ url('admin/blogcomments/'.$blogcomment->id.'/delete')}}">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <strong style="font-size: 20px;">No Comments Found</strong>
    @endif
</div>
@endsection


