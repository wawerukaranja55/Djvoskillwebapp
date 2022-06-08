<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mixxes_Model extends Model
{
    use HasFactory;
    protected $table='mixxes';
    protected $primarykey='id';
    protected $fillable=['mix_name','mix_audio','mix_image','mix_size','mix_length'];
}
