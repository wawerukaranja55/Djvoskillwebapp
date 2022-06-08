<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogcomment;
use App\Models\Blogpost;

class BlogpostComment_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogcomments=Blogcomment::all();

        return view('admin.blogs.blogpostcomments',['blogcomments'=>$blogcomments]);
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
            'comment_author'=>'required',
            'comment_email'=>'required',
            'post_comment'=>'required',
        ]);

        $blogpostcomment=new Blogcomment;

        $blogpostcomment->post_id=$request->post_id;
        $blogpostcomment->comment_author=$request->comment_author;
        $blogpostcomment->comment_email=$request->comment_email;
        $blogpostcomment->post_comment=$request->post_comment;

        $blogpostcomment->save();

        return redirect()->back()->with('success','Your Comment Has Been Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogpost=Blogpost::findorfail($id);
        $comments=$blogpost->blogcomments;

        return view('admin.blogs.postcomments',compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $blogcomments=Blogcomment::find($id);
        return view('admin.blogs.blogpostcomments',['blogcomments'=>$blogcomments]);
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
        Blogcomment::findorfail($id)->update($request->all());

        return redirect('admin/blogcomments/{$blogcomment->id}');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blogcomment::where('id',$id)->delete();

        return redirect('admin/blogcomments')->with('success','The Comment have been Deleted succesfully');
    }
}
