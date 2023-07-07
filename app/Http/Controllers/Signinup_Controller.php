<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Events;
use App\Models\SMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Signinup_Controller extends Controller
{

    public function register () {
        $events=Events::latest()->take(4)->get();
        return view('frontend.register',compact('events'));
    }

    public function login () {
        $events=Events::latest()->take(4)->get();
        return view('frontend.login',compact('events'));
    }

    public function signup(Request $request){
        if($request->ismethod('post')){
            $data=$request->all();

            Session::forget('error_message');
            Session::forget('success_message');
            $usercount=User::where('email',$data['email'])->count();
            if($usercount>0){
                $message="The Email Already Exists for Another User";
                Session::flash('error_message',$message);
                return redirect()->back();
            }else{
                $user=new User;
                $user->first_name=$data['first_name'];
                $user->last_name=$data['last_name'];
                $user->email=$data['email'];
                $user->phone=$data['phone'];
                $user->status=1;
                $user->password=bcrypt($data['password']);
                $user->save();

                // update cart when a user creates an account
                if(!empty(Session::get('session_id')))
                {
                    $user_id=$user->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]))
                {

                    $message="You have successfully Created a New Account";
                    Session::flash('success_message',$message);
                    return redirect()->back();
                }

                    // send activation email upon account sign up
                // $email=$data['email'];
                // $messagedata=[
                //     'email'=>$data['email'],
                //     'code'=>base64_encode($data['email']),
                //     'name'=>$data['name']
                // ];

                // Mail::send('emails.accountactivation', $messagedata, function ($message) use($email) {
                //     $message->to($email)->subject('Confirm Your Email to Activate Your Account');
                // });

                // $message="Please Confirm your email to activate your account";
                // Session::put('success_message',$message);
                // return redirect()->back();

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]))
                {
                    //update the status of a user to active
                    User::where('email',$data['email'])->update(['status'=>1]);

                    $message="You have successfully Created a New Account";
                    Session::flash('success_message',$message);
                    return redirect()->back();
                }

                    

                    // Send success activation via sms to the user
                // $message="Dear User thanks for registering.Kindly check your email to activate your account.";
                // $mobile=$data['phone'];
                // SMS::sendsms($message,$mobile);

                // send email to the new user upon registeration
                // $email=$data['email'];
                // $messagedata=['email'=>$data['email'],'phone'=>$data['phone'],'name'=>$data['name']];

                // Mail::send('emails.register', $messagedata, function ($message) use($email) {
                //     $message->to($email)->subject('Welcome To Dj Voskill Website');
                // });
            }
            
        }
    }

    // we are not using this function for now its for activating an account
    // public function confirmaccount($email){
    //     Session::forget('error_message');
    //     Session::forget('success_message');

    //     $email=base64_decode($email);

    //     // dd($email);die();

    //     $usercount=User::where('email',$email)->count();
    //     if($usercount>0){
    //         $userdetails=User::where('email',$email)->first();
    //         if($userdetails->status==1)
    //         {
    //             $message="Your Email is Already Acivated.You Can login to your Account";
    //             Session::put('error_message',$message);
    //             return redirect('/loginuser');
    //         }else{
    //                 // update the status of a user to active
    //             User::where('email',$email)->update(['status'=>1]);

    //                 // Send success activation via sms to the user
    //             // $message="Dear User you have successfully activated your account.Login To Your Account";
    //             // $mobile=$userdetails['phone'];
    //             // SMS::sendsms($message,$mobile);

    //                 // Send success activation via email to the user
    //             $messagedata=['email'=>$userdetails['email'],'phone'=>$userdetails['phone'],'name'=>$userdetails['name']];

    //             Mail::send('emails.register', $messagedata, function ($message) use($email) {
    //                 $message->to($email)->subject('Welcome To Dj Voskill Website');
    //             });

    //             $message="Your Account has been successfully activated";
    //                 Session::flash('success_message',$message);
    //                 return redirect('/loginuser');
    //         }
    //     }
    // }

    public function forgotpassword(Request $request)
    {
        if($request->ismethod('post'))
        {
            $data=$request->all();

            $emailcount=User::where('email',$data['email'])->count();

            if($emailcount==0)
            {
                $message="Email doesnt Exists";
                Session::put('error_message',$message);
                Session::forget('success_message');
                return redirect()->back();
            }

            $random_password=str_random(8);
            $new_password=bcrypt($random_password);

            User::where('email',$data['email'])->update(['password'=>$new_password]);
            $username=User::select('name')->where('email',$data['email'])->first();

            $email=$data['email'];
            $name=$username->name;
            $messagedata=['email'=>$email,'name'=>$name,'password'=>$random_password];

            Mail::send('emails.forgotpass', $messagedata, function ($message) use($email) {
                $message->to($email)->subject('New Password for your Account');
            });

            $message="Please check your email for new password";
            Session::put('success_message',$message);
            Session::forget('error_message');
            return redirect('/loginuser');
        }

        return view('front.forgotpassword');
    }

    public function signin(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data=$request->all();
            Session::forget('error_message');
            Session::forget('success_message');
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]))
            {
                // check whether a user has activated his account when he tries to login
                // $userstatus=User::where('email',$data['email'])->first();
                // if($userstatus->status==0)
                // {
                //     Auth::logout();
                //     $message="Your Account is not yet Activated.please check your email to activate it";

                //     Session::put('error_message',$message);
                //     return redirect()->back();
                // }

                // update cart status from 0 to user id upon login
                if(!empty(Session::get('session_id'))){
                    $user_id=Auth::user()->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);

                }

                $message="You have successfully Logged in to Your Account";
                Session::flash('success_message',$message);
                return redirect()->back();
            }else{
                $message="Invalid Email or Password";
                Session::flash('error_message',$message);
                return redirect()->back();
            }

        }
    }

    public function check_email(Request $request)
    {
        $data=$request->all();
        $emailcount=User::where('email',$data['email'])->count();

        if($emailcount>0){
            return "false";
        }else{
            return "true";
        }

    }

    public function signout(Request $request)
    {
        Auth::logout();
        return redirect()->back();
    }
}
