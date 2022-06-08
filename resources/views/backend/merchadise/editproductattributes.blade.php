
@extends('backend.adminmaster')
@section('title','Edit {{ $merchadisedata->merch_name }} Attributes')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <div class="row">
        <div class="container">
            <h2 class="text-center">Update {{ $merchadisedata->merch_name }} Details</h2>
            <div class="col-md-12">
                <form method="post" action="{{ url('admin/edit-attributes/'.$merchadisedata->id) }}">
                    {{csrf_field()}}
                    <table id="products" class="table table-striped table-bordered nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Attribute Size</th>
                                <th>Attribute Stock</th>
                                <th>Attribute Price</th>
                                <th>Attribute Sku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $merchadisedata->merchadiseattributes as $attribute)
                                <input type="text" name="attrid[]" value="{{ $attribute->id }}" style="display: none"/>
                                <tr>
                                    <td>{{ $attribute->productattr_size}}</td>
                                    <td>
                                        <input type="number" name="productattr_stock[]" value="{{ $attribute->productattr_stock }}" required=""/>
                                    </td>
                                    <td>
                                        <input type="number" name="productattr_price[]" value="{{ $attribute->productattr_price }}" required=""/>
                                    </td>
                                    <td>{{ $attribute->productattr_sku }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-sm btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection