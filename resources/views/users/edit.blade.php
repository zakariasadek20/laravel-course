@extends('layouts.app')

@section('content')

{{-- form>.rou>.col-md-4>h5{Select a diffrence Avatar}+img.img-thumbnail+input:file.form-control-file^.col-md-8>.form-group>label+input#name.form-control --}}
<form action="{{route('users.update',['user'=>$user->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-4">
            <h5>__('Upload')</h5>
            <img src="{{$user->image ? $user->image->url() : null }}" alt="" class="img-thumbnail avatar">
            <input type="file" name="avatar" id="avatar" class="form-control-file">
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <label for="name">{{__('Name:')}}</label>
                <input type="text" name="name" id="name" value="{{old('name') ?? $user->name}}" class="form-control">
            </div>
            <div class="form-group">
                <label for="language">{{__('Language :')}}</label>
                <select name="locale" id="language" class="form-control mb-3">
                    @foreach (App\User::LOCALES as $locale => $label)
                    <option value="{{$locale}}" {{$user->locale === $locale ? 'selected' : ''}}>{{$label}}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-warning btn-block">{{__('Update!')}}</button>
        </div>
    </div>
</form>

@endsection