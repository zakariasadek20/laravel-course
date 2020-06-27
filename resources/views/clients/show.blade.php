@extends('layouts.app')
@section('content')
<h1>Name : {{$client->nom}}</h1>
<h1>Prenom : {{$client->prenom}}</h1>
<h1>Email : {{$client->email}}</h1>
<h1>Prenom : {{$client->tele}}</h1>

@endsection