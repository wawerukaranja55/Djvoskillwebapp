<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model
{ 
    use HasFactory;
    protected $table = 'blogposts';
    protected $fillable = ['user_id','cat_id','blo_image','tag_id','blo_details','blo_title'];

    function postcomments(){
        return $this->hasMany('App\Models\Postcomments'); 
    }
    
    function user(){
            return $this->belongsTo('App\Models\User','user_id');
    }

    function blogcategor(){
        return $this->belongsTo('App\Models\Blogcategory','cat_id','id');
    }

    function blogtags(){
        return $this->belongsToMany('App\Models\Blogtag','blogpost_blogtag','blogpost_id','blogtag_id');
    }

    
}
