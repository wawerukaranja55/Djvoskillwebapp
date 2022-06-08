
@extends('backend.adminmaster')
@section('title','Mpesa Payments')
@section('content')
<div class="row shadow mb-5 bg-black rounded">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <a class="btn btn-success" href="#">Paypal Payments</a>
        </div>
    </div>
    <div class="col-lg-12">
      <div class="panel-heading mt-5" style="text-align: center;"> 
          <h3 class="mb-2 panel-title">All Mpesa Payments</h3> 
      </div>
      <table id="products" class="table table-striped table-bordered nowrap" style="width:100%; border:2px solid black;">
          <thead>
              <tr>
                  <th>Id</th>
                  <th>Phone</th>
                  <th>Amount</th>
                  <th>Transaction ID</th>
                  <th>Date Of Transaction</th>
                  <th>User Who Paid</th>
                  <th>Action</th>
              </tr>
          </thead>
          <tbody>
              @foreach($mpesapayments as $mpesa)
                  <tr>
                      <td>{{$mpesa->id}}</td>
                      <td>{{$mpesa->phone}}</td>
                      <td>{{$mpesa->amount }}</td>
                      <td>{{$mpesa->mpesatransaction_id}}</td>
                      <td>{{$mpesa->created_at}}</td>
                      <td>Paid By Waweru</td>
                      <td>
                          <a class="btn btn-primary btn-xs" title="View The Payment Details" href="#"><i class="fa fa-edit"></i></a>
                          <a class="btn btn-primary btn-xs" title="Download Payment Receipt" href="#"><i class="fa fa-download"></i></a>
                          <a class="btn btn-primary btn-xs" onclick="confirm return('Are you Sure You want to Delete?')" href="#"><i class="fa fa-trash"></i></a>
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
    </div>
</div>
@endsection

