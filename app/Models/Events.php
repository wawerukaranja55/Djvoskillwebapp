<?php

namespace App\Models;

use App\Models\Ticketstatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Events extends Model
{
    use HasFactory;

    protected $fillable=['eve_name','eve_date','is_ticket','eve_location','eve_time','eve_details','eve_image'];

    public function ticketstatus(){
        return $this->belongsToMany(Ticketstatus::class);
    }
}
