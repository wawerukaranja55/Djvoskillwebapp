@extends('backend.adminmaster')
@section('title','Update a Coupon')
@section('content')
<div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
  <div class="card-body p-4 p-md-5">
    <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Update  A Coupon Code</h3>
    <form role="form"  action="{{ url('admin/coupons/'.$coupon->id) }}" method="post" >
        {{ csrf_field() }}
        @method('PUT') 
        <div class="row form-group {{$errors->has('coupon_option')?' has-error':''}}" >
          <div class="col-md-12 mb-4">
              @if (empty($coupon['coupon_code']))
                <h6 class="mb-2 pb-1 form-label" style="text-align: center">Coupon Option: </h6>
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="coupon_option">Automatic</label>
                    <input class="form-check-input" type="radio" name="coupon_option" id="automaticcoupon"  value="Automatic Coupon"/>
                </div>
    
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="coupon_option">Manual</label>
                    <input class="form-check-input" type="radio" name="coupon_option" id="manualcoupon" value="Manual Coupon" />
                </div>
  
                <div class="form-outline" style="display: none;" id="coupon_field">
                <label class="form-label" for="coupon_code">Enter The Coupon Code</label>
                <input placeholder="Enter Coupon Code Here" type="text" id="coupon_code" class="form-control form-control-lg" name="coupon_code" />
                </div>
              @else
                <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}"/>
                <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}"/>
                <div class="form-check form-check-inline">
                    <label class="form-check-label" for="coupon_code">Coupon Code:</label>
                    <span>{{ $coupon['coupon_code'] }}</span>
                </div>
              @endif
            </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
            <h6 class="mb-2 pb-1 form-label" style="text-align: center">Coupon Type: </h6>
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="coupon_type">Single</label>
              <input value="Single Time" @if (isset($coupon['coupon_type']) && $coupon['coupon_type']=="Single Time")
                    checked=""
                @endif class="form-check-input" type="radio" name="coupon_type"/>
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="coupon_type">Multiple Times</label>
              <input value="Multiple Times" @if (isset($coupon['coupon_type']) && $coupon['coupon_type']=="Multiple Times")
                  checked=""
              @elseif(!isset($coupon['coupon_type']))
                  checked=""
              @endif
              class="form-check-input" type="radio" name="coupon_type"/>
            </div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
            <h6 class="mb-2 pb-1 form-label" style="text-align: center">Amount Type: </h6>
            <div class="form-check form-check-inline">
              <label class="form-check-label" for="amount_type">Percentage(%)</label>
              <input value="Percentage" 
                @if (isset($coupon['amount_type']) && $coupon['amount_type']=="Percentage")
                    checked=""
                @elseif(!isset($coupon['amount_type']))
                    checked=""
                @endif
              class="form-check-input" type="radio" name="amount_type"/>
            </div>

            <div class="form-check form-check-inline">
              <label class="form-check-label" for="amount_type">Fixed(Ksh)</label>
              <input value="Fixed"  @if (isset($coupon['amount_type']) && $coupon['amount_type']=="Fixed")
                        checked=""
                    @endif 
                class="form-check-input" type="radio" name="amount_type"/>
            </div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
              <div class="form-outline">
                  <label class="form-label" for="amount">Amount</label>
                  <input @if (isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @endif   
                  type="number" id="amount" name="amount" class="form-control form-control-lg" style="background: rgb(196, 191, 191);"/>
              </div>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-12 mb-4">
              <div class="form-outline">
                  <label class="form-label" for="expiry_date">Expiry Date</label>
                  <input @if (isset($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}" @endif
                  type="text" id="expiry_date" name="expiry_date" class="form-control form-control-lg" style="background: rgb(196, 191, 191);"/>
              </div>
          </div>
        </div>


        <div class="form-group">
          <label for="FormControlSelect">Product Categories</label>
          <select name="prodcategories[]" class="couponselect2 form-control" multiple="multiple">
            <option>Select Product Categories</option>
            @foreach($prodctcategories as $prodCategory)
                <option value="{{ $prodCategory->id }}" 
                    @if(in_array($prodCategory->id,$selectcats)) selected=" " @endif>{{ $prodCategory->merchadisecat_title }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="FormControlSelect">Users</label>
          <select name="couponusers[]" class="usersselect2 form-control" multiple="multiple" >
            <option>Select Users</option>
            @foreach($couponusers as $couponuser)
                <option value="{{ $couponuser->email }}"
                    @if(in_array($couponuser->email,$selectusers)) selected=" " @endif>{{ $couponuser->email }}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn-primary btn-lg"> Submit </button>
    </form>
  </div>
</div>
@endsection

