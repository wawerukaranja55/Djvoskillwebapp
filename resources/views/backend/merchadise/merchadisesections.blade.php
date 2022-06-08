@extends('backend.adminmaster')
@section('title','Merchadise Sections')
@section('content')
<div class="container">
    <div class="row shadow mb-5 bg-black rounded">
        <div class="col-lg-7">
            <div class="panel-heading mt-5" style="text-align: center;"> 
                <h3 class="mb-2 panel-title">All Merchadise Section</h3> 
            </div>
            <table id="products" class="table table-striped table-bordered nowrap"  style="width: 100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allsections as $section)
                        <tr>
                            <td>{{$section->id}}</td>
                            <td>{{$section->merchadisesection_title}}</td>
                            <td>
                              <input data-id="{{ $section->id }}" class="toggle-class sectionstatus" type="checkbox" 
                                      data-onstyle="success" data-offstyle="danger" data-toggle="toggle" 
                                      data-on="Active" data-off="In Active" {{ $section->status ? 'checked':'' }}>
                              </td>
                            <td>
                                {{-- <a class="btn btn-primary btn-xs" title="Edit the P Details" href="{{ url('admin/merchadise/'.$section->id.'/edit')}}"><i class="fa fa-edit"></i></a> --}}
                                  <a class="btn btn-primary btn-xs" onclick="confirm return('Are you Sure You want to Delete?')" 
                                  href="{{ url('admin/merchadisesections/'.$section->id.'/delete')}}">
                                      <i class="fa fa-trash"></i>
                                  </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-5">
            <div class="container mt-5">
                <!-- Success message -->
                @if(Session::has('success'))
                <p class="text-success">{{session('success')}}</p>
                @endif

                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                      <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Create  A Product Section</h3>
                      <form role="form"  action="{{ route('merchadisesections.store') }}" method="post" >
                        @csrf
                  
                          <div class="row form-group">
                            <div class="col-md-12 mb-4">
                                <div class="form-outline">
                                    <label class="form-label" for="merchadisesection_title">Product Section Name</label>
                                    <input type="text" class="form-control text-white bg-dark" required name="merchadisesection_title" id="merchadisesection_title" placeholder="Write The Section Name Here"/>
                                </div>
                            </div>
                          </div>
                          <button type="submit" class="btn-primary btn-lg"> Submit </button>
                      </form>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection