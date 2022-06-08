<?php

namespace App\Http\Controllers;

use App\Models\Merchadisecategory;
use App\Models\merchadisesection;
use Illuminate\Http\Request;

class Merchadisecategory_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchadisecats=Merchadisecategory::get();
        return view('backend.merchadise.merchadisecategories',compact('merchadisecats'));
    }

    // update Coupon status
    public function updatecategorystatus(Request $request)
    {
        $categorystatus=Merchadisecategory::find($request->category_id);
        $categorystatus->status=$request->status;
        $categorystatus->save();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productsections=merchadisesection::where('status',1)->get();
        dd($productsections);die();
        return view('backend.merchadise.addmerchadisecat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'merchadisecat_title'=>'required|unique:merchadisecategories'
        ]);
       
        if(empty($request->category_discount)){
            $category_discount=0;
        }else{
            $category_discount=$request->category_discount;
        }
        $merchadisecategory=new Merchadisecategory();
        $merchadisecategory->merchadisecat_title=$request->merchadisecat_title;
        $merchadisecategory->category_discount=$category_discount;
        $merchadisecategory->save();

        return redirect('admin/merchadise')->with('success','The Category had been Created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Merchadisecategory  $merchadisecategory
     * @return \Illuminate\Http\Response
     */
    public function show(Merchadisecategory $merchadisecategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Merchadisecategory  $merchadisecategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchadisecategory $merchadisecategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Merchadisecategory  $merchadisecategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Merchadisecategory $merchadisecategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Merchadisecategory  $merchadisecategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchadisecategory $merchadisecategory)
    {
        //
    }
}
