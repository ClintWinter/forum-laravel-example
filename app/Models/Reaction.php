<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'value'];

    public function reactable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }
}
