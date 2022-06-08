<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogcategory;
use App\Models\Blogpost;


class Blogcategory_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Blogpost::all();
        $data=Blogcategory::all();
        return view('backend.blogs.blogcategories',['data'=>$data,'title'=>'All Categories']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.blogs.addblogcategory');
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
            'blogcat_title'=>'required'
        ]);
        // if($request->hasFile('blogcat_image')){
        //    $image=$request->file('blogcat_image');
        //    $blogcatimage=$request->get('blogcat_title').'.'.$image->getClientOriginalExtension();
        //    $dest=public_path('blogcategories/');
        //    $image->move($dest,$blogcatimage);

        // }else{
        //     $blogimage='na';
            
        // }

           $blogcategory=new Blogcategory;
           $blogcategory->blogcat_title=$request->blogcat_title;
        //    $blogcategory->blogcat_image=$blogcatimage;
           $blogcategory->save();
           
           return redirect('admin/blogcategory')->with('success','The Blog Category has Been Added');
       
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Blogcategory::find($id);

        return view('backend.blogs.blogcategoryupdate',['data'=>$data]);
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
            'blogcat_title'=>'required'
        ]);

        // if($request->hasFile('blogcat_image')){
        //    $image=$request->file('blogcat_image');
        //    $blogcatimage=$request->get('blogcat_title').'.'.$image->getClientOriginalExtension();
        //    $dest=public_path('blogcategories/');
        //    $image->move($dest,$blogcatimage);

        // }else{
        //     $blogcatimage=$request->blogcat_image;
            
        // }

           $blogcategory=Blogcategory::find($id);

           $blogcategory->blogcat_title=$request->blogcat_title;
        //    $blogcategory->blogcat_image=$blogcatimage;
           $blogcategory->save();
           
           return redirect('admin/blogcategory')->with('success','The Blog Category has Been Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Blogcategory::where('id',$id)->delete();

        return redirect('admin/blogcategory')->with('success','The Blog Category has Been Deleted Successfully');
    }
}
