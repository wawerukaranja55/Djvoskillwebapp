<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookings extends Model
{
    use HasFactory;
    public $table = 'bookings';
    protected $fillable = ['full_name','location','phone','date','email','event_id','event_details','is_booking','package_id'];

    function bookingtyp(){
        return $this->belongsTo('App\Models\Bookingcategory','event_id','id');
    }

    public function bookingstatus(){
        return $this->belongsToMany('App\Models\Bookingstatus',);
    }

    public function bookingpack(){
        return $this->belongsToMany('App\Models\Bookingpackage');
    }
}
