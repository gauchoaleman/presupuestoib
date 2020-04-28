<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/hello', '/hello_world');

Route::get('/hello_world', function () {
    return "Hello world";
});

Route::view('/hello_guy', 'hello_guy', ['name' => 'Taylor']);

Route::get('user/{id}', function ($id) {
    return 'User '.$id;
});

Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
    return $postId." ".$commentId;
});

Route::get('user_name/{name?}', function ($name = 'John') {
    return $name;
});

Route::get('user/{id}/profile', function ($id) {
    //
    $url = route('profile', ['id' => $id]);
    echo $url;
})->name('profile');

Route::get('test_controller', 'ShowPage');
