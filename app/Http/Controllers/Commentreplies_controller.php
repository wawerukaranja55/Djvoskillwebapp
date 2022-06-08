<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use Illuminate\Support\Str;
use App\Models\Commentreply;
use App\Models\Postcomments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Commentreplies_controller extends Controller
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
            'reply'=>'required',
        ]);
        $postdetails=Blogpost::find($id);
        $postcomments=Postcomments::find($id);
        $commentreplies=Commentreply::create([
            'user_id'=>Auth::id(),
            'comment_id'=>$id,
            'reply'=>request()->reply,


        ]);
        return redirect ('blog/post/'.Str::slug($postdetails->blo_title).'/'.$postdetails->id)->with('success','Your reply has been added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commentreply  $commentreply
     * @return \Illuminate\Http\Response
     */
    public function show(Commentreply $commentreply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commentreply  $commentreply
     * @return \Illuminate\Http\Response
     */
    public function edit(Commentreply $commentreply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commentreply  $commentreply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commentreply $commentreply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commentreply  $commentreply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commentreply $commentreply)
    {
        //
    }
}
