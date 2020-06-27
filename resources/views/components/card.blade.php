<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title">{{$title}}</h4>
        <p class="test-muted"> {{$text}} </p>
    </div>
        <ul class="list-group list-group-flush">
            @if(empty(trim($slot)))
                @foreach($items as $item)
                <li class="list-group-item ">
                    {{$item}}
                </li>
                @endforeach
            @else
               {{ $slot}}
            @endif

        </ul>
</div>
{{-- <span class="badge badge-primary">
                    {{$item->posts_count}} Posts
                </span> --}}
                {{-- <x-badge type="primary">
                    {{isset($item->posts_count) ? $item->posts_count.' posts' : $item->comments_count.' comments' }}
                </x-badge> --}}
{{-- {{$item}} --}}