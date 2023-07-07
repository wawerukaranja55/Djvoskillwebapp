<?php

namespace App\Models;

use App\Models\Ordersproduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = ['first_name','last_name','phone','email','county','town','tracking_id','coupon_code','order_status',
                            'payment_method','user_id','grand_total','shipping_charges','coupon_amount'];

    public function orders_products()
    {
        return $this->hasMany(Ordersproduct::class,'order_id');
    }

    function shipping_vehicle(){
        return $this->belongsTo('App\Models\Shipping_Vehicle','id','order_id');
    }
}
