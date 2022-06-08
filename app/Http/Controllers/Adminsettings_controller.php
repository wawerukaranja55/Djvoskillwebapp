<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class Adminsettings_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $setting=Settings::first();
        return view('admin.settings',['setting'=>$setting]);
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
    public function save_settings(Request $request)
    {
        $countData=Settings::count();
        if ( $countData==0){
            $data=new Settings;
            $data->comment_auto=$request->comment_auto;
            $data->user_auto=$request->user_auto;
            $data->recent_limit=$request->recent_limit;
            $data->popular_limit=$request->popular_limit;
            $data->recent_comment_limit=$request->recent_comment_limit;
            $data->save();
        }else{
            $firstData=Settings::first();
            $data=Settings::find($firstData->id);
            $data->comment_auto=$request->comment_auto;
            $data->user_auto=$request->user_auto;
            $data->recent_limit=$request->recent_limit;
            $data->popular_limit=$request->popular_limit;
            $data->recent_comment_limit=$request->recent_comment_limit;
            $data->save();
        }
        return redirect('admin/settings')->with('success','Settings have been added successfully');
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
