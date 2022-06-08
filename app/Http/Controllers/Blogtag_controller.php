<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogtag;

class Blogtag_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogtags=Blogtag::all();

        return view('backend.blogtags.tagslist',['blogtags'=>$blogtags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogtags.addtag');
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
            'blogtag_title'=>'required'
        ]);

        $blogtag=new Blogtag;
        $blogtag->blogtag_title=$request->blogtag_title;
        $blogtag->save();

        return redirect('admin/blogtags')->with('success','The Blogtag Has Been Added Successfully');
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
        $data=Blogtag::find($id);

        return view('backend.blogtags.tagupdate',['data'=>$data]);
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
        $request->validate([
            'blogtag_title'=>'required'
        ]);
        
        $blogtag=Blogtag::find($id);

        $blogtag->blogtag_title=$request->blogtag_title;
        $blogtag->save();
           
           return redirect('admin/blogtags')->with('success','The Post tag has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blogtag::where('id',$id)->delete();
        return redirect('admin/blogtags');
    }
}
