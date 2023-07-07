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
        $posts=Blogpost::orderby('id','asc')->paginate(4);
        
        return view('frontend.blogs.blogs',['events'=>$events,'cats'=>$cats,'posts'=>$posts,'recent_posts'=>$recent_posts,'posttags'=>$posttags]);
    }

    public function events (){
        
        $events=Events::orderby('id','desc')->paginate(4);
        return view('frontend.events',['events'=>$events]);
    }
   
    public function merchadise (Request $request){
        if($request->ajax()){

            $data=$request->all();
            $url=$data['url'];

            $categorycount=Merchadisecategory::where(['url'=>$url,'status'=>1])->count();
            if($categorycount>0){
                $categorydetails=Merchadisecategory::categorydetails($url);

                $categoryproducts=Merchadise::whereIn('merchcat_id',$categorydetails['catids'])->with('merchadiseattributes')
                ->where('merch_isactive',1);

                    // show products on pushing a slider
                if(isset($data['start']) && !empty($data['start'])){
                    $categoryproducts->where('merch_price','>=',$request->start)
                     ->where('merch_price','<=', $request->end);
                }
                
                    // check the fabric filtering value is selected
                if(isset($data['fabric']) && !empty($data['fabric'])){
                    $categoryproducts->whereIn('merchadises.fabric',$data['fabric']);
                    
                }

                // check the occasion filtering value is selected
                if(isset($data['occasion']) && !empty($data['occasion'])){
                    $categoryproducts->whereIn('merchadises.occasion',$data['occasion']);
                    
                }
                    // check the sorting value is selected
                if(isset($_GET['sort']) && !empty($_GET['sort'])){

                    if($_GET['sort']=="latest_products"){

                        $categoryproducts->orderBy('id','Desc');
                    }
                    elseif($_GET['sort']=="low_to_high"){
                        $categoryproducts->orderBy('merch_price','Asc');
                    }
                    elseif($_GET['sort']=="high_to_low"){
                        $categoryproducts->orderBy('merch_price','Desc');
                    }
                    elseif($_GET['sort']=="most_popular"){
                        $categoryproducts->orderBy('product_views','Desc');
                    }
                    elseif($_GET['sort']=="product_name_a_z"){
                        $categoryproducts->orderBy('merch_name','Asc');
                    }
                    elseif($_GET['sort']=="product_name_z_a"){
                        $categoryproducts->orderBy('merch_name','Desc');
                    }
                }
                
                // search products in the db using ajax..for now its not working and cant use it
                // if(isset($_REQUEST['search_products']) && !empty($_REQUEST['search_products'])){
                //     $searchproduct=$_REQUEST['search_products'];

                //     $categorydetails['breadcrumbs']=$searchproduct;
                //     $categorydetails['categorydetails']['merchadisecat_title']=$searchproduct;

                
                //     $categoryproducts->where('merch_name','like','%'.$searchproduct.'%');
                //         // ->orwhere('merch_code','like','%'.$searchproduct.'%')
                //         //->get();

                // }
                
                $productscategory=$categoryproducts->paginate(7);

                // dump($productscategory);
                $events=Events::latest()->take(4)->get();
                
                return view('frontend.product.productsjson',compact('events','url','productscategory'));
            }  
            else{
                abort (404);
            }
        }else{

            $url=Route::current()->uri();
            
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
            
                return view('frontend.product.products2',compact('events','url','categorydetails','productscategory','fabricarray','occasionarray','productcategories'));
            }else{
                abort(404);
            }
        }
    }

    public function findproducts(Request $request){

        $data=$request->all();

        $url=$data['url'];
            
        if($request->get('search_products'))
        {

            $query=$request->get('search_products');

            $categorydetails=Merchadisecategory::categorydetails($url);

            $categoryproducts=Merchadise::whereIn('merchcat_id',$categorydetails['catids'])->with('merchadiseattributes')
            ->where('merch_isactive',1);

            $data=$categoryproducts->where('merch_name','like','%'.$query.'%')->get();

            $output='<div class="filter-box">
                        <ul class="dropdown-menu" style="min-width:26rem; margin:3px; border-top:none; display:block; position:relative;">';
                        foreach($data as $row)
                        {
                            // $productlink="http://djvoskill/merchadise/.$row->merch_name./.$row->id.";
                            
                            $output.='<li><a href="#">'.$row->merch_name.'</a></li>';
                        }
        }$output.='</ul></div>';

        echo $output;
    }

    public function singleproduct ($product_slug,$id){

        $singleproduct=Merchadise::with('merchadisecategor')->find($id);
        // dd($singleproduct);die();
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
        
        $data=$request->all();

            // get details of the product added to cart
            $product_check_details=Merchadise::where('id',$data['product_id'])->first();

            $session_id=Session::get('session_id');
            if(empty($session_id)){
                $session_id=Session::getId();
                Session::put('session_id',$session_id);
            }

            $productexist = Cart::where('session_id',$session_id)->where('product_id',$data['product_id'])->first();
            if($productexist)
            {
                return response()->json(['message'=>$product_check_details->merch_name." Already Exist in the cart"]);
            }else{

                if(Auth::check()){
                    $user_id=Auth::user()->id;
                }else{
                    $user_id=0;
                }

                $newcart = new Cart();
                $newcart->session_id = $session_id;
                $newcart->product_id =$data['product_id'];
                $newcart->size = $data['productattrsize'];
                $newcart->user_id=$user_id;
                $newcart->quantity = $data['quantity'];
                $newcart->product_price =$data['productprice'];
                $newcart->save();

                $itemsincart=Cart::where('session_id',$session_id)->where('user_id',$user_id)->sum('quantity');

                return response()->json(['message'=>$product_check_details->merch_name." Added to Cart",
            'itemsincart'=>$itemsincart]);

            // check if the product exist in the cart

            // $getproductstock=Productattribute::where(['product_id'=>$request->product_id,'productattr_size'=>$request->productsize])->first();
            // if( $getproductstock['productattr_stock']<$request->quantity);
            // {
            //     $message="The Quantity isn't available at the moment";
            //     Session::flash('error_message',$message);
            //     return redirect()->back();
            // }

            
            // $session_id=Session::get('session_id');
            // if(empty($session_id)){
            //     $session_id=Session::getId();
            //     Session::put('session_id',$session_id);
            // }

            // $countproducts=Cart::where([
            //     'product_id'=>$data['product_id'],
            //     'productattr_size'=>$data['productattr_size'],
            // ])->count();
            
            // if($countproducts>0){
            //     $message="The Product Already exists in the Cart";
            //     Session::flash('error_message',$message);
            //     return redirect()->back();
            // }

            // if(Auth::check()){
            //     $user_id=Auth::user()->id;
            // }else{
            //     $user_id=0;
            // }

            // if(!empty($request->productattrsize))
            // {
            //     $product_size=$request->productattrsize;
            // } else {
            //     $product_size="Doesnt_have_a_size";
            // }

            // $cart = new Cart();
            // $cart->session_id = $session_id;
            // $cart->product_id =$request->product_id;
            // $cart->size =$request->productsize;
            // $cart->user_id=$user_id;
            // $cart->quantity = $data['quantity'];
            // $cart->save();
            
            // $message="The Product has been added to Cart";
            //     Session::flash('success_message',$message);
            //     return redirect('/mycart')->with('success_message','Product has been Added to cart');
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
            (
                [   
                    'view'=>(string)view::make('frontend.product.cartitems')->with(compact('cartitems','shippingcharges'))
                ]
            );
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

        $product_id=$request->input('product_id');

        $product_qty=$request->input('quantity');

        $product_attrsize=$request->productattrsize;

        $product_price=$request->prdctprice;

        $product_check=Merchadise::where('id',$product_id)->first();

        dd($product_price);die();

        $session_id=Session::get('session_id');
        if(empty($session_id)){
            $session_id=Session::getId();
            Session::put('session_id',$session_id);
        }


        $productexist = Cart::where('session_id',$session_id)->where('product_id',$product_id)->first();
        // dd($productexist);die();
        if($productexist)
        {
            return response()->json(['status'=>$product_check->merch_name."Already Exist in the cart"]);
        }else{

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
        $data=$request->all();
        
        //$total_amount = ((int)$data['total_amount']) + ((int)$data['shipping_amount']);

        $total_amount=$data['total_amount'];
        
        $couponcount=coupon::where('coupon_code',$data['couponcode'])->count();

        if($couponcount==0){
            return response()->json([
                'status'=>400,
                'message'=>'This Coupon Is Not Valid'
            ]);
        }else{
            $coupondetails=coupon::where('coupon_code',$data['couponcode'])->first();
            if($coupondetails['status']==0){
                return response()->json([
                    'status'=>415,
                    'message'=>'This Coupon Is Not Active'
                ]);
            }

            $expiry_date=$coupondetails->expiry_date;
            $current_date=date('m/d/y');
            if($expiry_date<$current_date){
                return response()->json([
                    'status'=>405,
                    'message'=>'This Coupon Is Exired'
                ]);
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

            // $total_amount=0;
            foreach($usercartitems as $item){
                if(!in_array($item['product']['merchcat_id'],$catarr)){
                    return response()->json([
                        'status'=>410,
                        'message'=>'This Coupon Code Is Not For This Products'
                    ]);
                }

                if(!empty($coupondetails->users)){
                    if(!in_array($item['user_id'],$userid)){
                        return response()->json([
                            'status'=>420,
                            'message'=>'This Coupon Code Is Not For You'
                        ]);
                    }
                }
            }

             //echo"Coupon Can Be Redeemed Successfully";die();

            //apply coupon 
            if($coupondetails->amount_type=="Fixed"){
                $couponamount=round($coupondetails->amount);
            }else{
                $couponamount=round($total_amount*($coupondetails->amount/100));
            }

            $grand_total_payable=round($total_amount)-$couponamount;

            return response()->json([
                'status'=>200,
                'message'=>'Coupon Can Be Redeemed Successfully',
                'couponamount'=>$couponamount,
                'couponcode'=>$data['couponcode'],
                'grand_total_payable'=>$grand_total_payable
            ]);
        }
    }

    public function checkout(){
        $events=Events::latest()->take(4)->get();
        $delivaddresses=shipping_charge::all();

        if(Auth::check())
        {
            $userid=Auth::user()->id;
        } else {
            $userid=0;
        }
        //dd($userid);die();

        $session_id=Session::get('session_id');
        if(empty($session_id)){
            $session_id=Session::getId();
            Session::put('session_id',$session_id);
        }

        $cartorder_id=Cart::where('user_id',$userid)->pluck('order_id');

        $getorder_id=$cartorder_id[0];

        $orderplaced_status=Cart::where('user_id',$userid)->pluck('is_order');

        //$payment_mode=Order::where('id',$getorder_id)->pluck('payment_method');

        //$order_total=Order::where('id',$getorder_id)->pluck('grand_total');

        $order_details=Order::select('grand_total','payment_method','tracking_id')->where('id',$getorder_id)->get();

        //dd($order_details[0]->payment_method);die();

        $payment_methods=payment_methods::where('status',1)->get();
        
        $usercartitems=Cart::usercartitems();

        $deliveriesdata=Deliveryaddress::deliveryaddresses();

        return view('frontend.product.checkout')->with(compact('events','getorder_id','order_details','orderplaced_status','userid','cartorder_id','payment_methods','deliveriesdata','delivaddresses','usercartitems'));
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

                // $productattrstock=Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->first();
                //     $newstock=$productattrstock['productattr_stock']-$item['quantity'];
                //     Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->update(['productattr_stock'=>$newstock]);
                
                // if($productdetails->is_attribute==0)
                // {
                //     // if the product doesnt has attributes
                //     $productattrstock=Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->first();
                //     dd($productattrstock);die();
                //     $newstock=$productattrstock['productattr_stock']-$item['quantity'];
                //     Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->update(['productattr_stock'=>$newstock]);

                // }elseif($productdetails->is_attribute==1)
                // {
                //     // if the product have attributes
                //     $productattrstock=Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->first();
                //     $newstock=$productattrstock['productattr_stock']-$item['quantity'];
                //     Productattribute::where(['product_id'=>$item['product_id'],'productattr_size'=>$item['size']])->update(['productattr_stock'=>$newstock]);
                // }
                
            }
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('frontend.product.paymentsuccess',['paymentmethod'=>$paymentmethod,'events'=>$events]);
        }else{
            return redirect('/mycart');
        }
    }

    // fail paypal
    public function paypalfail(){
        $paymentmethod=Order::pluck('payment_method')->first();
        $events=Events::latest()->take(4)->get();
        return view('frontend.product.paypalfail',['paymentmethod'=>$paymentmethod,'events'=>$events]);
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
