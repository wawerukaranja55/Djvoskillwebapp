<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postcomments extends Model
{
    use HasFactory;

    protected $fillable=['post_id','comment','user_id'];

    public function blogposts ()
    {
        return $this->belongsTo('App\Models\Blogpost','post_id');
    }

    public function replies(){
    	return $this->hasMany('App\Models\Commentreply','reply_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
