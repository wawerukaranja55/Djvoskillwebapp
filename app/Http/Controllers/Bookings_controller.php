<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;
use App\Models\Bookingcategory;
use App\Http\Controllers\Controller;
use App\Models\bookingpackage;
use App\Models\Bookingstatus;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Approvedbookings;
use App\Notifications\Checknewbooking;
use App\Notifications\Newbookingrecieved;
use Illuminate\Support\Facades\Notification;

class Bookings_controller extends Controller
{
    // public function allbookings()
    // public function firstapproval() done
    // public function secondapproval()
    // public function published()
    // public function cancelled()

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings=Bookings::all();
        $bookingcats=Bookingcategory::all();
        
        return view('backend.bookings.bookingsfromclients',['bookings'=>$bookings,'bookingcats'=>$bookingcats]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bookingcats=Bookingcategory::all();
        return view('frontend.contact',['bookingcats'=>$bookingcats]);
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
            'phone'=>'required',
            'date'=>'required',
            'event_details'=>'required',
        ]);
       
        $booking=new Bookings;
        $booking->event_id=$request->eventcategory;
        $booking->full_name=$request->full_name;
        $booking->location=$request->location;
        $booking->email=$request->email;
        $booking->phone=$request->phone;
        $booking->date=$request->date;
        $booking->event_details=$request->event_details;
        
        $booking->save();

        // $users=User::where('role_id','1')->first();
        // Notification::send($users,new Checknewbooking($booking));

        return redirect('/contact')->with('success','We have successfully received the Booking.We Will Get back to you ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking=Bookings::findorfail($id);
        $bookingcats=Bookingcategory::all();
        $status=Bookingstatus::all();
        
        return view('backend.bookings.singlebooking',['bookingcats'=>$bookingcats,'booking'=>$booking,'status'=>$status]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookings  $bookings
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookings $bookings)
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
    public function update(Request $request,$id)
    {    
        $bookingstatus=Bookings::where('id',$request->id)->first();
        if($bookingstatus->is_booking==0)
        {
            $bookingstatus->is_booking=1;
            $bookingstatus->save();
        }
        else {
            $bookingstatus->is_booking=0;
            $bookingstatus->save();
        }
        
        $users=User::where('role_id','3')->first();
        Notification::send($users,new Approvedbookings($bookingstatus));

        return redirect()->back()->with('success','The Booking has successfully been Aproved to the accountant');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookings  $bookings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bookings $bookings)
    {
        //
    }

    // First Approval by the Manager

    public function approved()
    {
        // $bookings=Bookings::all();
        $bookings=Bookings::where('is_booking',1)->get();
        $bookingcats=Bookingcategory::all();
        
        return view('backend.bookings.firstapproval',['bookings'=>$bookings,'bookingcats'=>$bookingcats]);
    }

    // Bookings paid by the client's

    // For the Accountant

    public function depositpaid()
    {
        $bookings=Bookings::where('is_booking',2)->get();
        $bookingcats=Bookingcategory::all();
        
        return view('backend.bookings.paidbookings',['bookings'=>$bookings,'bookingcats'=>$bookingcats]);
    }

    // Request payment from the client

    public function requestpayment($id)
    {
        $booking=Bookings::findorfail($id);
        $bookingcats=Bookingcategory::all();
        $status=Bookingstatus::all();
        
        return view('backend.bookings.requestpayment',['bookingcats'=>$bookingcats,'booking'=>$booking,'status'=>$status]);
    }

    // First Approval by the Manager

    public function cancelledbookings()
    {
        $bookings=Bookings::where('is_booking',2)->get();
        $bookingcats=Bookingcategory::all();
        
        return view('backend.bookings.cancelled',['bookings'=>$bookings,'bookingcats'=>$bookingcats]);
    }

    // Show notifications to the admins

    public function mynotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        return view('backend.mynotifications',['notifications'=>Auth()->user()->notifications->take(4)]);
    }
}
