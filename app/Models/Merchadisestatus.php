<?php

namespace App\Models;

use App\Models\Merchadise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Merchadisestatus extends Model
{
    use HasFactory;

    protected $fillable=['Product_status'];

    public function products(){
        return $this->belongsToMany(Merchadise::class);
    }
}
