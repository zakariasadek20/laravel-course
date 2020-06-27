<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    //
    use SoftDeletes;
    protected $fillable=['content','user_id'];
    // public function post(){
    //     return $this->belongsTo('App\Post');
    // }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function commentable(){
        return $this->morphTo();
    }
    public function tags(){
        return $this->morphToMany('App\Tag','taggable');
    }

    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::UPDATED_AT,'desc');
    }

    
    //hado dertom Commentair 7it sawbna observe fi App\Observers\CommentObserver o Liyinah m3a Had Mode
    // public static function boot(){
    //     parent::boot();

        // static::creating(function(Comment $comment){
        //     // Cache::forget("post-show-{$comment->post->id}");
        //     Cache::forget("post-show-{$comment->commentable->id}");
        //     // dd($comment->commentable->id);
        // });
        // static::addGlobalScope(new LatestScope);
    // }
}
