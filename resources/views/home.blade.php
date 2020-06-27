
 @extends('layouts.app')

 @section('content')
 <div class="container">
     <div class="row justify-content-center">
         <div class="col-md-8">
             <div class="card">
                 <div class="card-header">
                    <h1>{{__('messages.welcome')}}</h1>
                    <h1>@lang('messages.welcome')</h1>

                    <p>{{ __('messages.exemple_with_value',['name'=>'Sadek']) }}</p>
                    <p>@lang('messages.exemple_with_value',['name'=>'Sadek'])</p>

                    <p>{{trans_choice('messages.plural',0)}}</p>
                    <p>{{trans_choice('messages.plural',1)}}</p>
                    <p>{{trans_choice('messages.plural',20)}}</p> 

                    {{-- with json --}}
                    <h1>{{__('welcome')}}</h1>
                    <h1>{{__('exemple_with_value',['name'=>'Sadek'])}}</h1>
                    <p>{{trans_choice('plural',0)}}</p>
                    <p>{{trans_choice('plural',1)}}</p>
                    <p>{{trans_choice('plural',20)}}</p>
                    

                    @can('secret.page')
                     <p><a href="/secret">{{__('administration')}}</a></p>
                   @endcan
                  </div>
 
                 <div class="card-body">
                     @if (session('status'))
                         <div class="alert alert-success" role="alert">
                             {{ session('status') }}
                         </div>
                     @endif
 
                     You are logged in!
                 </div>
             </div>
         </div>
     </div>
 </div>
 @endsection
 