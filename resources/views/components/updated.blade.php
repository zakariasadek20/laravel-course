<div class="text-muted">
    
   {{ empty(trim($slot)) ? __('Added') : $slot}} {{ $date }} 
   {!! isset($name) ? ','. __('by').' <a class="badge badge-primary"  href='.route('users.show',['user'=>$userId]) .'>'.$name.'</a>' : null !!}
     {{-- @isset($name)
          {{', by '.$name}}
     @endisset --}}
</div>
{{-- <a href="{{route('users.show',['user'=>$userId])}}" class="badge badge-primary"> --}}
</a>