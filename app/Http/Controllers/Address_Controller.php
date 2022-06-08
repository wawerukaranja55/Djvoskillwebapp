<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deliveryaddress;
use Illuminate\Support\Facades\Auth;


class Address_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name'=>'required|min:5|max:40',
            'last_name'=>'required|min:5|max:40',
            'phone'=>'required',
        ]);

        $shippingcost=$request->shipping_amount;

        $address=new Deliveryaddress();
        $address->user_id=Auth::user()->id;
        $address->shipping_cost=$shippingcost;
        $address->county_id=$request->countyname;
        $address->city_id=$request->cityname;
        $address->first_name=$request->first_name;
        $address->last_name=$request->last_name;
        $address->phone=$request->phone;
        $address->pickuppoint=$request->street_address;
        $address->company_name=$request->company_name;
        $address->save();
        return redirect('/checkout')->with('success_message','Your Delivery Address has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
