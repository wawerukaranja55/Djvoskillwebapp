<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productattribute extends Model
{
    use HasFactory;

    protected $table = 'productattributes';
    protected $fillable = ['productattr_size','product_id','productattr_price','productattr_stock','productattr_sku','productattr_status'];
    
    public function merchads()
    {
        return $this->belongsTo('App\Models\Merchadise','product_id');
    }
}
