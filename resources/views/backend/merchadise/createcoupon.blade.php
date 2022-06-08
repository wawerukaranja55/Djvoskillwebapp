@extends('backend.adminmaster')
@section('title','Create a Coupon')
@section('content')
<div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
  <div class="card-body p-4 p-md-5">
    <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Create  A Coupon Code</h3>
    <form role="form"  action="{{ route('coupons.store') }}" method="post" >
      @csrf
        <div class="row form-group {{$errors->has('coupon_option')?' has-error':''}}" >
          <div class="col-md-12 mb-4">
            <h6 class="mb-2 pb-1 form-label" style="text-align: center">Coupon Option: </h6>
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="coupon_option">Automatic</label>
              <input class="form-check-input" type="radio" name="coupon_option" id="automaticcoupon"  value="Automatic Coupon"/>
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="coupon_option">Manual</label>
              <input class="form-check-input" type="radio" name="coupon_option" id="manualcoupon" value="Manual Coupon" />
            </div>
          </div>

          <div class="form-outline" style="display: none;" id="coupon_field">
            <label class="form-label" for="coupon_code">Enter The Coupon Code</label>
            <input placeholder="Enter Coupon Code Here" type="text" id="coupon_code" class="form-control form-control-lg" name="coupon_code" />
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
            <h6 class="mb-2 pb-1 form-label" style="text-align: center">Coupon Type: </h6>
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="coupon_type">Single</label>
              <input class="form-check-input" type="radio" name="coupon_type"  value="Single Time"/>
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="coupon_type">Multiple Times</label>
              <input class="form-check-input" type="radio" name="coupon_type" value="Multiple Times" />
            </div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
            <h6 class="mb-2 pb-1 form-label" style="text-align: center">Amount Type: </h6>
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="amount_type">Percentage(%)</label>
              <input class="form-check-input" type="radio" name="amount_type"  value="Percentage"/>
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="amount_type">Fixed(Ksh)</label>
              <input class="form-check-input" type="radio" name="amount_type" value="Fixed" />
            </div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
              <div class="form-outline">
                  <label class="form-label" for="amount">Amount</label>
                  <input type="number" id="amount" name="amount" class="form-control form-control-lg" style="background: rgb(196, 191, 191);"/>
              </div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
              <div class="form-outline">
                  <label class="form-label" for="expiry_date">Expiry Date</label>
                  <input type="text" id="expiry_date" name="expiry_date" class="form-control form-control-lg" style="background: rgb(196, 191, 191);"/>
              </div>
          </div>
        </div>


        <div class="form-group">
          <label for="FormControlSelect">Product Categories</label>
          <select name="prodcategories[]" class="couponselect2 form-control" multiple="multiple">
            <option>Select Product Categories</option>
            @foreach($prodctcategories as $prodCategory)
                <option value="{{ $prodCategory->id }}">{{ $prodCategory->merchadisecat_title }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="FormControlSelect">Users</label>
          <select name="couponusers[]" class="usersselect2 form-control" multiple="multiple" >
            <option>Select Users</option>
            @foreach($couponusers as $couponuser)
                <option value="{{ $couponuser->email }}">{{ $couponuser->email }}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn-primary btn-lg"> Submit </button>
    </form>
  </div>
</div>
@endsection

