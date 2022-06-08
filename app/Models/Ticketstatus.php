<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketstatus extends Model
{
    use HasFactory;

    protected $fillable=['ticket_type'];

    public function events(){
        return $this->belongsToMany(Events::class);
    }
}
