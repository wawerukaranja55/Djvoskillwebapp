<?php

use App\Models\mpesapayment;
use App\Models\Postcomments;
use App\Http\Middleware\Admin;
use App\Models\Merchadisecategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mix_Controller;
use App\Http\Controllers\Home_Controller;
use App\Http\Controllers\Role_Controller;
use App\Http\Controllers\User_controller;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\orderscontroller;
use App\Http\Controllers\Searchcontroller;
use App\Http\Controllers\Admins_Controller;
use App\Http\Controllers\Front_controllers\Event_Front_Controller;
use App\Http\Controllers\Address_Controller;
use App\Http\Controllers\Blogtag_controller;
use App\Http\Controllers\contact_controller;
use App\Http\Controllers\Product_Controller;
use App\Http\Controllers\Blogpost_Controller;
use App\Http\Controllers\Bookings_controller;
use App\Http\Controllers\Signinup_Controller;
use App\Http\Controllers\ContactUs_Controller;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Merchadise_controller;
use App\Http\Controllers\MpesaPayment_Controller;
use App\Http\Controllers\PostComment_controller;
use App\Http\Controllers\Userprofile_controller;
use App\Http\Controllers\Blogcategory_Controller;
use App\Http\Controllers\Order_Controller;
use App\Http\Controllers\Events_Controller;
use App\Http\Controllers\Adminsettings_controller;
use App\Http\Controllers\AdminDashboard_Controller;
use App\Http\Controllers\Commentreplies_controller;
use App\Http\Controllers\Bookingcategory_controller;
use App\Http\Controllers\MpesatransactionController;
use App\Http\Controllers\Merchadisesection_controller;
use App\Http\Controllers\product_categoriescontroller;
use App\Http\Controllers\Bookingsattributes_controller;
use App\Http\Controllers\Merchadisecategory_controller;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/slider', function () {
    return view('frontend.slider');
});

Route::get('/post', function () {
    return view('frontend.post');
});

Route::get('/', [Home_Controller::class,'homepage'])->name('index');

    // Login and Sign Up Controllers
Route::get('registeruser',[Signinup_Controller::class,'register'])->name('register');

Route::get('loginuser',[Signinup_Controller::class,'login'])->name('login');

    // activation controller 
Route::match(['get','post'],'confirmaccount/{code}',[Signinup_Controller::class,'confirmaccount']);

    // forgot password controller 
Route::match(['get','post'],'forgotpassord',[Signinup_Controller::class,'forgotpassword']);

    // signin,logout and sign up functions
Route::post('signup',[Signinup_Controller::class,'signup'])->name('signup');

Route::get('check_email',[Signinup_Controller::class,'check_email'])->name('check_email');

Route::post('signin',[Signinup_Controller::class,'signin'])->name('signin');

Route::post('signout', [Signinup_Controller::class,'signout'])->name('signout');

        // Route::get('/logout', [AuthenticatedSessionController::class,'destroy'])->name('logout');

            /*Mixtapes Page */
Route::view('/allmixtapes', 'frontend.allmixtapes')->name('allmixtapes');
Route::view('/videomixtapes', 'frontend.mixtapes.videomixtapes')->name('videomixtapes');
Route::get('/home/download/{mix_audio}', [Home_Controller::class,'download']);
Route::get('/audiomixtapes', [Home_Controller::class,'audiomixtapes'])->name('audiomixtapes');
            
            /*Events Page */
Route::get('/events', [Event_Front_Controller::class,'events'])->name('events');
Route::get('get_more_events',[Event_Front_Controller::class,'get_more_events'])->name('events.get-more-events');
Route::get('/getfirstevents', [Event_Front_Controller::class,'get_first_events'])->name('events.get-first-events');
Route::get('/getcordsforevent', [Events_Controller::class,'getcords_forid'])->name('admin.getcords'); 

            /*Merchadise Page */
$caturls=Merchadisecategory::select('url')->where('status',1)->get()->pluck('url');

foreach($caturls as $url)
{
    
    Route::get('/'.$url,[Home_Controller::class,'merchadise'])->name('merchadise');
}


Route::get('merchadise/{slug}/{id}', [Home_Controller::class,'singleproduct'])->name('singleproduct');

// find products in the db using jquery ajax
Route::post('autocomplete/fetch', [Home_Controller::class,'findproducts'])->name('findproducts');

Route::post('/addtocart', [Home_Controller::class,'addtocart'])->name('addtocart');

// get attribute price in the product page
Route::post('/add_to_cart', [Home_Controller::class,'add_to_cart'])->name('add_to_cart');

Route::post('/getproductprice', [Home_Controller::class,'getproductprice'])->name('getproductprice');

// get attribute price in the listing page
Route::post('/getattrproductprice', [Home_Controller::class,'getattrproductprice'])->name('getattrproductprice');

Route::get('/mycart',[Home_controller::class,'cart'])->name('mycart');

Route::get('delete-cart-item/{id}', [Home_controller::class,'deletecartitem'])->name('deletecartitem');

Route::post('/updatecartitemquantity', [Home_Controller::class,'updatecartitem'])->name('updatecartitem');

Route::get('/getshippingprice',[Home_controller::class,'getshippingprice'])->name('getshippingprice');

Route::get('/displayshippingprice',[Home_controller::class,'displayshippingprice'])->name('displayshippingprice');

Route::resource('address',Address_Controller::class);

Route::group(['middleware'=>['Added_to_Cart']],function(){

    Route::get('/checkout',[Home_controller::class,'checkout'])->name('mycheckout');
});

Route::group(['middleware'=>['auth']],function(){

    Route::resource('userprofile',Userprofile_controller::class);

    Route::get('/get_userorders',[Userprofile_controller::class,'userorders'])->name('user.orders');

    Route::post('/apply-coupon',[Home_controller::class,'applycoupon'])->name('apply_coupon');

    

    //show all orders by a user
    Route::post('/place_order', [Order_Controller::class,'place_order'])->name('place_order');

    Route::post('/post_paypal', [Order_Controller::class,'post_paypal'])->name('post_paypal');

    Route::get('/paypal', [Home_Controller::class,'paypal'])->name('paypal');

    Route::post('/mpesa_confirmation', [Order_Controller::class,'mpesa_confirmation'])->name('mpesa.confirmation');

        //successfull payments
    Route::get('payment/success', [Home_Controller::class,'paymentsuccess'])->name('paymentsuccess');

    Route::get('paypal/fail', [Home_Controller::class,'paypalfail'])->name('paypalfail');

        // pay with mpesa
    Route::get('/mpesa', [Home_Controller::class,'mpesa'])->name('mpesa');

    Route::get('/mpesa/confirm/{id}', [Home_Controller::class,'confirm_mpesa'])->name('confirm_mpesa');

    Route::post('/mpesa/confirm/transaction', [MpesatransactionController::class,'confirm_transaction'])->name('confirm_transaction');

    Route::get('/thankyou',[Home_controller::class,'thankyouorder'])->name('thankyouorder');
});

            /*Blog Page */
Route::group(['prefix'=>'blog'],function(){

    /*All Blogs Page */
    Route::get('/', [Home_Controller::class,'blog'])->name('blog');

    /*Blog categories */
    Route::get('blogcategories', [Home_Controller::class,'blogcategories']);

    /*Blog-Post Page */
    Route::get('/post/{slug}/{id}', [Home_Controller::class,'postdetails'])->name('postdetails');

    /*Blog-category Page */
    Route::get('category/{slug}/{id}', [Home_Controller::class,'blogcategory'])->name('blogcategory');

    /*Blog-tag Page */
    Route::get('tag/{slug}/{id}', [Home_Controller::class,'blogtag'])->name('tag');

    /*Post comment Page */
    Route::post('blog/postcomment/{id}', [PostComment_controller::class,'store'])->name('postcomment');

    Route::get('comment/{id}/delete',[PostComment_controller::class,'destroy']);

    // Comment reply Page 
    Route::post('post/comment/reply/{id}', [Commentreplies_controller::class,'store'])->name('commentreply');

    Route::get('reply/{id}/delete',[Commentreplies_controller::class,'destroy']);
    
});



       

            /*Contact Us Page */

Route::resource('contact',contact_controller::class);

Route::post('/sendbooking', [Bookings_controller::class,'store'])->name('sendbooking');

            /*Search Bar*/
Route::resource('search',Searchcontroller::class);

Route::resource('/subscribe',NewsletterController::class);
// Route::get('/dashboard', function () {
//     return view('admin.index');
//     })->middleware(['auth'])->name('dashboard');

//     require __DIR__.'/auth.php';


Route::group(['prefix'=>'admin','middleware'=>(['auth','Admin'])],function(){

        // show notifications to the admins
    Route::get('/mynotifications', [Bookings_controller::class,'mynotifications'])->name('mynotifications');

    Route::resource('dashboard',AdminDashboard_Controller::class);

    Route::resource('roles',Role_Controller::class);

    Route::get('roles/{id}/delete',[Role_Controller::class,'destroy']);

    Route::resource('admins',Admins_Controller::class)->parameters(['admins'=>'user']);

    Route::resource('users',User_controller::class);

    Route::resource('blogtags', Blogtag_controller::class);

    Route::get('blogtags/{id}/delete',[Blogtag_controller::class,'destroy']);

    Route::resource('blogcategory', Blogcategory_Controller::class);

    Route::get('blogcategory/{id}/delete', [Blogcategory_Controller::class,'destroy']);

    Route::resource('blogpost', Blogpost_Controller::class);

    Route::get('merchadise/attributes', [Merchadise_controller::class,'attributes'])->name('attributes');

    Route::resource('merchadise', Merchadise_controller::class);

    Route::resource('merchadisecategory', Merchadisecategory_controller::class);

    Route::get('/updatecategorystatus',[Merchadisecategory_controller::class,'updatecategorystatus'])->name('updatecategorystatus');

    Route::resource('merchadisesections', Merchadisesection_controller::class);

    Route::get('/updatesectionstatus',[Merchadisesection_controller::class,'updatesectionstatus'])->name('updatesectionstatus');

    Route::get('delete-merch-image/{id}', [CouponController::class,'deletemerchimage'])->name('deletemerchimage');

    Route::get('delete-merch-video/{id}', [CouponController::class,'deletemerchvideo'])->name('deletemerchvideo');

    // Route::get('merchadise/addatributes/{id}', [Merchadise_controller::class,'show'])->name('addattributes');
    
    Route::resource('coupons', CouponController::class);

    // Orders made by customers
    Route::get('/new_orders', [orderscontroller::class,'new_orders'])->name('orders.new');

    Route::get('/intransit_orders', [orderscontroller::class,'intransit_orders'])->name('orders.intransit');

    Route::get('/delivered_orders', [orderscontroller::class,'delivered_orders'])->name('orders.delivered');

    Route::get('/picked_orders', [orderscontroller::class,'picked_orders'])->name('orders.picked');

    Route::get('/get_neworders', [orderscontroller::class,'neworders'])->name('users.neworders');

    Route::get('/get_intransitorders', [orderscontroller::class,'intransitorders'])->name('users.intransitorders');

    Route::get('/get_deliveredorders', [orderscontroller::class,'deliveredorders'])->name('users.deliveredorders');

    Route::get('/get_neworders', [orderscontroller::class,'neworders'])->name('users.neworders');

    Route::get('/get_userorder/{id}', [orderscontroller::class,'user_order'])->name('user.order');

    Route::post('/update_userorder/{id}', [orderscontroller::class,'update_order'])->name('update.order'); 

    Route::post('/update_ordervehicle/{id}', [orderscontroller::class,'update_order_vehicle_reg'])->name('update_order.vehicle_reg');

    Route::post('/update_orderpicking/{id}', [orderscontroller::class,'update_order_to_picking'])->name('update_order.picking'); 

    Route::post('/attributes/{id}', [Merchadise_controller::class,'addattributes'])->name('addattributes');

    Route::match(['get','post'],'edit-attributes/{id}', [Merchadise_controller::class,'editattributes'])->name('editattributes');

    Route::post('/updateattributestatus', [Merchadise_controller::class,'updateattributestatus'])->name('updateattributestatus');

    Route::get('/shippingcharges', [Merchadise_controller::class,'shippingcharges'])->name('shippingcharges'); 

    Route::get('/get_shippingprices', [Merchadise_controller::class,'get_shippingprices'])->name('get_shippingprices');

    Route::get('/updatetownshippingstatus',[Merchadise_controller::class,'updatetownshippingstatus'])->name('updateshipping.status');

    Route::get('/get_shippingcounties', [Merchadise_controller::class,'get_shippingcounties'])->name('get_shippingcounties');

    Route::post('/addshippingprice', [Merchadise_controller::class,'addshippingprice'])->name('addshippingprice');

    Route::match(['get','post'],'editshippingcharges/{id}', [Merchadise_controller::class,'editshippingcharge'])->name('editshippingcharge');

    Route::get('/updateshippingstatus',[Merchadise_controller::class,'updateshippingstatus'])->name('updateshippingstatus');

    Route::get('/updatecouponstatus',[Merchadise_controller::class,'updatecouponstatus'])->name('updatecouponstatus');
    
    /*Post comment Page */

    Route::get('blogpost/{id}/delete', [Blogpost_Controller::class,'destroy']);

    Route::get('/settings', [Adminsettings_controller::class,'settings']);


    Route::resource('mixxes', Mix_Controller::class);

    Route::get('/postcomments', [PostComment_controller::class,'index'])->name('allcomments');

    //Manage events routes

    Route::get('/events', [Events_controller::class,'events'])->name('admin.events');

    Route::get('/get_allevents', [Events_controller::class,'getallevents'])->name('admin.getallevents');

    Route::get('/getevents', [Events_controller::class,'getevents'])->name('admin.getevents');

    Route::post('/postevent', [Events_controller::class,'post_event'])->name('admin.postevent');

    Route::get('/getevent', [Events_controller::class,'getevent'])->name('admin.eventdetails');

    Route::get('/get_eventdetails', [Events_controller::class,'geteventdetails'])->name('admin.geteventdetails');
    
    Route::get('/editevent', [Events_controller::class,'editevent'])->name('admin.editevent'); 

    Route::get('/deactivateevent', [Events_controller::class,'deactivateevent'])->name('admin.deactivateevent');

    Route::get('/geteventstatus/{id}', [Events_controller::class,'getevent_status'])->name('admin.geteventstatus');

    Route::post('/changeeventstatus', [Events_controller::class,'changeevent_status'])->name('admin.changeeventstatus');

    
                // Bookings Attributes

    Route::get('/bookingsattributes', [Bookingsattributes_controller::class,'index'])->name('bookingattributes');

    Route::resource('bookingcategory', Bookingcategory_controller::class);

    Route::get('editbooking/{id}', [Bookings_controller::class,'show'])->name('singlebooking');

               // 1st Approval by The Manager

    Route::get('/recievedbookings', [Bookings_controller::class,'index'])->name('receivedbookings');

    Route::post('/booking/changestatus/{id}', [Bookings_controller::class,'update'])->name('changestatus');

    Route::get('booking/{id}/delete', [Bookings_controller::class,'destroy'])->name('deletebooking');

            // Approval by The Accountant

    Route::get('/approvedbookings', [Bookings_controller::class,'approved'])->name('approvedbookings');

    Route::get('requestpayment/{id}', [Bookings_controller::class,'requestpayment'])->name('requestdeposit');

    Route::get('/paidbookings', [Bookings_controller::class,'depositpaid'])->name('paidbookings');

    Route::get('/cancelledbookings', [Bookings_controller::class,'cancelledbookings'])->name('cancelledbookings');

            // manage mpesa payments
    Route::get('mpesapayments',[MpesaPayment_Controller::class,'allmpesapayments'])->name('mpesa_payments');

    Route::get('access_token',[MpesaPayment_Controller::class,'getAccessToken'])->name('get_AccessToken');

    Route::get('register_urls',[MpesaPayment_Controller::class,'registerURLs'])->name('register_URLs');
});

Route::group(['middleware'=>config('fortify.middleware',['web'])],
    function(){
        $limiter=config('fortify.limiters.login');
        Route::post('/login',[AuthenticatedSessionController::class,'store'])
        ->middleware(array_filter([
            'guest',
            $limiter?'throttle:'.$limiter:null,
        ]));
    
    });
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
