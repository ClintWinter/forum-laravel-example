<?php

namespace App\Models;

use App\Reactability;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, Reactability;

    protected $fillable = ['title', 'body', 'user_id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function isHot() : bool
    {
        return $this->comments()->where('created_at', '>', now()->subDay())->count() > 10;
    }
}
