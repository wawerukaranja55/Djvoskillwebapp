<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\coupon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Merchadisecategory;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allcoupons=coupon::all();
        
        return view('backend.merchadise.coupons',compact('allcoupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prodctcategories=Merchadisecategory::all();
        $couponusers=User::select('email')->where('status',1)->get();
        
        return view('backend.merchadise.createcoupon',['couponusers'=>$couponusers,'prodctcategories'=>$prodctcategories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            $data=$request->all();

            $rules=[
                'coupon_option'=>'required',
                'coupon_type'=>'required',
                'amount_type'=>'required',
                'amount'=>'required',
                'expiry_date'=>'required',
                'prodcategories'=>'required',
                // 'couponusers'=>'required',
            ];

            $custommessages=[
                // 'couponusers.required'=>'Select Users',
                'prodcategories.required'=>'Select Categories',
                'coupon_option.required'=>'Select a Coupon Option',
                'coupon_type.required'=>'Select a Coupon Type',
                'amount_type.required'=>'Select Amount Type',
                'amount.required'=>'Enter Amount',
                'amount.numeric'=>'Enter a Valid Amount',
                'expiry_date.required'=>'Select Expiry Date',
            ];
            $this->validate($request,$rules,$custommessages);

            if(isset($data['couponusers'])){
                $users=implode(',',$data['couponusers']);
            }else{
                $users="";
            }
            

            if(isset($data['prodcategories'])){
                $categories=implode(',',$data['prodcategories']);
                
            }else{
                $categories="";
            }
            
            if($data['coupon_option']=="Automatic Coupon"){
                $coupon_code=Str::random(6);
            }else{
                $coupon_code=$data['coupon_code'];
            }
            
            $coupon=new coupon();
            $selectcats=array();
            $selectusers=array();
            $coupon->coupon_option=$data['coupon_option'];
            $coupon->coupon_type=$data['coupon_type'];
            $coupon->coupon_code=$coupon_code;
            $coupon->amount_type=$data['amount_type'];
            $coupon->amount=$data['amount'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->categories=$categories;
            $coupon->users=$users;
            $coupon->save();

            return redirect()->route('coupons.index')->with(compact('coupon','categories','users'))->with('success','Coupon has been added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon=coupon::find($id);
        $selectcats=explode(',',$coupon->categories);
        $selectusers=explode(',',$coupon->users);
        $prodctcategories=Merchadisecategory::all();
        $couponusers=User::select('email')->where('status',1)->get();
        return view('backend.merchadise.updatecoupon',['selectusers'=>$selectusers,'selectcats'=>$selectcats,'coupon'=>$coupon,'prodctcategories'=>$prodctcategories,'couponusers'=>$couponusers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $data=$request->all();

        $rules=[
            'coupon_option'=>'required',
            'coupon_type'=>'required',
            'amount_type'=>'required',
            'amount'=>'required',
            'expiry_date'=>'required',
            'prodcategories'=>'required',
            // 'couponusers'=>'required',
        ];

        $custommessages=[
            // 'couponusers.required'=>'Select Users',
            'prodcategories.required'=>'Select Categories',
            'coupon_option.required'=>'Select a Coupon Option',
            'coupon_type.required'=>'Select a Coupon Type',
            'amount_type.required'=>'Select Amount Type',
            'amount.required'=>'Enter Amount',
            'amount.numeric'=>'Enter a Valid Amount',
            'expiry_date.required'=>'Select Expiry Date',
        ];
        $this->validate($request,$rules,$custommessages);

        if(isset($data['couponusers'])){
            $users=implode(',',$data['couponusers']);
        }
        

        if(isset($data['prodcategories'])){
            $categories=implode(',',$data['prodcategories']);
            
        }
        
        
        $coupon=coupon::find($id);
        $coupon->coupon_option=$data['coupon_option'];
        $coupon->coupon_type=$data['coupon_type'];
        $coupon->amount_type=$data['amount_type'];
        $coupon->amount=$data['amount'];
        $coupon->expiry_date=$data['expiry_date'];
        $coupon->categories=$categories;
        $coupon->users=$users;
        $coupon->save();

        return redirect()->route('coupons.index')->with(compact('coupon','categories','users'))->with('success','Coupon has been added Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(coupon $coupon)
    {
        //
    }
}
