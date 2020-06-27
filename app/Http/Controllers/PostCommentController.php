<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted as MyCommentPosted;
use App\Events\MyEvent;
use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResource;
use App\Jobs\NotifyUsersPostCommented;
use App\Mail\CommentedPostMarkdown;
use App\Mail\CommentPosted;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }
    public function show(Post $post){
        // return $post->with('user')->first();
        
        //return 1 object bi resource
        // return new CommentResource($post->comments->first());

        //return liste bi resource
        return CommentResource::collection($post->comments()->with('user')->get());
    }
    public function store(StoreComment $request,Post $post){
        $comment = $post->comments()
            ->create([
                'content'=> $request->content,
                'user_id'=> $request->user()->id
            ]);

            //event
            event(new MyCommentPosted($comment));
            event(new MyEvent($comment));

        // Mail::to($post->user->email)->send(new CommentPosted($comment));

        //with markdown
        // Mail::to($post->user->email)->send(new CommentedPostMarkdown($comment));

        //queue
        //V1
        // Mail::to($post->user->email)->queue(new CommentedPostMarkdown($comment));
        //V2
        // $delay=now()->addMinutes(1);
        // Mail::to($post->user->email)->later($delay,new CommentedPostMarkdown($comment));
        
        //custom job
        // NotifyUsersPostCommented::dispatch($comment);
        
        return redirect()->back()->withStatus('Comment Was Created!');
    }
}
