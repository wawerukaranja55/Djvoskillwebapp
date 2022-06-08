<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Mixxes_Model;
use Illuminate\Http\Request;
use App\Notifications\Newmixadded;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

// use File;

class Mix_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mixxes=Mixxes_Model::latest()->paginate(5);

        return view('backend.audiomixxes.allmixxes',compact('mixxes'))->with(request()->input('page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('backend.audiomixxes.addmix'); 
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
            'mix_name'=>'required',
            'mix_audio'=>'required|mimes:M4a,mp3',
            'mix_length'=>'required',
            'mix_size'=>'required',
            'mix_image'=>'required|mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:5048',
            
        ]);
        
       

        $mix_id=DB::table('mixxes')->latest()->first();

        $file=$request->file('mix_audio');
        if($file->isValid())
        {
            $destinationPath='mixtapes/';
            $mixaudio=$request->get('mix_name').'.'.$file->getClientOriginalExtension();
            // $mixsize= $request->file('file')->getClientSize();
            //$mix_audio=$mix_name.'.'.$request->get('mix_name').'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$mixaudio);
        }
        
        $file=$request->file('mix_image');
        if($file->isValid())
        {
            $destinationPath='miximages/';
            $miximage=$request->get('mix_name').'.'.$file->getClientOriginalExtension();
            //$miximage=$id.'.'.$request->get('mix_image').'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$miximage);
        }

        $data = $request->all();

        $mix = new Mixxes_Model;

        $mix->mix_name = $request->get('mix_name');
        $mix->mix_size = $request->get('mix_size');
        $mix->mix_length = $request->get('mix_length');
        $mix->mix_image =$miximage;;
        $mix->mix_audio =$mixaudio;
        $mix->save();

        $subscribers=Subscriber::all();
        foreach($subscribers as $subscriber)
        {
            Notification::route('mail',$subscriber->email)
            ->notify(new Newmixadded($mix));
        }
        

        return redirect()->route('mixxes.index')->with('success','Mixtape Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id) {    
        $mixxes=Mixxes_Model::find($id);
        return view('admin.audiomixxes.viewmix',compact('mixxes'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function download ($mix_audio)
    {
        return response()->download('mixtapes/'.$mix_audio);
    }


    public function edit($id)
    {
        $mix=Mixxes_Model::find($id);
        return view('backend.audiomixxes.editmix',compact('mix'));
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
            'mix_name'=>'required',
            'mix_audio'=>'required|mimes:M4a,mp3',
            'mix_length'=>'required',
            'mix_size'=>'required',
            'mix_image'=>'required|mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:5048',
        ]);
        
        $mix=Mixxes_Model::find($id);
        $file=$request->mix_image;
        if($request->hasFile('mix_image') && $file->isValid())
        {   
            $destinationPath='miximages/';
            $miximage=$request->get('mix_name').'.'.$file->getClientOriginalExtension();
            //$miximage=$id.'.'.$request->get('mix_image').'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$miximage);
            $mixUpdate['mix_image'] = $miximage;

            $destinationPath='miximages/';
            //$image=date('YmdHis').'.'.$file->getClientOriginalExtension();
            $image=$id.'_'.$request->get('product_name').'.'.$file->getClientOriginalExtension();
            $file->move($destinationPath,$image);
            $productUpdate['pro_image'] = $image;
        }

        $mixUpdate = [
            'mix_name' => $request->mix_name,
            'mix_length' => $request->mix_length,
            'mix_size' => $request->mix_size,
        ];
        
        
        Mixxes_Model::where('id',$id)->update($mixUpdate);


        return redirect()->route('mixxes.index')->with('success','Mixtape Details Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteData=Mixxes_Model::FindorFail($id);
        $deleteData->delete();
        return redirect()->route ('mixxes.index')->with ('success','Mixtape Details has Been Deleted Successfully');
    }

    public function fileInfo($filePath)
    {
        $file = array();
        $file['name'] = $filePath['filename'];
        $file['extension'] = $filePath['extension'];
        $file['size'] = filesize($filePath['dirname'] . 'mixtapes/' . $filePath['basename']);

        return $file;
    }
}
