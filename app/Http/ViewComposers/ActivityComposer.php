<?php
namespace App\Http\ViewComposers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer {
    public function compose(View $view){
        $mostCommented=Cache::remember('mostCommented',now()->addMinutes(10),function(){
            return Post::mostCommented()->take(5)->get();
        });

        $usersActive=Cache::remember('usersActive',now()->addMinutes(10),function(){
            return User::usersActive()->take(5)->get();
        });
        $usersActiveInLastMonth=Cache::remember('usersActiveInLastMonth',now()->addMinutes(10),function(){
            return User::usersActiveInLastMonth()->take(5)->get();
        });
        $view->with([
                'mostCommented'=>$mostCommented,
                'usersActive'=>$usersActive,
                'usersActiveInLastMonth'=>$usersActiveInLastMonth
        ]);
        
    }
}