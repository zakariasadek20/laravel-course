@extends('layouts.app')


@section('content')
<div class="row">

        <div class="col-8">
        
        
            {{-- <nav class="nav nav-tabs nav-stacked my-5">
                <a class="nav-link @if($tab == 'list') active @endif" href="/posts">All</a>
                <a class="nav-link @if($tab == 'archive') active @endif" href="/posts/archive">Archive</a>
                <a class="nav-link @if($tab == 'all') active @endif" href="/posts/all">List</a>
            </nav> --}}
            <div class="my-3">
                {{-- <h4>{{$posts->count()}} Post(s)</h4> --}}
                <h4>{{trans_choice('Post Plural',$posts->count())}}</h4>
            </div>
            
            <ul class="list-group">
                <h1>{{__('List of Post')}} </h1>
                @forelse($posts as $post)
            
                <li class="list-group-item">
                    <p> 
                        @if($post->created_at->diffInHours()<1)
                        <x-badge type="success"> {{__('New')}} </x-badge>
                            {{-- @component('partials.badge')
                                New
                            @endcomponent --}}
                        @else
                            <x-badge type="dark"> {{__('Old')}}</x-badge>
                            {{-- @component('partials.badge',['type'=>'dark'])
                                  Old  
                            @endcomponent --}}
                        @endif
                    </p>

                    @if($post->image)
                    <img class="mt-3 img-fluid rounded" src="{{$post->image->url()}}" alt="">
                    {{-- <img class="mt-3 img-fluid rounded" src="{{Storage::url($post->image->path)}}" alt=""> --}}
                        
                    @endif

                    <h2>
                    <a  href="{{ route('posts.show',['post'=>$post->id])}}">
                        @if($post->trashed())
                        <del>
                            {{$post->title}}
                        </del>
                        @else
                        {{$post->title}}
                        @endif
                        </a>
                    </h2>


                    <x-tags :tags="$post->tags"></x-tags>

                    <p> {{$post->content}} </p>
                    <em> {{$post->created_at}}</em>
                    @if($post->comments_count)
                    <div>
                        {{-- <x-badge type="success"> {{$post->comments_count}} comments </x-badge> --}}
                        <x-badge type="success">{{trans_choice('comments plural',$post->comments_count)}} </x-badge>
                        {{-- <span class="badge badge-success">{{$post->comments_count}} comments</span> --}}
                    </div>
                    @else
                    <div>
                        <x-badge type="dark">{{__('no comments yet!')}}</x-badge>
                        {{-- <span class="badge badge-dark">no comments yet!</span> --}}
                    </div>
            
                    
                    @endif

                    <x-updated :date="$post->created_at" :name="$post->user->name" :user-id="$post->user->id"></x-updated>
                    <x-updated :date="$post->updated_at">{{__('Updated')}}</x-updated>
                        {{-- <p class="text-muted">
                            {{$post->updated_at->diffForHumans()}} , by {{$post->user->name}}
                        </p> --}}
                @auth
                
                    @can('update',$post)
                    <a class="btn btn-warning btn-sm" href="{{route('posts.edit',['post'=>$post->id])}}">{{__('Edit')}}</a>
                    @endcan
                    
                    @cannot('delete',$post)
                        <x-badge type="danger">{{__('You Cannot Delete this post')}}</x-badge>
                        {{-- <span class="badge badge-danger">You Cannot Delete this post</span> --}}
                    @endcannot
            
                    @if(!$post->deleted_at)
                        @can('delete',$post)
                            <form class="fm-inline" method="POST" action="{{route('posts.destroy',['post'=>$post->id])}}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit">{{__('Delete')}}</button>
                            </form>
                        @endcan
                    @else
                        @can('restore', $post)
                            
                        <form class="fm-inline" method="POST" 
                        action="{{url('/posts/'.$post->id.'/restore')}}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm" type="submit">{{__('Restore')}}</button>
                        </form>
                        @endcan
                        @can('forceDelete', $post)
                        <form class="fm-inline" method="POST" 
                        action="{{url('/posts/'.$post->id.'/forcedelete')}}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">{{__('Force Delete')}}</button>
                        </form>
                            
                        @endcan
            
                    @endif
                @endauth
                </li>
                @empty
                <span class="badge badge-danger"> {{__('No posts yet!')}}</span>
                @endforelse
            </ul>
        </div>
        <div class="col-4">

            @include('posts.sidebar')

            {{-- <x-card title="Most Commented">
                @foreach ($mostCommented as $post)
                        
                <li class="list-group-item">
                    <a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a>
                    <p>
                        <span class="badge badge-success">{{$post->comments_count}} comments</span>
                    </p>
                </li>
                @endforeach
            </x-card> --}}
            
            {{-- <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Most Commented</h4>
                </div>
                <ul class="list-group list-group-flush">
                    @foreach ($mostCommented as $post)
                        
                    <li class="list-group-item">
                        <a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a>
                        <p>
                            <span class="badge badge-success">{{$post->comments_count}} comments</span>
                        </p>
                    </li>
                    @endforeach
                </ul>
            </div> --}}

            {{-- <x-card 
            title="Most Users" 
            text="Most Users post writen" 
            :items="collect($usersActive)->pluck('name')"
            //:items="collect($usersActive)->pluck('name')"
             //:posts_count="$user->posts_count"
            >
            </x-card> --}}

        {{-- <div class="card mt-4"> --}}
        {{-- <div class="card-body">
                        <h4 class="card-title">Most Users</h4>
                        <p class="test-muted"> Most Users post writen </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($usersActive as $user)
                        <li class="list-group-item ">

                            <span class="badge badge-primary">
                                {{$user->posts_count}} Posts
                            </span>
                            {{$user->name}}
                        </li>
                        @endforeach
                    </ul>
                </div> --}}
                

                
                {{-- <x-card 
                    title="Most Users Active" 
                    text="Most Users Active in last month" 
                    //:items="collect($usersActiveInLastMonth)->pluck('name')"
                    :items="collect($usersActiveInLastMonth)->pluck('name')"
                    //:posts_count="$user->posts_count"
                    >
                    </x-card> --}}

                {{-- <div class="card mt-4">
                        <div class="card-body">
                            <h4 class="card-title">Most Users Active</h4>
                            <p class="test-muted"> Most Users Active in last month </p>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($usersActiveInLastMonth as $user)
                            <li class="list-group-item ">

                                <span class="badge badge-primary">
                                    {{$user->posts_count}} Posts
                                </span>
                                {{$user->name}}
                            </li>
                            @endforeach
                        </ul>
                </div> --}}

        </div>
</div>

@endsection