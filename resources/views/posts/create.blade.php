@extends('layouts.app')

@section('content')
<h1>{{__('New post')}}</h1>
<form method="POST" action="{{route('posts.store')}}" enctype="multipart/form-data">
    @csrf

        @include('posts.form')

        <button class="btn btn-block btn-primary" type="submit">{{__('Add Post')}}</button>
</form>

@endsection