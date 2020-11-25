<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function path()
    {
        return "/users/{$this->id}";
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function reactions()
    {
        return $this->hasMany('App\Models\Reaction');
    }

    public function reactables()
    {
        return $this->comments()
            ->select(['id','body as display', 'created_at'])
            ->withSum('reactions', 'value')
            ->get()
            ->concat(
                $this->posts()
                ->select(['id','title as display', 'created_at'])
                ->withSum('reactions', 'value')
                ->get())
            ->sortByDesc->created_at;
    }

    // total score (combined score of all user's comments and posts)
    public function score()
    {
        $commentScore = DB::query()->fromSub(
            $this->comments()->withSum('reactions', 'value'), 'comment_scores'
        )->sum('reactions_sum_value');

        $postScore = DB::query()->fromSub(
            $this->posts()->withSum('reactions', 'value'), 'post_scores'
        )->sum('reactions_sum_value');

        return $commentScore + $postScore;
    }

    public function scopeWithScore($query)
    {
        $scores = User::addSelect([
            'users.id as user_id',
            'comment_score' => DB::query()
                ->selectRaw('coalesce(sum(reactions_sum_value),0)')
                ->fromSub(Comment::withSum('reactions', 'value'), 'comment_scores')
                ->whereColumn('user_id', 'users.id'),

            'post_score' => DB::query()
                ->selectRaw('coalesce(sum(reactions_sum_value),0)')
                ->fromSub(Post::withSum('reactions', 'value'), 'post_scores')
                ->whereColumn('user_id', 'users.id')
        ]);

        $query->select('users.*')
            ->addSelect(DB::raw('(comment_score + post_score) as score'))
            ->joinSub($scores, 'scores', function ($join) {
                $join->on('users.id', '=', 'scores.user_id');
            });
    }
}
