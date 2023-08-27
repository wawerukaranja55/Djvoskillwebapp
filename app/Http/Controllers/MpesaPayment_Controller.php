<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaPayment_Controller extends Controller
{
    public function allmpesapayments()
    {

        return view('backend.merchadise.mpesapayments');
    }

    public function getAccessToken()
    {
        $url=env('MPESA_ENVRONMENT') == 0 
        ? 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials' 
        : 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl=curl_init($url);
        curl_setopt_array( $curl,
            array(
                CURLOPT_HTTPHEADER => ['Content-Type:application/json; charset=utf8'],
                CURLOPT_RETURNTRANSFER =>true,
                CURLOPT_HEADER => false,
                CURLOPT_USERPWD => env('MPESA_CONSUMER_KEY'). ':' .env('MPESA_CONSUMER_SECRET')
            )
        );

        $res=curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    public function registerURLs()
    {
        $body=array(
            'ShortCode'=>env('MPESA_SHORT_CODE'),
            'ResponseType'=>'Completed',
            'ConfirmationURL'=>'https://42f6-154-159-237-105.ngrok-free.app/api/c2b/confirm',
            'ValidationURL'=>'https://42f6-154-159-237-105.ngrok-free.app/api/c2b/validate',
        );

        $url=env('MPESA_ENVRONMENT') == 0 
        ? 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl' 
        : 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';

        $response=$this->makeHttp($url,$body);

        return $response;
    }

    public function makeHttp($url,$body)
    {
        $curl=curl_init();
        curl_setopt_array( 
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array('Content-Type:application/json','Authorization:Bearer '.$this->getAccessToken()),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body)
            )
        );

        $curl_res=curl_exec($curl);

        dd($curl_res);die();
        curl_close($curl);

        Log::info($curl_res);
        return $curl_res;
    }
}
