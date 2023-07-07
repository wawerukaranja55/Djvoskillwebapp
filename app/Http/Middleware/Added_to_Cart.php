<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Added_to_Cart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // check if the session_id is empty in the cart
        $session_id=Session::get('session_id');

        //dd($session_id);die();
        //$user_id=Auth::user()->id;
        $session_idincart=Cart::where('session_id',$session_id)->first();
        // $user_idincart=Cart::where('user_id',$user_id)->first();

        if( empty($session_idincart))
        {
            return abort(403);
        }
            
        return $next($request);
    }
}
