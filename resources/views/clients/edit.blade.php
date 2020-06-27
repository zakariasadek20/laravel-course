@extends('layouts.app')
@section('content')
<h1>Edit post</h1>

<form method="POST" action="{{route('clients.update',['client'=>$client->id])}}">

    @csrf
    @method('PUT')
      @include('clients.forme')
      <button class="btn btn-block btn-warning" type="submit">Edit</button>
  </form>

@endsection