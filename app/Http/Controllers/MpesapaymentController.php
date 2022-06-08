<?php

namespace App\Http\Controllers;

use App\Models\mpesapayment;
use Illuminate\Http\Request;

class MpesapaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // show all payments made via bought via mpesa
        $mpesapayments=mpesapayment::all();

        return view('backend.merchadise.mpesapayments',compact('mpesapayments'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mpesapayment  $mpesapayment
     * @return \Illuminate\Http\Response
     */
    public function show(mpesapayment $mpesapayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mpesapayment  $mpesapayment
     * @return \Illuminate\Http\Response
     */
    public function edit(mpesapayment $mpesapayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mpesapayment  $mpesapayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, mpesapayment $mpesapayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mpesapayment  $mpesapayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(mpesapayment $mpesapayment)
    {
        //
    }
}
