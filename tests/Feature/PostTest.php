<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Post;

class PostTest extends TestCase
{
    use RefreshDatabase;
    
    public function testSavePost()
    {
        $post=new Post();
        $post->title="myTitle";
        $post->content='Content';
        $post->slug=Str::slug($post->title,'-');
        $post->active=false;
        $post->save();
        $this->assertDatabaseHas('posts',['title'=>'myTitle']);
    }
    public function testPostsStoreValid(){
        $data=[
            'title'=>'test our post store',
            'slug'=>Str::slug('test our post store','-'),
            'content'=>'Content stor',
            'active'=>false
        ];
        $this->post('/posts',$data)
        ->assertStatus(302)
        ->assertSessionHas('status');
        $this->assertEquals(session('status'),'post was created');

    }
    public function testPostStoreFail(){

        $data=[
            'title'=>'',
            'content'=>'',
            'slug'=>'',
            'active'=>''
        ];
        $this->post('/posts',$data)
        ->assertStatus(302)
        ->assertSessionHas('errors');
        $messages=session('errors')->getMessages();
        $this->assertEquals($messages['title'][0],'The title field is required.');
        // $this->assertEquals($messages['title'][1],'The title must be at least 4 characters.');
        $this->assertEquals($messages['content'][0],'The content field is required.');
        $this->assertEquals($messages['active'][0],'The active field is required.');
    }
    
    public function testPostUpdate()
    {
        $post=new Post();
        $post->title='second myTitle testUpdate';
        $post->content='Content';
        $post->slug=Str::slug($post->title,'-');
        $post->active=true;
        $post->save();
        $this->assertDatabaseHas('posts',$post->toArray());
        $data=[
            'title'=>'second myTitle testUpdate updated',
            'content'=>'Content updated',
            'slug'=>Str::slug('second myTitle testUpdate updated','-'),
            'active'=>false
        ];
        // $post->title='second myTitle testUpdate updated';
        // $post->content='Content updated';
        // $post->slug=Str::slug($post->title,'-');
        // $post->active=false;
        $this->put("posts/{$post->id}",$data)
         ->assertStatus(302)
         ->assertSessionHas('status','Post was updated');
         $this->assertDatabaseHas('posts',[
            'title'=>$data['title']
        ]);
        $this->assertDatabaseMissing('posts',[
            'title' => $post->title
        ]);

    }
    public function testPostDelete(){
        $post=new Post();
        $post->title='second myTitle testUpdate';
        $post->content='Content';
        $post->slug=Str::slug($post->title,'-');
        $post->active=true;
        $post->save();
        $this->assertDatabaseHas('posts',$post->toArray());

        $this->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status','Post was Deleted');


        $this->assertDatabaseMissing('posts',$post->toArray());

    }
}
