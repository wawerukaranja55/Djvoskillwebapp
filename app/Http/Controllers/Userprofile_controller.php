<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Events;
use App\Models\Events_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Userprofile_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events=Events::latest()->take(4)->get();
        $user=User::findorfail($id);

        return view('frontend.userprofile',['events'=>$events,'user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findorfail($id);
        $events=Events::latest()->take(4)->get();
        return view('frontend.userprofileupdate',['user'=>$user,'events'=>$events]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>['required','string','max:255'],
            'email'=>['required','string','max:255'],
            'avatar'=>['file:jpeg,jpg,png,gif,csv,txt,pdf|max:5048'],
        ]);

        
        if($request->hasfile('avatar')){
            $userimage=$request->file('avatar');
            $eachimageuser=$request->get('name').'.'.$userimage->getClientOriginalExtension();
            $dest=public_path('/usersimages');
            $userimage->move($dest,$eachimageuser);
        } else {
            $eachimageuser=$request->avatar;
        }
        $user=User::findorfail($id);
        $user->email=$request->email;
        $user->name=$request->name;
        $user->avatar=$eachimageuser;
        
        $user->save();
        
        
        return redirect( route('userprofile.show',Auth::user()->id))->with ('success','Your Profile has been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
