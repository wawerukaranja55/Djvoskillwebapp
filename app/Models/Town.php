<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Town extends Model
{
    use HasFactory;
    protected $table = 'towns';
    protected $fillable = ['county_id','town','pickuppoint','shipping_charges'];

    public static function getshippingcharges($town)
    {
        $shippingdetails=Town::where('town',$town)->get();
        
        $shipping_charges=$shippingdetails['shipping_charges'];
        return $shipping_charges;
    }
}
