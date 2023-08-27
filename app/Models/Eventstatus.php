<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventstatus extends Model
{
    use HasFactory;

    protected $fillable=['event_status_title'];
    
}
