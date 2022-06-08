<?php

namespace App\Http\Controllers;

use App\Models\Blogtag;
use App\Models\Blogpost;
use App\Models\Blogcomment;
use App\Models\Blogcategory;
use App\Models\Postcomments;
use Illuminate\Http\Request;

class Blogpost_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogcomments= Postcomments::all();
        $tags=Blogtag::all();
        $blogcats=Blogcategory::all();
        $data=Blogpost::all();
        
        return view('backend.blogs.bloglist',['blogcomments'=>$blogcomments,'data'=>$data,'blogcats'=>$blogcats,'tags'=>$tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogcats=Blogcategory::all();
        $blogtags=Blogtag::all();
        return view('backend.blogs.addblogpost',['blogcats'=>$blogcats,'blogtags'=>$blogtags ]);
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
            'blo_title'=>'required',
            'blo_details'=>'required',
        ]);

        if($request->hasfile('blo_image')){
            $postimage=$request->file('blo_image');
            $blogpostimage=$request->get('blo_title').'.'.$postimage->getClientOriginalExtension();
            $dest=public_path('/blogposts');
            $postimage->move($dest,$blogpostimage);
        } else {
            $blogpostimage='na';
        }
       
        $blogpost=new Blogpost;
        $blogpost->user_id=0;
        $blogpost->cat_id=$request->blocategory;
        $blogpost->blo_title=$request->blo_title;
        $blogpost->blo_details=$request->blo_details;

        $blogpost->blo_image=$blogpostimage;
        $blogpost->save();

        $blogpost->blogtags()->attach(request('tags'));

        return redirect('admin/blogpost')->with('success','The Blogpost had been added succesfully');
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
        $blogtags=Blogtag::all();
        $blogcats=Blogcategory::all();
        $data=Blogpost::find($id);
        return view('backend.blogs.blogpostupdate',['blogcats'=>$blogcats,'blogtags'=>$blogtags,'data'=>$data]);
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
            'blo_title'=>'required',
            'blo_details'=>'required',
        ]);

        
        if($request->hasfile('blo_image')){
            $postimage=$request->file('blo_image');
            $blogpostimage=$request->get('blo_title').'.'.$postimage->getClientOriginalExtension();
            $dest=public_path('/blogposts');
            $postimage->move($dest,$blogpostimage);
        } else {
            $blogpostimage=$request->blo_image;
        }
       
        $blogpost=Blogpost::find($id);
        $tags=Blogtag::all();
        $blogpost->cat_id=$request->blocategory;
        $blogpost->blo_title=$request->blo_title;
        $blogpost->blo_details=$request->blo_details;
        $blogpost->blogtags()->sync($request->blogtags);
        $blogpost->blo_image=$blogpostimage;
        $blogpost->save();

        return redirect('admin/blogpost/'.$id.'/edit',['blogpost'=>$blogpost,'tags'=>$tags])->with('success','The Blogpost had been Updated succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blogpost::where('id',$id)->delete();

        return redirect('admin/blogpost')->with('success','The Blogpost had been Deleted succesfully');
    }
}
