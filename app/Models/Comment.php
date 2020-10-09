<?php

namespace App\Models;

use App\Reactability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, Reactability;

    protected $fillable = ['body', 'parent_id'];

    public static function boot()
    {
        parent::boot();

        // delete all nested comments recursively? we don't want that actually...
        // self::deleting(function(Comment $comment) {
        //     foreach ($comment->comments as $c) {
        //         $c->delete();
        //     }
        // });
    }

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
