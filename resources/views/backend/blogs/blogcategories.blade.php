@extends('backend.adminmaster')
@section('title','Blog Categories')
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
            <a class="btn btn-success" href="{{ url('admin/blogcategory/create') }}">Add A Blog Category</a>
        </div>
    </div>
  </div>
  <h2>Blog Categories</h2>
  <div class="row">
    @if (!empty($data))
    <table id="admindatatables" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
        <thead>
          <tr>
            <th>id</th>
            <th>Blog Category Title</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @forelse($data as $blogcat)
            <tr>
                <td>{{ $blogcat->id}}</td>
                <td>{{ $blogcat->blogcat_title}}</td>
                <td>
                    <a class="btn btn-info" href="{{ url('admin/blogcategory/'.$blogcat->id.'/edit')}}">Update</a>
                    <a onclick="confirm return('Are you Sure You want to Delete?')" class="btn btn-info" href="{{ url('admin/blogcategory/'.$blogcat->id.'/delete')}}">Delete</a>
                </td>
            </tr>
            @empty
            <strong style="font-size: 20px;">No Available Blog Category</strong>
            @endforelse
        </tbody>
    </table>
    {{-- <div class="d-flex justify-content-center" style="background: blue">
      {!! $data->links() !!}
    </div> --}}
    @endif
  </div>
</div>
@endsection 