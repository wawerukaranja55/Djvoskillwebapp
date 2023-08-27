<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_category extends Model
{
    use HasFactory;

    protected $fillable=['eventcategory_title'];
}
