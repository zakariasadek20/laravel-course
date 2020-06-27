<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment=$comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject="Comment Post for ".$this->comment->commentable->title;
        // dd(storage_path());
        return $this->subject($subject)
                    //V1
                    // ->attach(storage_path('app\public').'/'.$this->comment->user->image->path,[
                    //     'as'=>'profile_picture.jpeg',
                    //     'mime'=>'image/jpeg'
                    // ])
                    //V2
                    ->attachFromStorage($this->comment->user->image->path,'profile_picture')
                    //V3
                    // ->attachFromStorageDisk('public',$this->comment->user->image->path,'profile_pecture.jpeg')
                    
                    ->view('emails.posts.comment');
    }
}
