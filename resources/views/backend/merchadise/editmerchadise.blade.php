
@extends('backend.adminmaster')
@section('title','Edit Merchadise Details')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <div class="row">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        @if(Session::has('success_message'))
            <div class="alert alert-success">
                {{Session::get('success_message')}}
            </div>
        @endif
        
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="btn btn-success" href="{{ url('admin/edit-attributes/'.$merchadisedata->id) }}">Edit {{ $merchadisedata->merch_name }} Attributes</a>
            </div>
        </div>
        {{-- Add A merchadise --}}
        <div class="container">
            <section class="panel panel-default">
                <div class="panel-heading mt-5" style="text-align: center;"> 
                    <h3 class="mb-2 panel-title">Update <span class="font-weight-bold">{{ $merchadisedata->merch_name }}</span> Details</h3> 
                </div>
                @if ($errors)
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                @endif
                <div class="panel-body">
                    <form action="{{ url('admin/merchadise/'.$merchadisedata->id) }}" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="row">
                            <div class="col-md-7">
                                <!-- form-group // -->
                                <div class="form-group">
                                    <label for="merch_name" class=" control-label">Merchadise Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-white bg-dark" required name="merch_name" id="merch_name" placeholder="Write The Merchadise Name"
                                            @if (!empty($merchadisedata->merch_name))
                                                value="{{ $merchadisedata->merch_name }}"
                                            @else
                                                value="{{ old('merch_name') }}"
                                            @endif>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="merch_code" class=" control-label">Merchadise Code</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-white bg-dark" required name="merch_code" id="merch_code" placeholder="Write The Merchadise Code"
                                            @if (!empty($merchadisedata->merch_code))
                                                value="{{ $merchadisedata->merch_code }}"
                                            @else
                                                value="{{ old('merch_code') }}"
                                            @endif>
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
                                                    @elseif(!empty($merchadisedata->merchcat_id)&&$merchadisedata->merchcat_id==$merchCategory->id)
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
                                        <input type="number" class="form-control text-white bg-dark" required name="merch_price" id="merch_price"
                                            @if (!empty($merchadisedata->merch_price))
                                                value="{{ $merchadisedata->merch_price }}"
                                            @else
                                                value="{{ old('merch_price') }}"
                                            @endif
                                        placeholder="Write the Merchadise Price">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="stock" class=" control-label">Merchadise Stock</label>
                                        <input type="number" class="form-control text-white bg-dark" required name="stock" id="stock"
                                            @if (!empty($merchadisedata->stock))
                                                value="{{ $merchadisedata->stock }}"
                                            @else
                                                value="{{ old('stock') }}"
                                            @endif
                                        placeholder="Write the Merchadise Price">
                                    </div>
                                </div>
                                
                                <!-- form-group // -->
                                <div class="form-group">
                                    <label for="product_discount" class=" control-label">Merchadise Discount</label>
                                    <div class="col-sm-10">
                                        <input type="number"
                                            @if (!empty($merchadisedata->product_discount))
                                                value="{{ $merchadisedata->product_discount }}"
                                            @else
                                                value="{{ old('product_discount') }}"
                                            @endif
                                        class="form-control text-white bg-dark" name="product_discount" id="product_discount">
                                    </div>
                                </div>

                                <!-- form-group // -->
                                <div class="form-group shadow-textarea">
                                    <label for="merch_details" class=" control-label">Merchadise Description</label>
                                    <div class="col-sm-10">
                                        <textarea id="blo-details" name="merch_details" class="form-control text-white bg-dark" required placeholder="Write The Merchadise Description Here...">
                                            @if (!empty($merchadisedata->merch_details))
                                                value="{{ $merchadisedata->merch_details }}"
                                            @else
                                                value="{{ old('merch_details') }}"
                                            @endif
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <h4>Update Filters</h4>
                                <div class="form-group">
                                    <label for="fabrics" class="control-label">Type of Fabric</label>
                                    <div class="col-sm-10">
                                        <select name="fabrics[]" class="form-control couponselect2 text-white bg-dark" multiple="multiple" style="width: 100%;" >
                                            <option value="">Select Fabric</option>
                                            @foreach($fabricarray as $fabric)
                                                <option value="{{ $fabric }}" 
                                                    @if(in_array($fabric,$fabricarray))
                                                        selected=" "
                                                    @endif>{{ $fabric }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="occasion" class="control-label">Type of Occasion</label>
                                    <div class="col-sm-10">
                                        <select name="occasions[]" class="form-control couponselect2 text-white bg-dark" multiple="multiple" style="width: 100%;">
                                            <option value="">Select Occasion</option>
                                            @foreach($occasionarray as $occasion)
                                                <option value="{{ $occasion }}"
                                                @if(in_array($occasion,$occasionarray))
                                                        selected=" "
                                                    @endif>{{ $occasion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- form-group // -->
                                <h4>Upload Merchadise Image</h4>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        @if (!empty($merchadisedata->merch_image))
                                            <div>
                                                <img style="width: 80px"; src="{{ asset('images/productimages/small/'.$merchadisedata->merch_image) }}">&nbsp;
                                                <a class="confirmdelete" href="javascript:void(0)" record="merch_image" recordid="{{ $merchadisedata->id }}">Delete Image</a>
                                            </div>
                                        @endif
                                        <input type="file" name="merch_image">
                                        <input type="hidden" name="merch_image" value="{{ $merchadisedata->merch_image }}"/>
                                    </div>
                                    <span class="font-italic">Recommended size:width  1040px by height 1200px</span>
                                </div>

                                <!-- form-group // -->
                                <h4>Upload Merchadise Video</h4>
                                <div class="form-group">
                                    <div class="col-sm-10">
                                        @if (!empty($merchadisedata->merch_video))
                                            <div>
                                                <a href="{{ url('videos/productvideos/'.$merchadisedata->merch_video) }}" download>Download Video</a>&nbsp;&nbsp;&nbsp;
                                                <a class="confirmdelete" href="javascript:void(0)" record="merch_video" recordid="{{ $merchadisedata->id }}">Delete Video</a>
                                            </div>
                                        @endif
                                        <input type="file" name="merch_video">
                                        <input type="hidden" name="merch_video" value="{{ $merchadisedata->merch_video }}"/>
                                    </div>
                                </div>

                                {{-- Meta Data --}}
                                <div class="form-group">
                                    <label for="meta_name" class="control-label">Merchadise Meta_title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-white bg-dark" required name="meta_name" id="meta_name" placeholder="Write The Merchadise Name"
                                            @if (!empty($merchadisedata->meta_name))
                                                value="{{ $merchadisedata->meta_name }}"
                                            @else
                                                value="{{ old('meta_name') }}"
                                            @endif>
                                    </div>
                                </div>

                                <div class="form-group shadow-textarea">
                                    <label for="meta_description" class="control-label">Merchadise Meta_description</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-white bg-dark" required name="meta_description" id="meta_description" placeholder="Write The Merchadise Name"
                                            @if (!empty($merchadisedata->meta_description))
                                                value="{{ $merchadisedata->meta_description }}"
                                            @else
                                                value="{{ old('meta_description') }}"
                                            @endif>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="meta_keywords" class="control-label">Merchadise Meta_Keywords</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control text-white bg-dark" required name="meta_keywords" id="meta_keywords" placeholder="Write The Merchadise Name"
                                            @if (!empty($merchadisedata->meta_keywords))
                                                value="{{ $merchadisedata->meta_keywords }}"
                                            @else
                                                value="{{ old('meta_keywords') }}"
                                            @endif>
                                    </div>
                                </div>

                                <!-- form-group // -->
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="name" class="control-label">Is Featured</label>
                                        <div class="col-sm-10">
                                            <label class="radio-inline">
                                                <input type="radio" name="is_featured" id="inlineRadio1"
                                                @if (!empty($merchadisedata->is_featured)&&$merchadisedata->is_featured=="Yes")
                                                    checked=""
                                                @endif value="{{ $merchadisedata->is_featured }}"> Yes 
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="is_featured" id="inlineRadio2"
                                                @if (!empty($merchadisedata->is_featured)&&$merchadisedata->is_featured=="No")
                                                    checked=""
                                                @endif value="{{ $merchadisedata->is_featured }}"> No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="control-label">Has Attributes</label>
                                        <div class="col-sm-10">
                                            @if ($merchadisedata->is_attribute=="1")
                                                <label class="radio-inline">
                                                    <input type="radio" name="is_attribute" id="inlineRadio1" checked="" value="{{ $merchadisedata->is_attribute }}"> Yes 
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="is_attribute" id="inlineRadio2" > No
                                                </label>
                                            @elseif ($merchadisedata->is_attribute=="0")
                                                <label class="radio-inline">
                                                    <input type="radio" name="is_attribute" id="inlineRadio1"> Yes 
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="is_attribute" id="inlineRadio2" checked="" value="{{ $merchadisedata->is_attribute }}"> No
                                                </label>
                                            @endif
                                        </div>
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
                <div class="panel-heading mt-5" style="text-align: center;"> 
                    <h3 class="mb-2 panel-title">Product Attributes</h3> 
                </div>
                <table id="products" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
                    <thead>
                        <tr>
                            <th>Attribute Size</th>
                            <th>Attribute Stock</th>
                            <th>Attribute Price</th>
                            <th>Attribute Sku</th>
                            <th>Attribute Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $merchadisedata->merchadiseattributes as $attribute)
                            <tr>
                                <td>{{ $attribute->productattr_size}}</td>
                                <td>
                                    {{ $attribute->productattr_stock }}
                                </td>
                                <td>
                                    {{ $attribute->productattr_price }}
                                </td>
                                <td>{{ $attribute->productattr_sku }}</td>
                                <td>
                                    @if ($attribute->productattr_status==0)
                                        <a href="updateattributestatus" id="attribute-{{$attribute->id}}" attribute_id="{{$attribute->id}}" href="javascript:void(0)">Active</a>
                                    @else
                                    <a href="updateattributestatus" id="attribute-{{$attribute->id}}" attribute_id="{{$attribute->id}}" href="javascript:void(0)">InActive</a>
                                    @endif{{ $attribute->productattr_status}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>  
            </section>
        </div>
        {{-- <div class="col-lg-12 text-center">
            <div class="section-title">
                <h3>Update Product Details</h3>
            </div>
        </div> --}}
        <!-- end col -->
                    
                            {{-- <div id="one" class="tab-pane active show fade ">
                                @if(Session::has('success_message'))
                                    <div class="alert alert-success">
                                        {{Session::get('success_message')}}
                                    </div>
                                @endif
                                {{-- Add A merchadise
                                <div class="container">
                                    <form action="{{ url('admin/attributes/'.$merchadisedata['id']) }}" method="POST" id="contactFormSendMail" class="form" >
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="well-box">
                                                    <h2>Add a Merchadise Attribute</h2>
                                                    
                                                    <!-- Text input-->
                                                    <div class="form_group">
                                                        <div class="field_wrapper">
                                                            <div>
                                                                <input id="productattr_size" type="text" name="productattr_size[]" value="" placeholder="productattr_size" style="width: 100px"/>
                                                                <input id="productattr_stock" type="number" name="productattr_stock[]" value="" placeholder="productattr_stock" style="width: 100px"/>
                                                                <input id="productattr_price" type="number" name="productattr_price[]" value="" placeholder="productattr_price" style="width: 100px"/>
                                                                <input id="product_id" type="hidden" name="product_id[]" value="" placeholder="product_id" style="width: 100px"/>
                                                                <input id="productattr_sku" type="text" name="productattr_sku[]" value="" placeholder="productattr_sku" style="width: 100px"/>
                                                                <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary btn-sm btn-block">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    
                                    </form>
                                </div>
                            </div> --}}
        
        <!-- end col -->
    </div>
</div>
@endsection