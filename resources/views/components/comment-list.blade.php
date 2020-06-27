@forelse ($comments as $comment)
           <div>
               <p>{{$comment->content}}</p>
               <p>
                   <x-updated :date="$comment->created_at" :name="$comment->user->name" :user-id="$comment->user->id">
                   </x-updated>
               </p>
               {{-- <p class="test-muted">Added : {{$comment->created_at->diffForHumans()}}</p> --}}
           </div>
           @empty
               <div>
                   {{-- <span class="badge badge-dark">no comments yet!</span> --}}
                   <x-badge type="secondary">{{__('no comments yet!')}}</x-badge>
               </div>
@endforelse