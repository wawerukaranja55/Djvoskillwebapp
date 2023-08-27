<?php

namespace App\Models;

use App\Models\Ticketstatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;

    protected $fillable=['event_name','location_latitude','location_longitude','event_venue','eventcat_id','event_date','is_ticket','event_location','event_time','event_flyer'];

    public function eventcategory(){
        return $this->belongsTo('App\Models\Event_category','eventcat_id','id');
    }

    public function event_statuses(){
        return $this->belongsToMany('App\Models\Eventstatus','event_status','event_id','status_id');
    }

}
