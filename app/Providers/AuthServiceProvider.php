<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Post'=>'App\Policies\PostPolicy',
        'App\User'=>'App\Policies\UserPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('secret.page',function($user){
            return $user->is_admin;
        });
        
        // //define Gate
        // Gate::define("post.update",function($user,$post){
        //     return $user->id === $post->user_id;
        // });

        // Gate::define("post.delete",function($user,$post){
        //     return $user->id === $post->user_id;
        // });
        // //
        Gate::before(function($user, $ability){
            if($user->is_admin && in_array($ability, ["update","delete","restore","create","forceDelete"])){
                return true;
            }
        });

        //Gate With Policy
        //  V1
        // Gate::define('post.update','App\Policies\PostPolicy@update');
        // GAte::define('post.delete','App\Policies\PostPolicy@delete');
        // V2
        // Gate::resource('post','App\Policies\PostPolicy');
        
    }
}
