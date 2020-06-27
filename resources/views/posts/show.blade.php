@extends('layouts.app')


@section('content')

<div class="row">
    <div class="col-8">
        <h1>  {{$post->title}} </h1>

        @if($post->image)
        <img class="mt-3 img-fluid rounded" src="{{$post->image->url()}}" alt="">
            
        @endif

        <p> {{$post->content}} </p>
        <x-tags :tags="$post->tags"></x-tags>
        {{-- <em> {{$post->created_at->diffForHumans()}}</em> --}}
        <p>{{__('Active')}} :
            @if($post->active)
            {{__('Enabled')}}
            @else
            
            {{__('Disabled')}}
            @endif
           </p>

           
           <h2>{{__('Comments')}}</h2>

           {{-- @include('comments.form',['id'=>$post->id]) --}}
            <x-comment-form :action="route('posts.comments.store',['post'=>$post->id])"></x-comment-form>
           <hr>



           <x-comment-list :comments="$post->comments"></x-comment-list>
           {{-- @forelse ($post->comments as $comment)
           <div>
               <p>{{$comment->content}}</p>
               <p>
                   <x-updated :date="$comment->created_at" :name="$comment->user->name" :user-id="$comment->user->id">
                   </x-updated>
               </p>
               //<p class="test-muted">Added : {{$comment->created_at->diffForHumans()}}</p>
           </div>
           @empty
               <div>
                   //<span class="badge badge-dark">no comments yet!</span>
                   <x-badge type="secondary">no comments yet!</x-badge>
               </div>
           @endforelse --}}

    </div>
    <div class="col-4">
       @include('posts.sidebar')
    </div>
</div>

@endsection