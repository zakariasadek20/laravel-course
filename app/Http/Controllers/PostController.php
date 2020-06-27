<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Image;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show','archive','all']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ////////////////////////////
        // DB::connection()->enableQueryLog();
        // //Lasy Mode
        // $posts=Post::all();
        // foreach($posts as $post){
        //     foreach($post->comments as $comment){
        //         dd($comment);
        //     }
        // }
        // //Mode Earger
        // $posts=Post::with('comments')->get();
        // foreach($posts as $post){
        //     foreach($post->comments as $comment){
        //         dd($comment);
        //     }
        // }
        // ///////
        // //shows Queryies
        // dd(DB::getQueryLog());
        // ////////////////////////////

        // $posts=Post::withCount('comments')
        //     ->orderBy('updated_at','desc')->get();
            

        // dd(\App\Post::all());
            // cache
        // $mostCommented=Cache::remember('mostCommented',now()->addSeconds(10),function(){
        //     return Post::mostCommented()->take(5)->get();
        // });

        // $usersActive=Cache::remember('usersActive',now()->addSeconds(10),function(){
        //     return User::usersActive()->take(5)->get();
        // });
        // $usersActiveInLastMonth=Cache::remember('usersActiveInLastMonth',now()->addSeconds(10),function(){
        //     return User::usersActiveInLastMonth()->take(5)->get();
        // });
        return view('posts.index',[
            'posts'=>Post::postWithUserCommentsTags()
            // 'posts'=>Post::withCount('comments')->with(['user','tags'])
                            //  ->orderBy('updated_at','desc')
                             ->get()
            // 'mostCommented'=>Post::mostCommented()->take(5)->get(),
            // ,'mostCommented'=>$mostCommented,
            // // 'usersActive'=>User::usersActive()->take(5)->get(),
            // 'usersActive'=>$usersActive,
            // // 'usersActiveInLastMonth'=>User::usersActiveInLastMonth()->take(5)->get(),
            // 'usersActiveInLastMonth'=>$usersActiveInLastMonth,
            // 'tab'=>'list'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function archive()
    {
        return view('posts.index',[
            'posts'=>Post::onlyTrashed()
                    ->withCount('comments')
                    // ->orderBy('updated_at','desc')
                    ->get(),
            'tab'=>'archive'
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return view('posts.index',[
            'posts'=>Post::withTrashed()
                    ->withCount('comments')
                    // ->orderBy('updated_at','desc')
                    ->get(),
            'tab'=>'all'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(\App\Post::find($id));

        $postShow=Cache::remember("post-show-{$id}",60,function() use ($id){
            return Post::with(['comments','tags','comments.user'])->findOrFail($id);
        });

        return view('posts.show',[
            // 'post'=>Post::with('comments')->find($id)
            'post'=>$postShow
        ]);
    }

    public function create(){

        // $this->authorize('post.create');
        //  $this->authorize('create',Post::class);

        return view('posts.create');
    }
    public function edit($id){
        $post=Post::findOrFail($id);
        
        // Call Gate V1
        // if(Gate::denies('post.update',$post)){
        //     abort(403,"You can't edit this post");
        // }
        // Call Gate V2
        // $this->authorize('post.update',$post);
        $this->authorize('update',$post);

        return view('posts.edit',[
            'post'=>$post
        ]);
    }
    public function update(StorePost $request,$id){
        $post=Post::findOrFail($id);

        //Call Gate V1
        // if(Gate::denies('post.update',$post)){
        //     abort(403,"You can't edit this post");
        // }

        //Call Gate V2
        // $this->authorize('post.update',$post);
        $this->authorize('update',$post);

        if($request->hasFile('picture')){
            $path=$request->file('picture')->store('posts');
            if($post->image){
                Storage::delete($post->image->path);
                //V1
                $post->image->path=$path;
                $post->image->save();

            }
            else{
                $post->image()->save(Image::make(['path'=>$path]));
            }
          
        }

        $post->title=$request->input('title');
        $post->content=$request->input('content');
        $post->slug=Str::slug($post->title,'-');
        $active=$request->input('active');
        if($active==='true'){
            $active=1;
        }else{
            $active=0;
        }
        // $post->user_id=Auth::id();
        $post->save();
        $request->session()->flash('status','Post was updated');
        return redirect()->route('posts.index');
        
    }
    public function store(StorePost $request){


        // $hasFile=$request->hasFile('picture');
        // dump($hasFile);
        // if($hasFile){
        //     $file=$request->file('picture');
        //     dump($file);
        //     dump($file->getClientMimeType());
        //     // dump($file->getClientOriginalExtension());
        //     // dump($file->guessClientExtension());
        //     dump($file->guessExtension());
        //     dump($file->getClientOriginalName());
        //     dump($file->store('thumbnails'));

        //     // dump(Storage::putFile('thumbnails',$file));
        //     // dump(Storage::disk('local')->putFile('thumbnails',$file));

        //     $name1=$file->storeAs('thumbnails',random_int(1,100).'.'.$file->guessExtension());
        //     $name2=Storage::disk('local')->putFileAs('thumbnails',$file,random_int(1,100).'.'.$file->guessExtension());
        //     dump($name1);
        //     dump($name2);
        //     dump(Storage::url($name1));
        //     dump(Storage::disk('local')->url($name2));
        // }
        // die();
        // $validatedData=$request->validated();
        // $post=Post::create($validatedData);

        $data=$request->only(['title','content']);
        $data['slug']=Str::slug($data['title'],'-');
        $active=$request->input('active');
        if($active==='true'){
            $data['active']=1;
        }else{
            $data['active']=0;
        }
        // $data['user_id']=Auth::id();
        $data['user_id']=$request->user()->id;
        $post=Post::create($data);

        // $validatedData=$request->validate([
        //     'title'=>'bail|min:4|required|max:100',
        //     'content'=>'required'
        //     ,'active'=>'required'
        // ]);
        
        //Persistance
        // $title=$request->input('title');
        // $content=$request->input('content');
        // $active=$request->input('active');
        // $post=new Post();
        // $post->title=$title;
        // $post->content=$content;
        // $post->slug= Str::slug($title,'-');
        // if($active==='true'){
        // $post->active=1;
        // }else{
        //     $post->active=0;
        // }

        if($request->hasFile('picture')){
            $path=$request->file('picture')->store('posts');
            // $image=new Image(['path'=>$path]);
            // $post->image()->save($image);
            $post->image()->save(Image::make(['path'=>$path]));
        }

        $request->session()->flash('status','post was created');
        //$post->save();
        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, $id){
        $post=Post::findOrFail($id);
        // $post=Post::destroy([$id]);

        //Call Gate V1
        // if(Gate::denies('post.delete',$post)){
        //     abort(403,"You can't delete this post");
        // }
        //Call Gate V2
        // $this->authorize('post.delete',$post);
        $this->authorize('delete',$post);

        $post->delete();
        $request->session()->flash('status','Post was Deleted');
        return redirect()->route('posts.index');
    }
    public function restore($id){
        // dd($id);
        // $post=Post::onlyTrashed()->find($id);
        $post=Post::onlyTrashed()->where('id',$id)->first();
        $this->authorize('restore',$post);
        $post->restore();
        // $post->comments()->restore();
        // Post::onlyTrashed()->
        // with('comments')
        // ->find($id)->restore();
        return redirect()->back();
    }
    public function forcedelete($id){
    
        $post=Post::onlyTrashed()->where('id',$id)->first();
        $this->authorize('forceDelete',$post);
        $post->forcedelete();
        return redirect()->back();
        
    }



}
