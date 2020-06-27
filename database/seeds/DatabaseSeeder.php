<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if($this->command->confirm('Do you want to refresh the database ?')){
            $this->command->call('migrate:refresh');
            $this->command->info('database was refreshed !');
        }
        $this->call([
            UsersTableSeeder::class,
            PostsTableSedeer::class,
            CommentsTableSeeder::class,
            TagTableSeeder::class,
            PostTagTableSeeder::class
        ]);

        // $users=factory(App\User::class,10)->create();

        // $posts=factory(App\Post::class,300)->make()->each(function($post) use ($users){
        //     $post->user_id=$users->random()->id;
        //     $post->save();
        // });
        // factory(App\Comment::class,3000)->make()->each(function($comment) use ($posts){
        //     $comment->post_id=$posts->random()->id;
        //     $comment->save();
        // } );

        

    }
}
