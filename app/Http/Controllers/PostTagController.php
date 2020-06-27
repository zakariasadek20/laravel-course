<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostTagController extends Controller
{
    
    //
    public function index($id){
        $tag=Tag::find($id);
            // ->with('posts');
        return view('posts.index',[
            'posts'=>$tag->posts()->postWithUserCommentsTags()->get()
            // 'posts'=>$tag->posts()->withCount('comments')->with(['user','tags'])->get()
            // ,'mostCommented'=>Cache::get('mostCommented'),
            // 'usersActive'=>Cache::get('usersActive'),
            // 'usersActiveInLastMonth'=>Cache::get('usersActiveInLastMonth'),
            // 'tab'=>'list'
        ]);
    }
}
