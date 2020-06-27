<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $NbrComments=(int)$this->command->ask('How many of comments you want to generate ?',100);
        $posts=App\Post::all();
        $users=App\User::all();
        if($posts->count()==0){
            $this->command->info('please create some posts');
            return;
        }
    //    factory(App\Comment::class,$NbrComments)->make()->each(function($comment) use ($posts,$users){
    //         $comment->post_id=$posts->random()->id;
    //         $comment->user_id=$users->random()->id;
    //         $comment->save();
    //     } );

        factory(App\Comment::class,$NbrComments)->make()->each(function($comment) use ($posts,$users){
            $comment->commentable_id = $posts->random()->id;
            $comment->commentable_type = 'App\Post';
            $comment->user_id = $users->random()->id;
            $comment->save();
        } );
    }
}
