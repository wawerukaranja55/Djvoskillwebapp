
@extends('backend.adminmaster')
@section('title','Add A Merchadise')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="section-title">
                <h3>Merchadise Manager</h3>
            </div>
        </div>
        <!-- end col -->
        
        <div class="col-lg-12 schedule-tab">
            <ul id="tabsJustified" class="nav nav-tabs justify-content-center text-center">
                <li class="nav-item">
                    <a href="#" data-target="#three" data-toggle="tab" class="nav-link">
                        <p>Merchadise List</p>
                    </a>
                </li>
                <li class="nav-item" >
                    <a href="#" data-target="#one" data-toggle="tab" class="nav-link  active">
                        <p>Add A Merchadise</p>
                    </a>
                </li>
            </ul>
            <div id="tabsJustifiedContent" class="tab-content">
                <div id="three" class="tab-pane fade">
                  <div class="container">
                      <div class="row shadow mb-5 bg-black rounded">
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-right">
                                    <a class="btn btn-success" href="{{ url('admin/merchadise/attributes')}}">Merchadise To Add Attributes</a>
                                </div>
                            </div>
                        </div>
                          <div class="col-lg-12">
                            <div class="panel-heading mt-5" style="text-align: center;"> 
                                <h3 class="mb-2 panel-title">All Merchadises</h3> 
                            </div>
                            <table id="products" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Image</th>
                                        <th>Code</th>
                                        <th>price</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($merchadise as $merch)
                                        <tr>
                                            <td>{{$merch->id}}</td>
                                            <td>{{$merch->merch_name}}</td>
                                            <td>{{$merch->merchadisecategor->merchadisecat_title }}</td>
                                            <td>
                                                <?php $product_image_path="images/productimages/small/".$merch->merch_image; ?>
                                                @if (!empty($merch->merch_image) && file_exists($product_image_path))
                                                    <img src="{{ asset ('images/productimages/small/'.$merch->merch_image) }}" style="width:80px; height:80px;">
                                                @else
                                                <img src="{{ asset ('images/productimages/small/'.$merch->merch_image) }}" style="width:80px; height:80px;">
                                                @endif
                                            </td>
                                            <td>{{$merch->merch_code}}</td>
                                            <td>{{$merch->merch_price}}</td>
                                            <td>{!!str_limit($merch->merch_details,15)!!}</td>
                                            <td>
                                                <a class="btn btn-primary btn-xs" title="Edit the Product Details" href="{{ url('admin/merchadise/'.$merch->id.'/edit')}}"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-primary btn-xs" onclick="confirm return('Are you Sure You want to Delete?')" href="{{ url('admin/merchadise/'.$merch->id.'/delete')}}"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                      </div>
                  </div>
                </div>
                <div id="one" class="tab-pane active show fade ">
                    {{-- Add A merchadise --}}
                    <div class="container">
                        <section class="panel panel-default">
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="pull-right">
                                        <a class="btn btn-success" href="#" data-target="#categorymodal" data-toggle="modal">Add A New Category</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading mt-5" style="text-align: center;"> 
                                <h3 class="mb-2 panel-title">Add a New Merchadise</h3> 
                            </div>
                            @if ($errors)
                                @foreach ($errors->all() as $error)
                                    <p class="text-danger">{{ $error }}</p>
                                @endforeach
                            @endif
                            
                            <div class="panel-body">
                                <form action="{{ route('merchadise.store') }}" class="form-horizontal" role="form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8">
                                            <!-- form-group // -->
                                            <div class="row col-md-10">
                                                <div class="form-group col-sm-6">
                                                    <label for="merch_name" class=" control-label">Merchadise Name</label>
                                                    <input type="text" class="form-control text-white bg-dark" required name="merch_name" id="merch_name" placeholder="Write The Merchadise Name"
                                                        @if (!empty($merchadise->merch_name))
                                                            value="{{ $merchadise->merch_name }}"
                                                        @else
                                                            value="{{ old('merch_name') }}"
                                                        @endif>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label for="url" class=" control-label">Merchadise url</label>
                                                    <input type="text" class="form-control text-white bg-dark" required name="url" id="url" placeholder="Write The Merchadise url"
                                                        @if (!empty($merchadise->url))
                                                            value="{{ $merchadise->url }}"
                                                        @else
                                                            value="{{ old('url') }}"
                                                        @endif>
                                                </div>
                                            </div>
        
                                            <div class="form-group">
                                                <label for="merch_code" class=" control-label">Merchadise Code</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control text-white bg-dark" required name="merch_code" id="merch_code" placeholder="Write The Merchadise Code">
                                                </div>
                                            </div>
        
                                            <!-- form-group // -->
                                            <div class="form-group">
                                                <label for="FormControlSelect" class=" control-label">Merchadise Category</label>
                                                <div class="col-sm-10">
                                                    <select name="merchadisecategory" class="form-control text-white bg-dark">
                                                        <option>Choose a Merchadise category</option>
                                                        @foreach($merchadisecats as $merchCategory)
                                                            <option value="{{ $merchCategory['id'] }}"
                                                                @if (!empty (@old('merchcat_id')) && $merchCategory->id==@old('merchcat_id'))
                                                                    selected=""    
                                                                @endif>{{ $merchCategory->merchadisecat_title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
        
                                            <!-- form-group // -->
                                            <div class="row col-md-10">
                                                <div class="form-group col-md-6">
                                                    <label for="merch_price" class=" control-label">Merchadise Price</label>
                                                    <input type="number" class="form-control text-white bg-dark" required name="merch_price" id="merch_price" placeholder="Write the Merchadise Price">
                                    
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="stock" class=" control-label">Merchadise Stock</label>
                                                    <input type="number" class="form-control text-white bg-dark" required name="stock" id="stock" placeholder="Write the Merchadise Stock">
                                                </div>
                                            </div>
                                            
                                            <!-- form-group // -->
                                            <div class="form-group">
                                                <label for="product_discount" class=" control-label">Merchadise Discount</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control text-white bg-dark" name="product_discount" id="product_discount" placeholder="Write the Product Discount">
                                                </div>
                                            </div>
        
                                            <!-- form-group // -->
                                            <div class="form-group shadow-textarea">
                                                <label for="merch_details" class=" control-label">Merchadise Description</label>
                                                <div class="col-sm-10">
                                                    <textarea id="blo-details" name="merch_details" class="form-control text-white bg-dark" required placeholder="Write The Merchadise Description Here..."></textarea>
                                                </div>
                                            </div>
        
                                            <!-- form-group // -->
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label for="name" class="control-label">Is Featured</label>
                                                    <div class="col-sm-10">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="is_featured" id="inlineRadio1" value="Yes"> Yes 
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="is_featured" id="inlineRadio2" value="No"> No
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="name" class="control-label">Has Attibutes</label>
                                                    <div class="col-sm-10">
                                                        <label class="radio-inline">
                                                            <input type="radio" name="is_attribute" id="inlineRadio1" value="1"> Yes
                                                        </label>
                                                        <label class="radio-inline">
                                                            <input type="radio" name="is_attribute" id="inlineRadio2" value="0"> No
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> 
                                        
                                            {{-- Meta Data --}}
                                            <div class="form-group">
                                                <label for="meta_name" class="control-label">Merchadise Meta_title</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control text-white bg-dark" required name="meta_name" id="meta_name" placeholder="Write The Merchadise Name">
                                                </div>
                                            </div>

                                            <div class="form-group shadow-textarea">
                                                <label for="meta_description" class="control-label">Merchadise Meta_description</label>
                                                <div class="col-sm-10">
                                                    <textarea id="blo-details" name="meta_description" required class="form-control text-white bg-dark" placeholder="Write The Merchadise Description Here..."></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group shadow-textarea">
                                                <label for="meta_keywords" class="control-label">Merchadise Meta_Keywords</label>
                                                <div class="col-sm-10">
                                                    <textarea id="blo-details" name="meta_keywords" required class="form-control text-white bg-dark" placeholder="Write The Merchadise Description Here..."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Add Filters To the Products</h4>
                                            <div class="form-group">
                                                <label for="fabric" class="control-label">Type of Fabric</label>
                                                <div class="col-sm-10">
                                                    <select name="fabric[]" class="form-control couponselect2 text-white bg-dark" multiple style="width: 100%;" >
                                                        <option value="">Select Fabric</option>
                                                        @foreach($fabricarray as $fabric)
                                                            <option value="{{ $fabric }}">{{ $fabric }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="occasion" class="control-label">Type of Occasion</label>
                                                <div class="col-sm-10">
                                                    <select name="occasion[]" class="form-control couponselect2 text-white bg-dark" multiple style="width: 100%;">
                                                        <option value="">Select Occasion</option>
                                                        @foreach($occasionarray as $occasion)
                                                            <option value="{{ $occasion }}">{{ $occasion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- form-group // -->
                                            <h4>Upload Merchadise Image</h4>
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <input type="file" name="merch_image" required>
                                                </div>
                                                <span class="font-italic">Recommended size:width  1040px by height 1200px</span>
                                            </div>

                                            <!-- form-group // -->
                                            <h4>Upload Merchadise Video</h4>
                                            <div class="form-group">
                                                <div class="col-sm-10">
                                                    <input type="file" name="merch_video" required>
                                                </div>
                                            </div>
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
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
</div>
@endsection

