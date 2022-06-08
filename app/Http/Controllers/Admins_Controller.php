<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class Admins_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins=User::where('is_admin',1)->get();
        return view('backend.alladmins',compact('admins'));
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
     *  @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles=Role::all();
        $admin=$user;
        return view('backend.show-admin', ['admin'=>$user,'roles'=>$roles,]);
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
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user )
    {

        $role=Role::where('id',$request->rolename)->first();
        if($role->Role_name!=='Regular User' && $user->is_admin=1)
        {
            $user->roles()->sync($role);
        }
        elseif($role->Role_name='Regular User' && $user->is_admin=1){
            $user->roles()->sync($role);
            $user->update(['is_admin'=>0]);
        }

         $user->role_id=$request->rolename;
         $user->save();

        //  dd($role);
        return redirect()->route('admins.index')->withsuccess (Ucwords($user->name). 'has been Assigned Another Role');
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
