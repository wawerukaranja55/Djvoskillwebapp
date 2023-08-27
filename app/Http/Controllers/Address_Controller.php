<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Deliveryaddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class Address_Controller extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();

        $rules=[
            'first_name'=>'min:2|max:10',
            'last_name'=>'min:2|max:10',
            'phone'=>'regex:/(07)[0-9]/|digits:10',
            'countyname'=>'required',
            'cityname'=>'required'
        ];

        $custommessages=[
            'first_name.min:2'=>'Your First Name Should Not Be Below 2 Letters',
            'first_name.max:10'=>'Your First Name Should Not Be Above 10 Letters',
            'last_name.min:2'=>'Your Last Name Should Not Be Below 2 Letters',
            'last_name.max:10'=>'Your Last Name Should Not Be Above 10 Letters',
            'phone.regex'=>'Your Phone Number Should start with 07',
            'phone.digits:10'=>'The Phone Number Should not be less or more than 10 digits',
            'countyname.required'=>'Kindly Select Your County',
            'cityname.required'=>'Kindly Select Your Town',
        ];

        $validator = Validator::make( $data,$rules,$custommessages );
        
        if($validator->fails())
        {
            return response()->json([
                'status'=>415,
                'message'=>$validator->errors()
            ]);

        } else {
            $usercount=User::where('email',$data['email'])->count();
            if($usercount>0){
                $message="The Account Already Exists for Another User";
                return response()->json(['status'=>400,
                                        'message'=>$message]);
            }else{
                
                $user=new User;
                $user->first_name=$data['first_name'];
                $user->last_name=$data['last_name'];
                $user->email=$data['email'];
                $user->phone=$data['phone'];
                $user->status=1;
                $user->password=bcrypt($data['password']);
                $user->save();

                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']]))
                {

                }

                // update cart when a user creates an account
                if(!empty(Session::get('session_id')))
                {
                    $user_id=$user->id;
                    $session_id=Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }

                if ( empty($data['company_name']) ) 
                { 
                    $companyname = NULL;
                } else {
                    $companyname = $data['company_name'];
                }

                $user_id=$user->id;
                //$user_id=DB::getPdo()->lastInsertId();

                $address=new Deliveryaddress();
                $address->user_id=$user_id;
                $address->company_name=$companyname;
                $address->county_id=$request->countyname;
                $address->city_id=$request->cityname;
                $address->pickuppoint=$request->street_address;
                $address->shipping_cost=$request->shipping_amount;
                $address->save();

                $useraddress=Deliveryaddress::with(['shipcharges','towns'])->where('user_id',$user_id)->first();


                $message="Billing and Shipping details added Successfully!";
                return response()->json([
                    'useraddress'=>$useraddress,
                    'status'=>200,
                    'message'=>$message
                ]);
            }
        }
    }

}
