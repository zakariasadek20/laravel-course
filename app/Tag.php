<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    // public function posts()
    // {
    //     return $this->belongsToMany('App\Post')->withTimestamps();
    // }
    public function posts(){
        return $this->morphedByMany('App\Post','taggable');
    }
    public function comments(){
        return $this->morphedByMany('App\Comment','taggable');
    }
}
