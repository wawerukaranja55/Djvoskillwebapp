@extends('backend.adminmaster')
@section('title','List Blogs')
@section('content')
<div class="container_fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                @if ($message=Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ url('admin/blogpost/create') }}">Add A Blog Post</a>
            </div>
        </div>
    </div>
    @if (!empty($data))
        <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Blogpost Category</th>
                    <th scope="col">Blogpost Details</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->blo_title}}</td>
                    <td>{{$post->blogcategor->blogcat_title }}</td>
                    <td>{!!$post->blo_details!!}</td>
                    <td><img src="{{ asset ('blogposts/'.$post->blo_image) }}" style="width:100px; height:100px;"></td>
                    <td>
                        <a class="btn btn-info" href="{{ url('admin/blogpost/'.$post->id.'/edit')}}">Update</a>
                        <a onclick="confirm return('Are you Sure You want to Delete?')" class="btn btn-info" href="{{ url('admin/blogpost/'.$post->id.'/delete')}}">Delete</a>
                    </td>
                </tr>
                @empty
                <strong style="font-size: 20px;">No Available Posts</strong>
                @endforelse
            </tbody>
        </table>
    @endif
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $('#admindatatables').Datatable();
    });
</script>
    
@endsection
