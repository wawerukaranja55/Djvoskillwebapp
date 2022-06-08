<?php

namespace App\Http\Controllers;

use App\Models\Blogpost;
use App\Models\Bookings;
use App\Models\Events;
use App\Models\Events_Model;
use App\Models\Merchadise;
use App\Models\Mixxes_Model;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class AdminDashboard_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $adminposts =Blogpost::latest()->take(4)->get();
        $user=User::all();
        $posts=Blogpost::all();
        $mixxes=Mixxes_Model::all();
        $bookings=Bookings::all();
        $events=Events::all();
        $merchadise=Merchadise::latest()->take(4)->get();
        $merchadisedata=Merchadise::all();
        auth()->user()->unreadNotifications->markAsRead();
       // return $user[0];
        return view('backend.admindashboard',compact('merchadise','merchadisedata','user','bookings','adminposts','posts','mixxes','events',['notifications'=>Auth()->user()->notifications->take(4)],));
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
        //
    }
}
