@auth
    <h5> {{__('Add comment')}} </h5>
    <form method="POST" action="{{ $action }}">
        @csrf
            <textarea class="form-control my-3" name="content" 
                        id="content" rows="3">
            </textarea>

            <x-errors my-class="warning"></x-errors>
            <button class="btn btn-block btn-primary" 
                    type="submit">{{__('Create!')}}</button>
    </form>
@else
    <a href="" class="btn btn-success btn-sm">
        {{__('Sign-in')}}
    </a> {{__('to post a comment !')}}
@endauth