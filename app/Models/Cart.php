<?php

namespace App\Models;


use App\Models\Merchadise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = ['session_id','size','user_id','product_id','quantity'];

    public function product(){
        return $this->belongsTo(Merchadise::class,'product_id','id');
    }

    public static function usercartitems(){
        if(Auth::check())
        {
            
            $usercartitems=Cart::with(['product'=>function($query){
                $query->select('id','merchcat_id','merch_name','merch_image','merch_code','merch_price','is_attribute');
            }])->where('user_id',Auth::id())->orderby('id','desc')->get();
        }else{
            $usercartitems=Cart::with(['product'=>function($query){
                $query->select('id','merchcat_id','merch_name','merch_image','merch_code','merch_price','is_attribute');
            }])->where('session_id',Session::get('session_id'))->orderby('id','desc')->get();
        }
        return  $usercartitems;
    }

    public static function getproductattrprice($product_id,$productattr_price){
        $attrprice=Productattribute::select('productattr_price','product_id')->where([
            'product_id'=>$product_id,
            'productattr_price'=>$productattr_price
        ])->first();
        return  $attrprice['productattr_price'];
    }
}
