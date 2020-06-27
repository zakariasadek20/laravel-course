<?php

namespace App;

use App\Scopes\AdminShowDeleteScope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use SoftDeletes;

    //le champ li ghady persiste
    protected $fillable=['title','content','slug','active','user_id'];
    protected $hidden=['created_at','deleted_at','user_id'];
    // public function comments(){
    //     return $this->hasMany('App\Comment')->latest();
    // }
    public function comments(){
        return $this->morphMany('App\Comment','commentable')->latest();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // public function tags(){
    //     return $this->belongsToMany('App\Tag')->withTimestamps();
    // }
    public function tags(){
        return $this->morphToMany('App\Tag','taggable');
    }

    // public function image(){
    //     return $this->hasOne(Image::class);
    // }
    
    public function image(){
        return $this->morphOne('App\Image','imageable');
    }

    public function scopeMostCommented(Builder $builder){
        return $builder->withCount('comments')->orderBy('comments_count','desc');
    }
    public function scopePostWithUserCommentsTags(Builder $builder){
        return $builder->withCount('comments')->with(['user','tags']);
    }

    public static function boot()
    {
        static::addGlobalScope(new AdminShowDeleteScope);
        parent::boot();
        static::addGlobalScope(new LatestScope);


        //hado dertom Commentair 7it sawbna observe fi App\Observers\PostObserver o Liyinah m3a Had Mode
        // static::updating(function($post){
        //     Cache::forget("post-show-{$post->id}");
        // });
        // static::deleting(function(Post $post){
        //     // dd('deleting');
        //     $post->comments()->delete();
        // });
        // static::restoring(function(Post $post){
        //     $post->comments()->restore();
        // });



        // static::retrieved(function(Post $post){
        //     dd('retrived');
        // });
        // static::creating(function( Post $post){
        //     //before create
        //     dd('in creating');
        // });
        // static::created(function(Post $post){
        //     //after created
        //     dd('created');
        // });
        // static::updating(function(Post $post){
        //     //before update
        //     dd('updating');
        // });
        // static::updated(function(Post $post){
        //     //after update
        //     dd('updated');
        // });
        // static::saving(function(Post $post){
        //     //after save
        //     dd('saving');
        // });
        // static::saved(function(Post $post){
        //     //befor save
        //     dd('saved');
        // });
        // static::deleting(function(Post $post){
        //     //after delete
        //     dd('deleting');
        // });
        // static::deleted(function(Post $post){
        //     //befor delete
        //     dd('deleted');
        // });
    }
    

   
}
