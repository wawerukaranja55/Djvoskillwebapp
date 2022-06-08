<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\User;
use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $events=Events::latest()->take(4)->get();
        dd($events);die();
        return view('auth.login',compact('events'));
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // update user cart with user_id
        if(!empty(Session::get('session_id')))
        {
            $user_id=Auth::user()->id;
            $session_id=Session::get('session_id');
            Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
        }

        redirect($request['current_page']);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($request['current_page']);
       
    }
}
