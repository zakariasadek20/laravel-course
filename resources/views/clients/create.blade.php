@extends('layouts.app')
@section('content')
<h1>New post</h1>

<form method="POST" action="{{route('clients.store')}}">

    @csrf
        @include('clients.forme')
      <button class="btn btn-block btn-primary" type="submit">add</button>
  </form>

 
  

@endsection