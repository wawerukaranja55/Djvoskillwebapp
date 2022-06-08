<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mpesapayment extends Model
{
    use HasFactory;

    protected $table = 'mpesapayments';
    protected $fillable = ['phone','mpesatransaction_id','amount','customer_name'];
}
