<?php

use Illuminate\Database\Seeder;

class PostsTableSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $NbrPosts=(int)$this->command->ask('How many of posts you want generate ?',10);

        $users=App\User::all();
        if($users->count()==0){
            $this->command->info('please create some users');
            return ;
        }
        factory(App\Post::class,$NbrPosts)->make()->each(function($post) use ($users){
            $post->user_id=$users->random()->id;
            $post->save();
        });
    }
}
