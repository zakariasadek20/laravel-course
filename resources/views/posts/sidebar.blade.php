    <x-card :title="__('Most Commented')">
        @foreach ($mostCommented as $post)
                
        <li class="list-group-item">
            <a href="{{route('posts.show',['post'=>$post->id])}}">{{$post->title}}</a>
            <p>
                <span class="badge badge-success">{{trans_choice('comments plural',$post->comments_count)}}</span>
            </p>
        </li>
        @endforeach
    </x-card>
    <x-card 
        :title="__('Most Active')" 
        :text="__('Writers with most posts written')" 
        :items="collect($usersActive)->pluck('name')">
    </x-card>
    <x-card 
        :title="__('Most Active Last Month')" 
        :text="__('Users with most posts written in the month')" 
        :items="collect($usersActiveInLastMonth)->pluck('name')">
    </x-card>