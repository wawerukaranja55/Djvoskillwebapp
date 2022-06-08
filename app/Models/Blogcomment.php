<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogcomment extends Model
{
    use HasFactory;
    protected $fillable=['post_id','comment_author','comment_email','is_active','post_comment'];

    public function commentreplies ()
    {
        return $this->hasMany('App\Models\Blogcommentreply');
    }

    public function blogposts ()
    {
        return $this->belongsTo('App\Models\Blogpost','post_id','id');
    }
}
