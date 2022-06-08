<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\mpesapayment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\mpesatransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MpesatransactionController extends Controller
{
    // generate lipa na mpesa password
    public function lipanampesapassword()
    {
        $timestamp=Carbon::rawParse('now')->format('YmdHms');

        $passkey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";

        $businessshortcode=174379;

        $mpesapassword=base64_encode($businessshortcode.$passkey.$timestamp);

        return $mpesapassword;
    }

    // generate access token for the transaction
    public function newaccesstoken()
    {
        $consumer_key="VyEprVwd9G3GGNdAzDXAq8U8NMleEAh9";

        $consumer_secret="VS9qdwbLNAQnGGtI";

        $credentials=base64_encode($consumer_key.":".$consumer_secret);

        $url="https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array("Authorization:Basic ".$credentials,
                                                    "Content-Type:application/json"));
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $curl_response=curl_exec($curl);
        $access_token=json_decode($curl_response);

        curl_close($curl);
        
        return $access_token->access_token;
    }

    // push stk on the phone
    public function stkpush(Request $request)
    {
        $request->validate([
            'phone'=>'required','regex:/^(\\+?254|0)(7|1)([0-9{8})$/',    
        ]);


        // $user=$request->user;
        $phone=$request->phone_number;
        $getamount=$request->total_amount;
        $amount=round($getamount);

        $formattednumber=Substr($phone,1);
        $code="254";
        $phonenumber=$code.$formattednumber;

        // $user=auth()->phone;
        // $user->phone=$phone;
        // $user->save();

        $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl_post_data=[
            'BusinessShortCode'=>174379,
            'Password'=>$this->lipanampesapassword(),
            'Timestamp'=>Carbon::rawParse('now')->format('YmdHms'),

            'TransactionType'=> "CustomerPayBillOnline",
            'Amount'=>$amount,
            'PartyA'=>$phonenumber,
            'PartyB'=>174379,
            'PhoneNumber'=>$phonenumber,
            'CallBackURL'=>'https://webhook.site/79d3db8d-a405-44a0-b6ec-29dabf96ab84',
            'AccountReference'=>'Waweru Karanja Sounds',
            'TransactionDesc'=>'Paying for Products Bought'
        ];

        $data_string=json_encode($curl_post_data);

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type:application/json','Authorization:Bearer '.$this->newaccesstoken()));
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data_string);

        $curl_response=curl_exec($curl);
        return $curl_response;
        // return redirect('/mpesa/confirm');
    }

    // call back url
    public function mpesaresponse(Request $request)
    {
        // $response="send to db";
        $response=json_decode($request->getContent());
        Log::info(json_encode($response));

        $responsedata=$response->Body->stkCallback->CallbackMetadata;
        $responsecode=$response->Body->stkCallback->ResultCode;
        $responsemessage=$response->Body->stkCallback->ResultDesc;

        // return response()->json($responsedata->Item[4]->Value);

        $amountpaid=$responsedata->Item[0]->Value;
        $mpesatransactionid=$responsedata->Item[1]->Value;
        $paymentphonenumber=$responsedata->Item[4]->Value;

        $formattedphonenumber=str_replace("254","0",$paymentphonenumber);

        $payment=new mpesapayment;
        $payment->amount=$amountpaid;
        $payment->mpesatransaction_id=$mpesatransactionid;
        $payment->phone=$formattedphonenumber;
        // $payment->customer_name=$formattedphonenumber;
        $payment->save();

    }

    // check if the transaction exists
    public function confirm_transaction(Request $request)
    {
        $mpesa_id=$request->input('transaction_id');

        // $phone=$request->input('phone');

        $mpesa_id_check=mpesapayment::where('mpesatransaction_id',$mpesa_id)->first();

        if(mpesapayment::where('mpesatransaction_id',$mpesa_id)->exists())
        {
            return redirect('payment/success');
        }
        elseif($mpesa_id_check==null){
            return redirect()->back()->with('success','The Transaction ID is incorrect.Kindly Check Again');
        }
    }
}
