<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mpesa_Payment extends Model
{
    use HasFactory;

    protected $table = 'mpesapayments';
    protected $fillable = ['phone','mpesatransaction_id','is-paid','amount','first_name','last_name'];
}
