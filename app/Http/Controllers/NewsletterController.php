<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use App\Http\Controllers\Controller;
use App\Models\Subscriber;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email'=>'required|email|unique:subscribers'
        ]);

        $subscriber=new Subscriber();
        $subscriber->email=$request->email;
        $subscriber->save();

        if ( ! Newsletter::issubscribed($request->email) ) {
            Newsletter::subscribe($request->email);
            return redirect()->back()->with('success', 'Thanks For Subscribing');
        }
        return redirect()->back()->with('error', 'Sorry! You have already subscribed ');
    }
        
   
}
