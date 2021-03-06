<?php

namespace App\Listeners;

use App\Events\MyEvent;
use App\Jobs\NotifyUsersPostCommented;
use App\Mail\CommentedPostMarkdown;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class MyListner
{
    

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MyEvent $event)
    {
        Mail::to($event->comment->commentable->user->email)->queue(new CommentedPostMarkdown($event->comment));
        NotifyUsersPostCommented::dispatch($event->comment);
    }
}
