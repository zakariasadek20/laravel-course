<div>
    @if($errors->any())
<ul class="alert alert-{{$myClass}}"> 
    @foreach($errors->all() as $error)
    <li>
        {{$error}}
    </li>
    @endforeach
</ul>
@endif
</div>