<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Auth\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Gate as FacadesGate;

class Role_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::all();
        return view('backend.adminroles',['roles'=>$roles]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (FacadesGate::allows('manageRoles')){
        
        //     return view('backend.adminroles');
        // }
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
            'Role_name'=>'required'
        ]);

        $rolename=new Role;
        $rolename->Role_name=$request->Role_name;
        $rolename->save();

        return redirect('admin/roles')->with ('success','The Role has been Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role=Role::findorfail($id);

        return view('backend.showrole',['role'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'Role_name'=>'required'
        ]);

        $rolename=Role::findorfail($id);
        $rolename->Role_name=$request->Role_name;
        $rolename->save();

        return redirect(  route('roles.show',$rolename->id)  )->with ('success','The Role has been Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        session()->flash('role-deleted','Role Deleted Successfully');
        return redirect('admin/roles');
    }
}
