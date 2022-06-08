@extends('backend.adminmaster')
@section('title','Merchadise Categories')
@section('content')
<div class="container">
    <div class="row shadow mb-5 bg-black rounded">
        <div class="col-lg-12">
            <div class="panel-heading mt-5" style="text-align: center;"> 
                <h3 class="mb-2 panel-title">All Merchadise Categories</h3> 
            </div>
            <table id="products" class="table table-striped table-bordered nowrap"  style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Parent Category</th>
                        <th>Discount</th>
                        <th>Category Slug</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($merchadisecats as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->merchadisecat_title }}</td>
                            <th>{{$category->merchadisecat_title }}</th>
                            <td>{{$category->category_discount }}</td>
                            <td>{{$category->url }}</td>
                            <td>
                              <input data-id="{{ $category->id }}" class="toggle-class categorystatus" type="checkbox" 
                                      data-onstyle="success" data-offstyle="danger" data-toggle="toggle" 
                                      data-on="Active" data-off="In Active" {{ $category->status ? 'checked':'' }}>
                              </td>
                            <td>
                                <a class="btn btn-primary btn-xs" title="Edit the P Details" href="{{ url('admin/merchadise/'.$category->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                                <a class="btn btn-primary btn-xs" onclick="confirm return('Are you Sure You want to Delete?')" 
                                href="{{ url('admin/merchadisecategory/'.$category->id.'/delete')}}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection