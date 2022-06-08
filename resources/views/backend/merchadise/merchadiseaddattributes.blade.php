
@extends('backend.adminmaster')
@section('title','Merchadise With Attributes')
@section('content')
<div class="container" style="border:2px solid black; background:rgb(255, 249, 249);">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="section-title">
                <h3>Merchadise with Attributes Manager</h3>
            </div>
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        <a class="btn btn-success" href="{{ route('merchadise.store') }}" >Show All Products</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
        <div class="col-lg-12 schedule-tab">
            <ul id="tabsJustified" class="nav nav-tabs justify-content-center text-center">
                <li class="nav-item">
                    <p class="nav-link">Merchadise List To Add Attributes</p>
                </li>
            </ul>
            <div class="tab-content">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                        @if (!empty($merchadiseattributes))
                        <table id="products" class="table table-striped table-bordered dt-responsive nowrap  order-column" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Id</th>
                                    <th>Merchadise Name</th>
                                    <th>Add Attributes</th>
                                    <th>Merchadise Category</th>
                                    <th>Merchadise price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($merchadiseattributes as $merch)
                                <tr>
                                    <td>{{$merch->id}}</td>
                                    <td>{{$merch->merch_name}}</td>
                                    <td>
                                        <a class="productid" id="{{$merch->id}}" title="Add an Attribute" href="#" data-toggle="modal" data-target="#attributesmodal">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </td>
                                    <td>{{$merch->merchadisecategor->merchadisecat_title }}</td>
                                    <td>{{$merch->merch_price}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
</div>
    <!------ add attribute ------- -->
    <div class="modal fade" id="attributesmodal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                <div class="container">
                    {{--  --}}
                    @foreach ($merchadiseattributes as $attr)
                        <form action="{{ url('admin/attributes/'.$attr->id) }}" method="POST" id="contactFormSendMail" class="form" >
                    @endforeach
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
            </div>
        </div>
    </div>
@endsection

    