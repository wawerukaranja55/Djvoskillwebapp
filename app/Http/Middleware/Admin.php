<?php

namespace App\Http\Middleware;

use Closure;
use session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next )
    {
        if( Auth::check() &&  Auth::User()->is_admin == 1 ){
            return $next($request);
            }
        else
            return abort(403);
            // return redirect('/')->with('error', 'You are not authorised');
    }

    
}
