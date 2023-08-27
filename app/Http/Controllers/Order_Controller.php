<?php

namespace App\Http\Controllers;

use Stripe;
use Charge;
use App\Models\Cart;
use App\Models\Merchadise;
use App\Models\User;
use App\Models\Order;
use App\Models\Mpesa_Payment;
use App\Models\Paypal_payment;
use App\Models\Ordersproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Order_Controller extends Controller
{
    public function place_order(Request $request){
        $data=$request->all();
        
        //coupon_code
        if ( empty($data['coupon_discount_code']) ) 
        { 
            $coupon_discount_code = NULL;
        } else {
            $coupon_discount_code = $data['coupon_discount_code'];
        }

        //coupon_amount
        if ( empty($data['coupon_amount']) ) 
        { 
            $coupon_amount = NULL;
        } else {
            $coupon_amount = $data['coupon_amount'];
        }


        // Get the last order id
        $lastorderId = Order::orderBy('id', 'desc')->first()->id ?? 1;

        // Get last 3 digits of last order id
        $lastIncreament = substr($lastorderId, -3);

        // Make a new order id with appending last increment + 1
        $newreceiptId = 'wKShoppingMall' . $data['orderuserid'] . str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);

        $user_order=User::select('first_name','last_name','email','phone')->where('id',$data['orderuserid'])->first();

        $order=new Order();
        $order->first_name=$user_order->first_name;
        $order->last_name=$user_order->last_name;
        $order->phone=$user_order->phone;
        $order->email=$user_order->email;
        $order->county=$data['county_order'];
        $order->town=$data['town_order'];
        $order->tracking_id=$newreceiptId;
        $order->coupon_code=$coupon_discount_code;
        $order->order_status="Unpaid";
        $order->payment_method=$data['payment_method'];
        $order->user_id=$data['orderuserid'];
        $order->grand_total=$data['grand_amount'];
        $order->shipping_charges=$data['shipping_amount'];
        $order->coupon_amount=$coupon_amount;
        $order->save();

        // update cart with the order id for the products added
        $session_id=Session::get('session_id');
        if(empty($session_id)){
            $session_id=Session::getId();
            Session::put('session_id',$session_id);
        }

        //save products for that placed order
        $cartitems=Cart::where('user_id',$data['orderuserid'])->get();

        foreach($cartitems as $key=>$item)
        {
            $cartitem =new Ordersproduct;
            $cartitem->order_id=$order->id;
            $cartitem->user_id=$data['orderuserid'];
            $getproductdetails=Merchadise::select('merch_name')->where('id',$item['product_id'])->first();
            if($item['size']=="small")
            {
                $product_size=null;
            }else{
                $product_size=$item['size'];
            }
            $cartitem->product_id=$item['product_id'];
            $cartitem->product_size=$product_size;
            $cartitem->product_name=$getproductdetails->merch_name;
            //$cartitem->product_code=$getproductdetails->merch_code;
            $cartitem->product_quantity=$item['quantity'];
            $cartitem->product_price=$item['product_price'];
            $cartitem->save();
        }

        Cart::where('user_id',$data['orderuserid'])->update(['order_id'=>$order->id,'is_order'=>"order_placed"]);

        $payment_mode=$order->payment_method;

        $message="Your Order Has Been Placed.Kindly Pay For It to Complete and be Shipped";
        return response()->json([
            'orderdetails'=>$order,
            'payment_mode'=>$payment_mode,
            'status'=>200,
            'message'=>$message
        ]);

    }

    public function mpesa_confirmation(Request $request)
    {
        $user_auth_id=Auth::user()->id;
        $mpesa_transaction_code=$request->input('mpesa_transaction_code');
        
        $details_to_use=Order::where(['user_id'=>$user_auth_id,'order_status'=>"Unpaid",'payment_method'=>"MPESA"])->select('id','phone','grand_total')->get();


        $user_mpesa_number = $details_to_use[0]['phone'];

        $user_order_id = $details_to_use[0]['id'];

        $user_grand_total = $details_to_use[0]['grand_total'];

        //$user_paid_amount=Mpesa_Payment::where(['phone'=>$user_mpesa_number,'is_confirmed'=>"not_yet",'mpesatransaction_id'=>$mpesa_transaction_code])->pluck('amount');

        $user_total_amount=Mpesa_Payment::where(['phone'=>$user_mpesa_number,'is_confirmed'=>"not_yet"])->sum('amount');

        $user_mpesa_payment = Mpesa_Payment::where('mpesatransaction_id',$mpesa_transaction_code)->count();

        //first check whther the transaction exist ````
        //if it exist check if the user paid the whole amount
        //if the user havent paid the whole amount redirectback with and tell them to pay the remaining amount
        //if the user paid the whole amount redirect with a success and download receipt page with pdf also send an email to them with a receipt download
        
        if($user_mpesa_payment>0)
        {
            if($user_total_amount !== 0 && $user_total_amount == $user_grand_total)
            {
                //empty cart upon payment
                Cart::where(['user_id'=>$user_auth_id])->delete();

                //update order status to paid
                Order::where(['user_id'=>$user_auth_id,'order_status'=>"Unpaid",'payment_method'=>"MPESA"])->update(['order_status'=>'Paid']);

                //update mpesa payment to confirmed
                Mpesa_Payment::where(['phone'=>$user_mpesa_number,'is_confirmed'=>"not_yet"])->update(['is_confirmed'=>"Confirmed"]);

                return response()->json([
                    'userid'=>$user_auth_id,
                    'status'=>200,
                    'message'=>"Your Mpesa Payment for the order " .$user_order_id. " has been received.Kindly check your email and account to see the order progress",
                ]);

                
            } elseif($user_total_amount !== 0 && $user_total_amount < $user_grand_total)
            {
                $amount_due=$user_grand_total-$user_total_amount;

                return response()->json([
                    'status'=>500,
                    'message'=>"Please Pay " .$amount_due. " to fully pay the Order"
                ]);
            } else
            {
                return response()->json([

                    'status'=>450,
                    'message'=>"The Transaction Code for the Payment has already been used for an order that is Complete."
                ]);
            }

        } else {

            return response()->json([
                'status'=>415,
                'message'=>"The Confirmtion Code you have entered does not exist.Please check again on your phone and enter it in the input box."
            ]);
            
        }
    }

    public function post_paypal(Request $request)
    {
        //$user_id=$request->input('order_id');
        $paypal=new Paypal_payment;
        $paypal->amount=$request->input('amount');
        $paypal->paypal_payment_id=$request->input('paypal_payment_id');
        $paypal->email=$request->input('email');
        $paypal->order_id=$request->input('order_id');
        $paypal->paypal_payment_status=$request->input('paypal_payment_status');
        $paypal->save();

        if($request->input('paypal_payment_status')=="COMPLETED")
        {
            Order::where(['id'=>$request->input('order_id')])->update(['order_status'=>'Paid']);

            Cart::where(['order_id'=>$request->input('order_id')])->delete();

            return response()->json([
                'status'=>200,
                'id'=>Auth::user()->id,
                'message'=>"Your Paypal Payment for the order " .$request->input('order_id'). " has been received.Kindly check your email and account to see the order progress",
            ]);
        } else {

            return response()->json([
                'status'=>500,
                'message'=>"Please Pay the Remaining Amount to Complete The transaction",
            ]);
        }
    }

    public function stripepayment(Request $request)
    {
        try
        {
            // $stripe = new \Stripe\StripeClient(
            //     env('STRIPE_SECRET')
            // );
            // $res=$stripe->tokens->create([
            //     'card'=>[
            //         'number' => $request->card_number,
            //         'exp_month' => $request->expiry_month,
            //         'exp_year' => $request->expiry_year,
            //         'cvc' => $request->cvc,

            //     ]
            // ]);

            // Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            // $response=$stripe->charges->create([
            //     'amount'=>$request->stripe_amount * 100,
            //     'currency'=>'usd',
            //     'source' => $token,
            //     'description'=>$request->stripe_description,
            // ]);

            // Set your Stripe secret key
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Use the test token directly
            $token = 'tok_visa';

            // Create a charge
            $response = Stripe\Charge::create([
                'amount' => $request->stripe_amount * 100, // amount in cents
                'currency' => 'usd',
                'source' => $token,
                'description' => $request->stripe_description,
            ]);

            $userid=Order::where(['id'=>$request->input('stripe_orderid')])->select('user_id')->first();

            Order::where(['id'=>$request->input('stripe_orderid')])->update(['order_status'=>'Paid']);

            Cart::where(['order_id'=>$request->input('stripe_orderid')])->delete();

            return response()->json([
                'status'=>201,
                'id'=>$userid,
                'message'=>"Your Stripe Payment for the order " .$request->input('order_id'). " has been received.Kindly check your email and account to see the order progress",
            ]);
        }
        catch(Exception $ex)
        {
            return response()->json([$response->status],500);
        }
        // try
        // {
        //     $stripe = new \Stripe\StripeClient(
        //         env('STRIPE_SECRET')
        //     );
        //     $res=$stripe->tokens->create([
        //         'card'=>[
        //             'number' => $request->card_number,
        //             'exp_month' => $request->expiry_month,
        //             'exp_year' => $request->expiry_year,
        //             'cvc' => $request->cvc,

        //         ]
        //     ]);

        //     Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        //     $response=$stripe->charges->create([
        //         'amount'=>$request->stripe_amount,
        //         'currency'=>'usd',
        //         'card'=>$res->id,
        //         'description'=>$request->stripe_description,
        //     ]);

        //     return response()->json([$response->status],201);
        // }
        // catch(Exception $ex)
        // {
        //     return response()->json([$response->status],500);
        // }

    }
}
