<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping_charge extends Model
{
    use HasFactory;
    protected $table = 'shipping_charges';
    protected $fillable = ['county','is_shipping'];

}
