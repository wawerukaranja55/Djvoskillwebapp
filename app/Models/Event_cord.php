<?php

namespace App\Models;

use App\Models\Events;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event_cord extends Model
{
    use HasFactory;

    protected $fillable=['location_latitude','location_longitude','event_id'];

    function eventcords(){
        return $this->belongsToMany('App\Models\Events','event_latlngs','location_id','event_id');
    }
}
