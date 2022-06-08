<?php

namespace App\Http\Controllers;

use App\Models\merchadisesection;
use Illuminate\Http\Request;

class Merchadisesection_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allsections=merchadisesection::get();
        return view('backend.merchadise.merchadisesections',compact('allsections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'merchadisesection_title'=>'required|unique:merchadisesections'
        ]);
       
        $merchadisesection=new merchadisesection();
        $merchadisesection->merchadisesection_title=$request->merchadisesection_title;
        $merchadisesection->save();

        return redirect('admin/merchadisesections ')->with('success','The Section had been Created succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\merchadisesection  $merchadisesection
     * @return \Illuminate\Http\Response
     */
    public function show(merchadisesection $merchadisesection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\merchadisesection  $merchadisesection
     * @return \Illuminate\Http\Response
     */
    public function edit(merchadisesection $merchadisesection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\merchadisesection  $merchadisesection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, merchadisesection $merchadisesection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\merchadisesection  $merchadisesection
     * @return \Illuminate\Http\Response
     */
    public function destroy(merchadisesection $merchadisesection)
    {
        //
    }

    // update Section status
    public function updatesectionstatus(Request $request)
    {
        $sectiontatus=merchadisesection::find($request->sectionid);
        $sectiontatus->status=$request->status;
        $sectiontatus->save();
    }
}
