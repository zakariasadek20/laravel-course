<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(Request $request,User $user){
        $user->comments()
        ->create([
            'content'=>$request->content,
            'user_id'=>$request->user()->id
            ]);
        return redirect()->back()->withStatus('Comment Was Created!');
    }
}
