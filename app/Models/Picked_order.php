<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picked_order extends Model
{
    use HasFactory;

    protected $table = 'picked_orders';

    protected $fillable = ['order_id','recipient_id_number','recipient_phone','recipient_firstname','recipient_lastname'];
}
