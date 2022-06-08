<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $role=auth()->user()->is_admin;
        if($request->wantsJson()){
            return response()->json(['two factor'=>false]);
        }

        // switch($role){
        //     case'0';
        //         return redirect($request['current_page'])->intended(config('fortify.home'));
                
        //         break;

        //     case'1';
        //         return redirect($request['current_page'])->route('dashboard.index');
        //         break;
            // default;
            //     return redirect('/');
        // }
    }
}
