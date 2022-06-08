<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use Illuminate\Support\Str;
use App\Models\Postcomments;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class PostComment_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogcomments=Postcomments::all();
        return view('backend.blogs.blogpostcomments',['blogcomments'=>$blogcomments]);
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
    public function store(Request $request,$id)
    {
        $request->validate([
            'comment'=>'required',
        ]);
        $user=Auth::user();
        $postdetails=Blogpost::find($id);
        $postcomments=Postcomments::create([
            'user_id'=>Auth::id(),
            'post_id'=>$id,
            'comment'=>request()->comment,


        ]);
        return redirect ('blog/post/'.Str::slug($postdetails->blo_title).'/'.$postdetails->id)->with('success','Comment has been added Successfully');
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
        $deletecomment=Postcomments::FindorFail($id);
        $deletecomment->delete();
        return redirect()->back()->with ('success','The Comment has Been Deleted Successfully');
    }

}
