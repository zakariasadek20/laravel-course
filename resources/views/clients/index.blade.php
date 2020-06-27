@extends('layouts.app')

@section('content')
<ul class="list-group">
    <h1>List of Client </h1>
    @forelse($clients as $client)
    <li class="list-group-item">
    <p>
        <h1><a href="{{route('clients.show',['client'=>$client->id])}}">{{$client->nom.' '.$client->prenom}}</a> </h1>
        <span> {{$client->email}} </span>
        <span>{{$client->tele}}</span>
        <a class="btn btn-warning" href="{{route('clients.edit',['client'=>$client->id])}}">edit</a>
        <form  class="form-inline" action="{{route('clients.destroy',['client'=>$client->id])}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger"  type="submit">Delete</button>
        </form>
    </p>
    </li>
        @empty
        <p>No Clients</p>
    @endforelse
@endsection






