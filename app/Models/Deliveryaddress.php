<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Deliveryaddress extends Model
{
    use HasFactory;
    protected $table = 'deliveryaddresses';
    protected $fillable = ['user_id','first_name','last_name','pickuppoint','company_name','phone','county_id','city_id'];

    public static function deliveryaddresses(){
        $user_id=Auth::id();
        $deliveryaddresses=Deliveryaddress::where('user_id',$user_id)->first();

        return $deliveryaddresses;
    }

    public function shipcharges(){
        return $this->belongsTo('App\Models\shipping_charge','county_id','id');
    }

    public function towns(){
        return $this->belongsTo('App\Models\Town','city_id','id');
    }

    public function deliveryuser(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
