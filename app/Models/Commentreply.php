<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentreply extends Model
{
    use HasFactory;
    protected $table = 'commentreplies';
    protected $fillable=['comment_id','reply','user_id'];

    public function commentreplies ()
    {
        return $this->belongsTo('App\Models\Postcomments');
    }
    
    public function user ()
    {
        return $this->belongsTo('App\Models\User');
    }
}
