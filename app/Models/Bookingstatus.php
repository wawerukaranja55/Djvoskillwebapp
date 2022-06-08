<?php

namespace App\Models;

use App\Models\Bookings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookingstatus extends Model
{
    use HasFactory;
    public $table = 'bookingstatuses';
    protected $fillable=['bookingstatus'];

    public function bookings(){
        return $this->belongsToMany(Bookings::class);
    }
}
