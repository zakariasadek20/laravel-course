<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;

    public const LOCALES=[
        'en'=>'English',
        'ar'=>'Arabic',
        'fr'=>'Francais'
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_verified_at','created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }
    public function comments(){
        return $this->morphMany('App\Comment','commentable');
    }

    public function image(){
        return $this->morphOne('App\Image','imageable');
    }
    public function scopeUsersActive(Builder $builder){
        return $builder->withCount('posts')->orderBy('posts_count','desc');
    }
    public function scopeUsersActiveInLastMonth(Builder $builder){
        return $builder->withCount(['posts'=>function(Builder $builder){
            $builder->whereBetween(static::CREATED_AT,[now()->subMonth(1),now()]);
        }])->having('posts_count','>','6')
        ->orderBy('posts_count','desc');
    }
}
