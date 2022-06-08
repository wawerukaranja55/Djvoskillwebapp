@extends('backend.adminmaster')
@section('title','Merchadise Categories')
@section('content')
<div class="container">
    <section class="panel panel-default">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                    <a class="btn btn-success" href="#">All Product Categories</a>
                </div>
            </div>
        </div>
        <div class="panel-heading mt-5" style="text-align: center;"> 
            <h3 class="mb-2 panel-title">Add a New Product Category</h3> 
        </div>
        @if ($errors)
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        @endif
        
        <div class="panel-body">
            <form action="{{ route('merchadisecategory.store') }}" class="form-horizontal" role="form" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label for="merchadisecat_title" class=" control-label">Category Name</label>
                        <input type="text" class="form-control text-white bg-dark" required name="merchadisecat_title" id="merchadisecat_title" placeholder="Write The Category Name">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="url" class=" control-label">Category Slug</label>
                        <input type="text" class="form-control text-white bg-dark" required name="url" id="url" placeholder="Write The category url">
                    </div>
                </div>

                <div class="form-group">
                    <label for="category_discount" class=" control-label">Category Discount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control text-white bg-dark" required name="category_discount" id="category_discount" placeholder="Write The Merchadise Code">
                    </div>
                </div>

                        <div class="row">
                            {{-- parent category --}}
                            <div class="form-group col-sm-6">
                                <label for="FormControlSelect" class=" control-label">Parent Category</label>
                                <select name="merchadisecategory" class="form-control text-white bg-dark">
                                    <option>Choose a Merchadise category</option>
                                    {{-- @foreach($merchadisecats as $merchCategory)
                                        <option value="{{ $merchCategory['id'] }}"
                                            @if (!empty (@old('merchcat_id')) && $merchCategory->id==@old('merchcat_id'))
                                                selected=""    
                                            @endif>{{ $merchCategory->merchadisecat_title }}</option>
                                    @endforeach --}}
                                </select>
                            </div>

                            {{-- product Section --}}
                            <div class="form-group col-sm-6">
                                <label for="FormControlSelect" class=" control-label">Product Sections</label>
                                <select name="merchadisecategory" class="form-control text-white bg-dark">
                                    <option>Choose a Merchadise category</option>
                                    {{-- @foreach($merchadisecats as $merchCategory)
                                        <option value="{{ $merchCategory['id'] }}"
                                            @if (!empty (@old('merchcat_id')) && $merchCategory->id==@old('merchcat_id'))
                                                selected=""    
                                            @endif>{{ $merchCategory->merchadisecat_title }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>
                        
                        <hr>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10">
                                <button type="submit" class="btn btn-primary">Upload Product Information</button>
                            </div>
                        </div> 

                
            </form>
        </div>    
    </section>
</div>
@endsection
