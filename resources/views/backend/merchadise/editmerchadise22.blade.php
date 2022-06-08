
@extends('admin.master')
@section('title','Edit A Product')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <h2>Edit The Product</h2>
        <div class="container mt-5">
            <!-- Success message -->
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please Check The Details Again</strong>
                <ul>
                    @foreach ($errors ->all() as $error)
                       <li>{{ $error }}</li> 
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('products.update',$product->id) }}" enctype="multipart/form-data">
                
                {{ csrf_field() }}
                @method('PATCH') 

                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control {{ $errors->has('pro_name') ? 'error' : '' }}" name="pro_name" id="pro_name" value="{{ old('pro_name') ?? $product->pro_name }}">
                    <!-- Error -->
                    @if ($errors->has('pro_name'))
                    <div class="error">
                        {{ $errors->first('pro_name') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Available Stock</label>
                    <input type="text" class="form-control {{ $errors->has('stock') ? 'error' : '' }}" name="stock"
                        id="stock" value="{{ old('stock') ?? $product->stock }}">
    
                    @if ($errors->has('stock'))
                    <div class="error">
                        {{ $errors->first('stock') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Product Price</label>
                    <input type="text" class="form-control {{ $errors->has('pro_price') ? 'error' : '' }}" name="pro_price"
                        id="pro_price" value="{{ old('pro_price') ?? $product->pro_price }}">
    
                    @if ($errors->has('pro_price'))
                    <div class="error">
                        {{ $errors->first('pro_price') }}
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Spl Price</label>
                    <input type="text" name="spl_price" class="form-control {{ $errors->has('spl_price') ? 'error' : '' }}" name="pro_price"
                        id="spl_price" value="{{ old('spl_price') ?? $product->spl_price }}">
                </div>
    
                <div class="form-group">
                    <label>Product Code</label>
                    <input type="text" class="form-control {{ $errors->has('pro_code') ? 'error' : '' }}" name="pro_code"
                        id="pro_code" value="{{ old('pro_code') ?? $product->pro_code }}">
    
                    @if ($errors->has('pro_code'))
                    <div class="error">
                        {{ $errors->first('pro_code') }}
                    </div>
                    @endif
                </div>
    
                <div class="form-group">
                    <label for="FormControlSelect">Product Category</label>
                    
                    <select name="category_id" class="form-control" id="FormControlSelect" value="{{ old('category_id') ?? $product->category_id }}">
                      @foreach($ProductCategories as $productcategory)
                        <option value="{{ $productcategory->id }}">{{ $productcategory->name }}</option>
                      @endforeach
                    </select>
                </div>
    
                <div class="form-group">
                    <label>Product Details</label>
                    <textarea class="form-control {{ $errors->has('pro_info') ? 'error' : '' }}" name="pro_info" id="pro_info"
                        rows="4">{{ old('pro_info') ?? $product->pro_info }}
                    </textarea>
    
                    @if ($errors->has('pro_info'))
                    <div class="error">
                        {{ $errors->first('pro_info') }}
                    </div>
                    @endif
                </div>
                <br>
                <!-- Main Image Button--->
                @if ($product->pro_image)
                   <img src="{{ asset ('productimages/'.$product->pro_image) }}" style="width:120px; border:2px solid black;height:80px;"> 
                @endif
                <label for="file">Change Product-Image</label>
                <input type="file" name="pro_image" onchange="readURL(this);" value="{{ $product->pro_image }}"/>
                <img id="pro_image" style="width: 100px;"  src="{{asset('dist/admin/productimages')}}"/>
                <br>

                <button type="submit" class="btn btn-dark btn-block">Update </button>
            </form>
        </div>
</div>
@endsection