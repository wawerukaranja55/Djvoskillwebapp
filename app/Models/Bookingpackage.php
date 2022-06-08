<?php

namespace App\Models;

use App\Models\Bookings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class bookingpackage extends Model
{
    use HasFactory;

    protected $fillable=['package_name','package_description','package_price'];

    public function bookingpackags(){
        return $this->belongsToMany(Bookings::class);
    }
}
