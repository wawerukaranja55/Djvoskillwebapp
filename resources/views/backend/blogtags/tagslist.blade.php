@extends('backend.adminmaster')
@section('title','Blog Tags')
@section('content')
<div class="container">
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
                <a class="btn btn-success" href="{{ url('admin/blogtags/create') }}">Add A tag</a>
            </div>
        </div>
        @if (!empty($blogtags))
            <table class="table table-bordered" id="admindatatables">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Tag Name</th>
                        <th scope="col">Blogpost Title</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogtags as $tag)
                    <tr>
                        <td>{{$tag->id}}</td>
                        <td>{{$tag->blogtag_title}}</td>
                        <td>
                            {{-- <a href="{{ url('blog/post/'.Str::slug($tag->blogtags->blo_title).'/'.$tag->blogtags->id) }}">View Posts</a> --}}
                            <a class="btn btn-info" href="{{ url('admin/blogtags/'.$tag->id.'/edit')}}">Update</a>
                            <a onclick="confirm return('Are you Sure You want to Delete?')" class="btn btn-info" href="{{ url('admin/blogtags/'.$tag->id.'/delete')}}">Delete</a>
                        </td>
                    </tr>
                    @empty
                    <strong style="font-size: 20px;">No Available Tags</strong>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection 