<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping_Vehicle extends Model
{
    use HasFactory;
    protected $table = 'shipping_vehicles';
    protected $fillable=['vehicle_reg_no','vehicle_driver','order_id'];

}
