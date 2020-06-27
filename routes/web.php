<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/posts/{id}/{author}',function($myid,$author){
//     return $myid ." author : $author";
// });

Route::get('/posts/archive','PostController@archive')->name('posts.archive');
Route::get('/posts/all','PostController@all')->name('posts.all');

Route::patch('/posts/{id}/restore','PostController@restore');
Route::delete('/posts/{id}/forcedelete','PostController@forcedelete');

Route::get('/','HomeController@home')->name('home');
Route::get('/about','HomeController@about')->name('about');
//Route::resource('/posts','PostController');
 Route::resource('/posts','PostController');
    // ->except(['destroy']);
// Route::resource('/posts','PostController')
//     ->only(['index','show','create','store','edit','update']);

Route::resource('/clients','ClientController');


// Route::resource('/clients','ClientController')
// ->only(['create','store']);
// Route::get('/client/{id?}',function($id=1){
//     $clients=[
//         1=>['name'=>'Zakaria','prenom'=>'sadek'],
//         2=>['name'=>'taibe','prenom'=>'mehdi']
//     ];
//     return view('clients.show',[
//         'data'=>$clients[$id]
//         ]
//         );
// })->name('client');

// Route::get('/', function () {
//     return view('home');
// });

//  Route::view('/','home');

// Route::get('/about',function(){
// return view('about');
// });

// Route::view('/about','about');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/secret', 'HomeController@secret')
        ->name('secret')
        ->middleware('can:secret.page');
        
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/posts/tag/{id}','PostTagController@index')->name('posts.tag.index');

Route::resource('posts.comments','PostCommentController')->only(['store','show']);

Route::resource('users.comments','UserCommentController')->only(['store']);

Route::resource('users','UserController')->only(['show','edit','update']);

//Mailable
Route::get('/mailable',function(){
        $comment=App\Comment::find(12);
        return new App\Mail\CommentedPostMarkdown($comment);
});

