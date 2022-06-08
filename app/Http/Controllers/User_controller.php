<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\user;
use Illuminate\Http\Request;

class User_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::where('is_admin',0)->get();
        return view('backend.normalusers',compact('users'));
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
    public function show(User  $user)
    {
        $admins=User::where('is_admin',1)->get();
        $allroles=Role::all();
        return view('backend.show-user',[
            'user'=>$user,'allroles'=>$allroles
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function profile(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        $role=Role::where('id',$request->rolename)->first();
        if($user->is_admin!=1 && $role->Role_name!='Normal User'){
            $user->roles()->sync($role);
            $user->update(['is_admin'=>1]);
        }

        $user->role_id=$request->rolename;
        $user->save();
        // dd($role);
        return redirect()->route('users.index')->withsuccess (Ucwords($user->name). 'has been Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        //
    }
}
