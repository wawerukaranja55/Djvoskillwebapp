<?php

namespace App\Http\Controllers;
// use session;
use App\Models\Cart;
use App\Models\Town;
use App\Models\Order;
use App\Models\coupon;
use App\Models\Events;
use App\Models\Blogtag;
use App\Models\Blogpost;
use App\Models\Merchadise;
use App\Models\Blogcategory;
use App\Models\Commentreply;
use App\Models\Mixxes_Model;
use App\Models\mpesapayment;
use App\Models\Postcomments;
use Illuminate\Http\Request;
use App\Models\Ordersproduct;
use App\Models\Productimages;
use App\Models\Deliveryaddress;
use App\Models\payment_methods;
use App\Models\shipping_charge;
use App\Models\Productattribute;
use App\Models\Merchadisecategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


class Home_Controller extends Controller
{
    public function homepage () {
        $events=Events::latest()->take(4)->get();
        $blog=Blogpost::latest()->take(4)->get();
        $merchad=Merchadise::latest()->take(4)->get();
        $mixxes=Mixxes_Model::latest()->paginate(5);
        return view('frontend.index',compact('mixxes','merchad','events','blog'));
    }

    public function audiomixtapes () {
        $events=Events::latest()->take(4)->get();
        $mixxes=Mixxes_Model::latest()->paginate(5);
        return view('frontend.mixtapes.audiomixtapes',compact('mixxes','events'));
    }

    public function download ($mix_audio)
    {   
        $mix = new Mixxes_Model;
        $filePath = public_path('mixtapes\\'.$mix_audio);
        return response()->file($filePath );
    }

    public function blog (){
        $events=Events::latest()->take(4)->get();
        $cats=Blogcategory::all();
        $recent_posts= Blogpost::latest()->limit(5)->get();
        $posttags=Blogtag::all();
        $posts=Blogpost::orderby('id','asec')->paginate(4);
        
        return view('frontend.blogs.blogs',['events'=>$events,'cats'=>$cats,'posts'=>$posts,'recent_posts'=>$recent_posts,'posttags'=>$posttags]);
    }

    public function events (){
        
        $events=Events::orderby('id','desc')->paginate(4);
        return view('frontend.events',['events'=>$events]);
    }
   
    public function merchadise ($url,Request $request){
        if($request->ajax()){

            $data=$request->all();
            // echo "<pre>";print_r($data);die();
            // drop down select
            $sort=$request->sort;
            $url=$request->url;

            $categorycount=Merchadisecategory::where(['url'=>$url,'status'=>1])->count();
            if($categorycount>0){
                $categorydetails=Merchadisecategory::categorydetails($url);

                $categoryproducts=Merchadise::whereIn('merchcat_id',$categorydetails['catids'])->with('merchadiseattributes')
                ->where('merch_isactive',1);

                    // show products on pushing a slider
                if(isset($data['start']) && !empty($data['start'])){
                    $categoryproducts->where('merch_price','>=',$request->start)->where('merch_price','<=', $request->end);     
                }
                
                    // check the filtering value is selected
                if(isset($data['fabric']) && !empty($data['fabric'])){
                    $categoryproducts->whereIn('merchadises.fabric',$data['fabric']);
                    
                }
                    // check the sorting value is selected
                if(isset($sort) && !empty($sort)){

                    if($sort=="latest_products"){

                        $categoryproducts->orderBy('id','Desc');
                    }
                    elseif($sort=="low_to_high"){
                        $categoryproducts->orderBy('merch_price','Asc');
                    }
                    elseif($sort=="high_to_low"){
                        $categoryproducts->orderBy('merch_price','Desc');
                    }
                    elseif($sort=="most_popular"){
                        $categoryproducts->orderBy('product_views','Desc');
                    }
                    elseif($sort=="product_name_a_z"){
                        $categoryproducts->orderBy('merch_name','Asc');
                    }
                    elseif($sort=="product_name_z_a"){
                        $categoryproducts->orderBy('merch_name','Desc');
                    }
                }else{
                    $categoryproducts->orderBy('id','Desc');
                }
                
                $productscategory=$categoryproducts->paginate(4);

                $events=Events::latest()->take(4)->get();
                
                return view('frontend.product.productsjson',compact('events','url','productscategory'));
                
            }else{
                abort (404);
            }
        }else{

            // $url=Route::current()->uri();
            $categorycount=Merchadisecategory::where(['url'=>$url,'status'=>1])->count();

            if($categorycount>0){
                $categorydetails=Merchadisecategory::categorydetails($url);

                $productscategory=Merchadise::whereIn('merchcat_id',$categorydetails['catids'])->with('merchadiseattributes')
                ->where('merch_isactive',1)->orderby('id','DESC')->paginate(9);
                $productcategories=Merchadisecategory::withCount('products')->get();
            
                $productfilters=Merchadise::productfilters();
                $fabricarray=$productfilters['fabricarray'];
                $occasionarray=$productfilters['occasionarray'];

                $events=Events::latest()->take(4)->get();
            
                return view('frontend.product.products2',compact('events','url','productscategory','fabricarray','occasionarray','productcategories'));
            }else{
                abort(404);
            }
        }
        
                    // if(isset($request->fabric)){

                    //     $fab = $request->fabric;
                    //     $explodefabric = explode(',',$fab);
                        
                    //     // $Products = DB::table('merchadises')->whereIN('fabric',$explodefabric)->get();
                    //     // return $Products;

                    //     // $getfabric=Merchadise::whereIn('fabric','like','%'.$request->fabric.'%')->get();
                    //     // $alldata = Merchadise::get();
                    //     //return $alldata;
                    //     // return $getfabric;
                    //     $categoryproducts = Merchadise::whereIn('fabric',$explodefabric)->paginate(2);

                    //    $events=Events::latest()->take(4)->get();

                    //    //return response()->json($categoryproducts);
                    //    return view('frontend.product.productsjson',compact('events','url','getfabric'));
                    // }else{

                    //     // $url=Route::current()->uri();
                    //     $categorycount=Merchadisecategory::where(['url'=>$url,'status'=>1])->count();

                    //     if($categorycount>0){
                    //         $categorydetails=Merchadisecategory::categorydetails($url);

                    //         $categoryproducts=Merchadise::whereIn('merchcat_id',$categorydetails['catids'])->with('merchadiseattributes')
                    //         ->where('merch_isactive',1)->orderby('id','DESC')->paginate(9);
                    //         $productcategories=Merchadisecategory::withCount('products')->get();
                        
                    //         $productfilters=Merchadise::productfilters();
                    //         $fabricarray=$productfilters['fabricarray'];
                    //         $occasionarray=$productfilters['occasionarray'];

                    //         $events=Events::latest()->take(4)->get();
                        
                    //         return view('frontend.product.products2',compact('events','url','categoryproducts','fabricarray','occasionarray','productcategories'));
                    //     }else{
                    //         abort(404);
                    //     }
                    // } 
    }

    public function singleproduct ($product_slug,$id){
        $singleproduct=Merchadise::find($id);
        Merchadise::find($id)->increment('product_views');
        $events=Events::latest()->take(4)->get();
        return view('frontend.product.singleproduct',compact('events','singleproduct'));
    }

    public function cart(){
        $events=Events::latest()->take(4)->get();
        $cartitems=Cart::usercartitems();

        return view('frontend.product.cart',compact('cartitems','events'));
    }

    public function addtocart(Request $request){
        
        if($request->isMethod('post')){
            $data=$request->all();

            // $getproductstock=Productattribute::where(['product_id'=>$request->product_id,'productattr_size'=>$request->productsize])->first();
            // if( $getproductstock['productattr_stock']<$request->quantity);
            // {
            //     $message="The Quantity isn't available at the moment";
            //     Session::flash('error_message',$message);
            //     return redirect()->back();
            // }

            
            $session_id=Session::get('session_id');
            if(empty($session_id)){
                $session_id=Session::getId();
                Session::put('session_id',$session_id);
            }

            // $countproducts=Cart::where([
            //     'product_id'=>$data['product_id'],
            //     'productattr_size'=>$data['productattr_size'],
            // ])->count();
            
            // if($countproducts>0){
            //     $message="The Product Already exists in the Cart";
            //     Session::flash('error_message',$message);
            //     return redirect()->back();
            // }

            if(Auth::check()){
                $user_id=Auth::user()->id;
            }else{
                $user_id=0;
            }

            $cart = new Cart();
            $cart->session_id = $session_id;
            $cart->product_id =$request->product_id;
            $cart->size = $request->productsize;
            $cart->user_id=$user_id;
            $cart->quantity = $data['quantity'];
            $cart->save();
            
            $message="The Product has been added to Cart";
                Session::flash('success_message',$message);
                return redirect('/mycart')->with('success_message','Product has been Added to cart');
        }
    }
    
    public function updatecartitem(Request $request){
        $shippingcharges=shipping_charge::where('is_shipping',1)->get();
        if($request->ajax()){
            $data=$request->all();

            
                    // get the available stock for the product that has been added for the request
            // $cartdetails=Cart::find($data['cartid']);
            // $availablestock=Productattribute::select('productattr_stock')->where
            //     (['product_id'=>$cartdetails['product_id'],'productattr_size'=>
            //     $cartdetails['productattr_size']])->first();

            // echo"<prev>";print_r($availablestock);die;

                    // check if the stock is available or not
            // if($data['quantity']>$availablestock['productattr_stock']){
            //     $usercartitems=Cart::usercartitems();
            //     return response()->json([
            //         'status'=>false,
            //         'message'=>'product stock is not available',
            //         'view'=>(string)view::make('frontend.product.cartitems')->with(compact('usercartitems'))
            //     ]);
            // }

                    // check if the product size is active or not
            // $availablesize=Productattribute::where(['product_id'=>$cartdetails['product_id'],'productattr_size'=>$cartdetails['productattr_size'],'productattr_status'=>1])->count();
            // if($availablesize==0){
            //     $usercartitems=Cart::usercartitems();
            //     return response()->json([
            //         'status'=>false,
            //         'message'=>'product size is not available',
            //         'view'=>(string)view::make('frontend.product.cartitems')->with(compact('usercartitems'))
            //     ]);
            // }
                    // increment/decrement cart quantity items
            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['quantity']]);
            $cartitems=Cart::usercartitems();
            return response()->json
                (['view'=>(string)view::make('frontend.product.cartitems')->with(compact('cartitems','shippingcharges'))
        ]);
        }
    }

    public function deletecartitem($id)
    {
        Cart::find($id)->delete();
  
        return back();
    }

    public function getproductprice(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();
            
            $getdiscountedattrprice=Merchadise::getdiscountedattrprice($data['product_id'],$data['productsize']);
            
            return  $getdiscountedattrprice;
        }
    }

    // add product to cart using jquery
    public function add_to_cart(Request $request)
    {
        // dd($request->all());die();

        $product_id=$request->input('product_id');

        $product_qty=$request->input('quantity');

        $product_attrsize=$request->productattrsize;

        $product_check=Merchadise::where('id',$product_id)->first();

        // dd($product_check);die();
        if(Cart::where('product_id',$product_id)->exists())
        {
            return response()->json(['status'=>$product_check->merch_name."Already Exist in the cart"]);
        }else{
            $session_id=Session::get('session_id');
            if(empty($session_id)){
                $session_id=Session::getId();
                Session::put('session_id',$session_id);
            }

            // dd($session_id);die();

            if(Auth::check()){
                $user_id=Auth::user()->id;
            }else{
                $user_id=0;
            }

            $newcart = new Cart();
            $newcart->session_id = $session_id;
            $newcart->product_id =$product_id;
            $newcart->size = $product_attrsize;
            $newcart->user_id=$user_id;
            $newcart->quantity = $product_qty;
            $newcart->save();

            return response()->json(['status'=>$product_check->merch_name."Added to Cart"]);
        }
    }

    public function getattrproductprice(Request $request)
    {
        if($request->ajax()){
            $data=$request->all();
            
            $getdiscountedattrprice=Merchadise::getdiscountedattrprice($data['productid'],$data['productattrsize']);
            
            return  $getdiscountedattrprice;
        }
    }

    // dynamic dropdown
    public function getshippingprice(Request $request){
        $data=Town::select('town','id')->where('county_id',$request->id)->take(150)->get();
        return response()->json($data);
    }

    // select the price based on the price
    public function displayshippingprice(Request $request){
        $shipprice=Town::select('shipping_charges','pickuppoint')->where('id',$request->id)->first();
        return response()->json($shipprice);
    }

    // apply coupon
    public function applycoupon(Request $request){
        if($request->ajax()){
            $data=$request->all();
            $couponcount=coupon::where('coupon_code',$data['code'])->count();
            if($couponcount==0){
                $cartitems=Cart::usercartitems();
                $events=Events::latest()->take(4)->get();
                return response()->json([
                    'status'=>false,
                    'message'=>'This Coupon Is Not Valid',
                    'view'=>(string)view::make('frontend.product.cartitems')->with(compact('cartitems','events'))
                ]);
            }else{
                $coupondetails=coupon::where('coupon_code',$data['code'])->first();
                if($coupondetails['status']==0){
                    $message='This Coupon Is Not Active';
                }

                $expiry_date=$coupondetails->expiry_date;
                $current_date=date('m/d/y');
                if($expiry_date<$current_date){
                    $message='This Coupon Is Exired';
                }

                $catarr=explode(",",$coupondetails->categories);
                $usercartitems=Cart::usercartitems();
                if(!empty($coupondetails->users)){
                    $usersarr=explode(",",$coupondetails->users);
                    foreach($usersarr as $user){
                        $getuserid=User::select('id')->where('email',$user)->first();
                        $userid[]=$getuserid['id'];
                    }
                }

                $total_amount=0;
                foreach($usercartitems as $item){
                    if(!in_array($item['product']['merchcat_id'],$catarr)){
                        $message="This Coupon Code Is Not For This Products";
                    }

                    if(!empty($coupondetails->users)){
                        if(!in_array($item['user_id'],$userid)){
                            $message="This Coupon Code Is Not For You";
                        }
                    }

                    $attrprice=Merchadise::getdiscountedattrprice($item['product_id'],$item['size']);
                    
                    $total_amount=$total_amount+($attrprice['final_price']*$item['quantity']);
                }

                if(isset($message)){
                    $cartitems=Cart::usercartitems();
                    $events=Events::latest()->take(4)->get();
                    return response()->json([
                        'status'=>false,
                        'message'=>$message,
                        'view'=>(string)view::make('frontend.product.cartitems')->with(compact('cartitems','events'))
                    ]);
                }else{
                    //  echo"Coupon Can Be Redeemed Successfully";die();
                
                    if($coupondetails->amount_type=="Fixed"){
                        $couponamount=$coupondetails->amount;
                    }else{
                        $couponamount=$total_amount*($coupondetails->amount/100);
                    }

                    $grand_total=$total_amount-$couponamount;
                    Session::put('couponAmount',$couponamount);
                    Session::put('couponCode',$data['code']);

                    $message="Coupon Code Applied Successfully";
                    $cartitems=Cart::usercartitems();
                    $events=Events::latest()->take(4)->get();
                    return response()->json([
                        'status'=>true,
                        'message'=>$message,
                        'couponamount'=>$couponamount,
                        'grand_total'=>$grand_total,
                        'view'=>(string)view::make('frontend.product.cartitems')->with(compact('cartitems','events'))
                    ]);
                }
            }
        }
    }

    public function checkout(){
        $events=Events::latest()->take(4)->get();
        $delivaddresses=shipping_charge::all();
        $userid=Auth::user()->id;
        $addresses=Deliveryaddress::where('user_id',$userid)->first();
        // dd($addresses);die();
        $payment_methods=payment_methods::where('status',1)->get();
        $usercartitems=Cart::usercartitems();
        
        $deliveriesdata=Deliveryaddress::deliveryaddresses();
    
        
        return view('frontend.product.checkout')->with(compact('events','payment_methods','userid','deliveriesdata','delivaddresses','addresses','usercartitems'));
    }
    
    public function addtoorder(Request $request){
        $userid=Auth::user()->id;
        $addresses=Deliveryaddress::where('user_id',$userid)->first();

        if($request->isMethod('post')){
            $data=$request->all();

            DB::beginTransaction();
            $order = new Order();
            $order->name = Auth::user()->name;
            $order->phone =$addresses->phone;
            $order->email =Auth::user()->email;
            $order->county =$addresses->shipcharges->county;
            $order->town =$addresses->towns->town;
            $order->coupon_code =Session::get('couponAmount');
            $order->order_status="New Order";
            $order->payment_method = $request->payment_method;
            $order->user_id =Auth::user()->id;
            $order->grand_total = Session::get('grand_total');
            $order->shipping_charges=$addresses->shipping_cost;
            $order->save();

            $order_id=DB::getPdo()->lastinsertid();
            
            $cartitems=Cart::where('user_id',Auth::user()->id)->get();
            
            foreach($cartitems as $item){
                $cartitem = new Ordersproduct();
                $cartitem->order_id =$order_id;
                $cartitem->user_id = Auth::user()->id;
                $cartitem->product_id = $item->product_id;
                $getproductdetails=Merchadise::select('merch_code','merch_name')->where('id',$item->product_id)->first();
                $cartitem->product_name = $getproductdetails->merch_name;
                $cartitem->product_code= $getproductdetails->merch_code;
                
                if ($item->product->is_attribute==1){
                    $getdiscountedattrprice=Merchadise::getdiscountedattrprice($item['product_id'],$item['size']);
                    $cartitem->product_price= $getdiscountedattrprice['final_price'];
                }elseif($item->product->is_attribute==0){
                    $getdiscountedprice=Merchadise::getdiscountedprice($item['product_id']);
                    $cartitem->product_price= $getdiscountedprice;
                }

                $cartitem->save();
            }
            Session::put('order_id',$order_id);
            DB::commit();
            if($request->payment_method=="MPESA"){
                return redirect()->route('mpesa');
            }elseif($request->payment_method=="PAYPAL"){
                return redirect()->route('paypal');
            }
        }            
    }

    public function paypal (){
        if(Session::has('order_id')){
            $orderdetails=Order::where('id',Session::get('order_id'))->first();
            $nameArr=explode(' ',$orderdetails['name']);
            $events=Events::orderby('id','desc')->paginate(4);
            return view('frontend.product.paypal',['orderdetails'=>$orderdetails,'events'=>$events,'nameArr'=>$nameArr]);
            
        }else{
            return redirect('mycart');
        }
        
    }

    public function mpesa (){
        $events=Events::orderby('id','desc')->paginate(4);
        return view('frontend.product.mpesa',['events'=>$events]);
    }

    public function confirm_mpesa ($id){

        $events=Events::orderby('id','desc')->paginate(4);
        $paymentid=mpesapayment::find($id);
        return view('frontend.product.mpesaconfirm',['events'=>$events,'paymentid'=>$paymentid]);
    }

    public function mpesa_success (){

        $events=Events::orderby('id','desc')->paginate(4);
        return view('frontend.product.mpesaconfirm',['events'=>$events]);
    }

    
    // success paypal
    public function paymentsuccess(){
        if(Session::has('order_id')){

            $paymentmethod=Order::pluck('payment_method')->first();

            $events=Events::orderby('id','desc')->paginate(4);
            $cartitems=Cart::where('user_id',Auth::user()->id)->get();
            
            foreach($cartitems as $item){
                $productattrstock=Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->first();
                $newstock=$productattrstock['productattr_stock']-$item['quantity'];
                Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->update(['productattr_stock'=>$newstock]);
            }
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('frontend.product.paymentsuccess',['paymentmethod'=>$paymentmethod,'events'=>$events]);
        }else{
            return redirect('/mycart');
        }
    }

    // fail paypal
    public function paypalfail(){
        $events=Events::latest()->take(4)->get();
        return view('frontend.product.paypalfail',['events'=>$events]);
    }

    // thankyou page
    public function thankyouorder(){
        $events=Events::latest()->take(4)->get();
        return view('frontend.product.thankyou',['events'=>$events]);
    }

    public function singleevent ($event_slug,$id){
        $events = Events::find($id);
        $events=Events::latest()->take(4)->get();
        return view('frontend.singleevent',compact('events'));
    }

        // BLOG FUNCTIONS
    public function postdetails (Request $request,$slug,$post_id){
        
        $events=Events::latest()->take(4)->get();
        $cats=Blogcategory::all();
        Blogpost::find($post_id)->increment('views');
        $postdetails=Blogpost::find($post_id);
        $recent_posts= Blogpost::latest()->limit(5)->get();
        $posttags=Blogtag::all();
        $relatedposts=Blogpost::where('id',"!=",$post_id)->take(4)->get();
        $postcomments=Postcomments::where('post_id',$post_id)->get();
        return view('frontend.blogs.blogpost',compact('events','recent_posts','posttags','relatedposts','postcomments','cats','postdetails'));
    }

    public function blogcategories (Request $request)
    {
        $posts=Blogpost::all();
        $recent_posts= Blogpost::latest()->limit(5)->get();
        $allcategories=Blogcategory::orderby('id','desc')->paginate(3);
        return view('frontend.blogs.blogcategories',['allcategories'=>$allcategories,'recent_posts'=>$recent_posts]);
    }

    public function blogcategory (Request $request, $cat_slug,$cat_id)
    {
        $events=Events::latest()->take(4)->get();
        $cats=Blogcategory::all();
        $blogcategorys=Blogcategory::find($cat_id); 
        $posttags=Blogtag::all();
        $blogposts=Blogpost::where('cat_id',$cat_id)->orderBy('id','desc')->paginate(5);
        $recent_posts= Blogpost::latest()->limit(5)->get();
        return view('frontend.blogs.blogcategory',
            ['events'=>$events,'cats'=>$cats,'blogcategorys'=>$blogcategorys,'recent_posts'=>$recent_posts,'posttags'=>$posttags,'blogposts'=>$blogposts]);
    }

    public function blogtag (Request $request, $tag_slug,$tag_id)
    {
        $events=Events::latest()->take(4)->get();
        $tags=Blogtag::all();
        $posttags=Blogtag::all();
        $cats=Blogcategory::all();
        $blogtag=Blogtag::find($tag_id);
        $blogposts=Blogpost::orderBy('id','desc')->paginate(3);
        $recent_posts= Blogpost::latest()->limit(5)->get();
        return view('frontend.blogs.posttags',['cats'=>$cats,'posttags'=>$posttags,'blogposts'=>$blogposts,'events'=>$events,'tags'=>$tags,'blogtag'=>$blogtag,'recent_posts'=>$recent_posts,'blogposts'=>$blogposts]);
    }
    
    
}
