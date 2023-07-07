<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Events;
use App\Models\Events_Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class Userprofile_controller extends Controller
{
    

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
        $latest_order=Order::where(['user_id'=>$id])->select('order_status')->orderBy('id', 'desc')->first()->order_status;

        return view('frontend.userprofile',['events'=>$events,'latest_order'=>$latest_order,'user'=>$user]);
    }

    // show all orders for a user
    public function userorders(Request $request)
    {
        $userorders=Order::where(['email'=>Auth::user()->email])->select('id','tracking_id','grand_total','town','payment_method','order_status');

        if($request->ajax()){
            $userorders = DataTables::of ($userorders)
            ->addColumn ('action',function($row){
                return 
                '<a href="/admin/viewpayment/'.$row->id.'/'.$row->date_paid.'" target="_blank" alt="View the Payment Receipt" class="btn btn-success viewpaymentreciept" data-id="'.$row->id.'"><i class="fa fa-eye"></i></a>
                 <a href="/downloadpaymentreceipt/'.$row->id.'/'.$row->date_paid.'" id="downloadpaymentreceipt" alt="Download the Payment Receipt" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-download"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $userorders;
        }
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
