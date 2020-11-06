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

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
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
