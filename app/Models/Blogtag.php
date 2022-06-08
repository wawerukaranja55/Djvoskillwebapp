<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogtag extends Model
{
    use HasFactory;
    protected $table='blogtags';
    protected $fillable = ['blogtag_title'];

    public function blogtags ()
    {
        return $this->belongsTo('App\Models\Blogpost');
    }
}

