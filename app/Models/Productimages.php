<?php

namespace App\Models;

use App\Models\Merchadise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productimages extends Model
{
    use HasFactory;

    protected $fillable = ['product_images','product_id'];

    public function merchadise(){
        return $this->belongsTo(Merchadise::class);
    }
}
