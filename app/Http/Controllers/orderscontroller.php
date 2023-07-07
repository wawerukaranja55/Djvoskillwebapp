<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Picked_order;
use App\Models\Shipping_Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class orderscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_orders()
    {
        // show all orders placed and their status
        //$ordersplaced=Order::with('orders_products')->where('user_id',Auth::user()->id)->orderby('id','Desc')->get();
        // dd($ordersplaced);die();
        return view('backend.merchadise.new_orders');
    }

    public function intransit_orders()
    {
        // show all orders placed and their status
        //$ordersplaced=Order::with('orders_products')->where('user_id',Auth::user()->id)->orderby('id','Desc')->get();
        // dd($ordersplaced);die();
        return view('backend.merchadise.orders_intransit');
    }

    public function delivered_orders()
    {
        // show all orders placed and their status
        //$ordersplaced=Order::with('orders_products')->where('user_id',Auth::user()->id)->orderby('id','Desc')->get();
        // dd($ordersplaced);die();
        return view('backend.merchadise.delivered_orders');
    }

    public function picked_orders()
    {
        // show all orders placed and their status
        //$ordersplaced=Order::with('orders_products')->where('user_id',Auth::user()->id)->orderby('id','Desc')->get();
        // dd($ordersplaced);die();
        return view('backend.merchadise.allorders');
    }

    // show all new orders for users
    public function neworders(Request $request)
    {
        $allorders=Order::select('id','tracking_id','town','payment_method','order_status','phone')->where('order_status',"Paid");

        if($request->ajax()){
            $allorders = DataTables::of ($allorders)
            ->addColumn ('action',function($row){
                return 
                '<button type="button" value="'.$row->id.'" class="class="btn btn-primary btn-block" id="orderstatus">Update Order Status</button>
                    <a href="/admin/viewpayment/'.$row->id.'/'.$row->date_paid.'" target="_blank" alt="View the Payment Receipt" class="btn btn-success viewpaymentreciept" data-id="'.$row->id.'"><i class="fa fa-eye"></i></a>
                    <a href="/downloadpaymentreceipt/'.$row->id.'/'.$row->date_paid.'" id="downloadorder" alt="Download Receipt For Customer" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-download"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $allorders;
        }
    }

    //update order status for a user to Intransit
    public function user_order($id)
    {
        $orderdata=Order::with('shipping_vehicle')->select('id','first_name','last_name','tracking_id')->find($id);
        
        if($orderdata)
        {
            return response()->json([
                'status'=>200,
                'orderdata'=>$orderdata
            ]);
        }
    }

    public function update_order(Request $request)
    {
        $data=$request->all();

        $order=Order::find($request->order_status_id);
        $order->order_status=$data['orderstatus'];
        $order->save();

        if($request->vehicle_reg_no !== null)
        {
            $shipping_vehicle=new Shipping_Vehicle();
            $shipping_vehicle->vehicle_reg_no=$request->vehicle_reg_no;
            $shipping_vehicle->vehicle_driver=$request->vehicle_driver;
            $shipping_vehicle->order_id=$request->order_status_id;
            $shipping_vehicle->save();
        }

        $message="Order Updated Successfully";
        return response()->json([
            'status'=>200,
            'message'=>$message
        ]);
    }

    public function update_order_vehicle_reg(Request $request)
    {
        $shipping_vehicle=new Shipping_Vehicle();
        $shipping_vehicle->vehicle_reg_no=$request->vehicle_reg_no;
        $shipping_vehicle->vehicle_driver=$request->vehicle_driver;
        $shipping_vehicle->order_id=$request->order_status_id;
        $shipping_vehicle->vehicle_change_info=$request->vehicle_change_info;
        $shipping_vehicle->save();

        $message="Order Updated to Another Driver/Vehicle Successfully";
        return response()->json([
            'status'=>200,
            'message'=>$message
        ]);
    }

    // show all orders intransit for users
    public function intransitorders(Request $request)
    {
        $allorders=Order::select('id','tracking_id','town','order_status','phone')->where('order_status',"In_Transit");

        if($request->ajax()){
            $allorders = DataTables::of ($allorders)
            ->addColumn ('action',function($row){
                return 
                '<button type="button" value="'.$row->id.'" class="btn btn-dark actionbtn" id="changedrivervehicle"><i class="fa fa-edit">
                    </i><span class="tooltip">Change Driver/Vehicle</span></button>
                <button type="button" value="'.$row->id.'" class="class="btn btn-primary" id="orderintransit">Update Order Status</button>
                    <a href="/admin/viewpayment/'.$row->id.'/'.$row->date_paid.'" target="_blank" alt="View the Payment Receipt" class="btn btn-success viewpaymentreciept" data-id="'.$row->id.'"><i class="fa fa-eye"></i></a>
                    <a href="/downloadpaymentreceipt/'.$row->id.'/'.$row->date_paid.'" id="downloadorder" alt="Download Receipt For Customer" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-download"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $allorders;
        }
    }

    // show all orders that has been delivered for users
    public function deliveredorders(Request $request)
    {
        $allorders=Order::select('id','tracking_id','town','order_status','phone')->where('order_status',"Delivered");

        if($request->ajax()){
            $allorders = DataTables::of ($allorders)
            ->addColumn ('action',function($row){
                return 
                '<button type="button" value="'.$row->id.'" class="class="btn btn-primary btn-block" id="orderdelivered">Update Order Status</button>
                    <a href="/admin/viewpayment/'.$row->id.'/'.$row->date_paid.'" target="_blank" alt="View the Payment Receipt" class="btn btn-success viewpaymentreciept" data-id="'.$row->id.'"><i class="fa fa-eye"></i></a>
                    <a href="/downloadpaymentreceipt/'.$row->id.'/'.$row->date_paid.'" id="downloadorder" alt="Download Receipt For Customer" class="btn btn-danger" data-id="'.$row->id.'"><i class="fa fa-download"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);

            return $allorders;
        }
    }

    //update the order to pick 
    public function update_order_to_picking(Request $request)
    {
        $order=Order::find($request->picked_status_id);
        $order->order_status=$request->orderstatus;
        $order->save();

        $picked_order=new Picked_order();
        $picked_order->order_id=$request->picked_status_id;
        $picked_order->recipient_id_number=$request->recipient_id_number;
        $picked_order->recipient_phone=$request->recipient_phone;
        $picked_order->recipient_firstname=$request->recipient_firstname;
        $picked_order->recipient_lastname=$request->recipient_lastname;
        $picked_order->save();

        $message="Order Given to The Recipient";
        return response()->json([
            'status'=>200,
            'message'=>$message
        ]);
    }
}
