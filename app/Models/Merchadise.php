<?php

namespace App\Models;


use App\Models\Cart;
use App\Models\Productimages;
use App\Models\Merchadisestatus;
use App\Models\Productattribute;
use App\Models\Merchadisecategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchadise extends Model
{
    use HasFactory;
    protected $table = 'merchadises';
    protected $fillable = ['merchcat_id','merch_name','merch_price','merch_code','merch_image','merch_details','status','product_discount','fabric'];

    public function merchadisecategor(){
        return $this->belongsTo('App\Models\Merchadisecategory','merchcat_id','id');
    }

    public function merchadisestatus(){
        return $this->belongsToMany(Merchadisestatus::class);
    }

    public function merchadiseimages(){
        return $this->hasMany(Productimages::class);
    }

    public function merchadiseattributes(){
        return $this->hasMany(Productattribute::class,'product_id');
    }

    public function cartproducts(){
        return $this->hasMany(Cart::class);
    }
    
    public static function getdiscountedprice($product_id){
        $prodetails=Merchadise::select('merch_price','product_discount','merchcat_id')
            ->where('id',$product_id)->first();

        $catdetails=Merchadisecategory::select('category_discount')
            // ->where('id',$prodetails['category_id'])
            ->first();

        if($prodetails['product_discount']>0){
            $discountedprice=$prodetails['merch_price']-($prodetails['merch_price']*$prodetails['product_discount']/100);

        }
        elseif($catdetails['category_discount']>0){
            $discountedprice=$prodetails['merch_price']-($prodetails['merch_price']*$catdetails['category_discount']/100);
        }
        else
        {
            $discountedprice=0;
        }
        return $discountedprice;
    }

    public static function getdiscountedattrprice($product_id,$productattr_size){
        $proattrprice=Productattribute::
        select('product_id','productattr_size','productattr_price')
        ->
        where(['product_id'=>$product_id,'productattr_size'=>$productattr_size])
        // ->
        ->first();
        
         //dd($proattrprice);die();
        $prodetails=Merchadise::select('merch_price','product_discount','merchcat_id')
            ->where('id',$product_id)->first();
        
        $catdetails=Merchadisecategory::select('category_discount')->where('id',$prodetails['merchcat_id'])->first();

        if($prodetails['product_discount']>0){
            
            $final_price=$proattrprice['productattr_price']-($proattrprice['productattr_price']*$prodetails['product_discount']/100);
            
            $discount=$proattrprice['productattr_price']-$final_price;     
        
            
        }elseif($catdetails['category_discount']>0){
            
            $final_price=$proattrprice['productattr_price']-($proattrprice['productattr_price']*$catdetails['category_discount']/100);
            
            $discount=$proattrprice['productattr_price']-$final_price;
        }else{
            $final_price=$proattrprice['productattr_price'];
            $discount=0;

        }
        return array (
            'merch_price'=>$proattrprice['productattr_price'],
            'final_price'=>$final_price,
            'discount'=>$discount);
    }


    public static function cartcount(){
        if(Auth::check()){
            $user_id=Auth::user()->id;
            $cartcount=DB::table('carts')->where('user_id',$user_id)->sum('quantity');
        }else{
            $session_id=Session::get('session_id');
            $cartcount=DB::table('carts')->where('session_id',$session_id)->sum('quantity');
        }
        return $cartcount;
    }

    // show product filters
    public static function productfilters(){
        $productfilters['fabricarray']=array('cotton','woolen','polyster','leather');
        $productfilters['occasionarray']=array('wedding','nightparty','office','casual');

        return $productfilters;
    }
}
