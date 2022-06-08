<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;

class ContactUs_Controller extends Controller
{
    // Create Contact Form
    public function create (Request $request) {
        return view('frontend.contact');
      }
  
      // Store Contact Form data
    public function storeEmail(Request $request) {
  
          // Form validation
          $this->validate($request, [
              'name' => 'required',
              'email' => 'required|email',
              'message' => 'required'
           ]);
  
          //  Store data in database
          Contact::create($request->all());

          //  Send mail to admin
          Mail::send('mymails\voskillmail', array(

            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'user_query' => $request->get('message'),
            
            ), function($message) use ($request){
                $message->from($request->email);
                $message->to('voskilltheentertainer@gmail.com', 'Admin');
        });
  
          // 
          return back()->with('session', 'Your Message Has Been Received');

        //   Mail::to('voskilltheentertainer@gmail.com')->send(new ContactMail($details));
        // return back()->with('message-sent','Your Message has been Successfully Sent');
      }
}
