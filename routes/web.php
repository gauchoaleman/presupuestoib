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

Route::post('/', function () {
  if( isset($_SESSION["logged_in"]))
    return view('home_page');
  else
    return view('login_form');
});

Route::post('/login', function () {
  if( isset($_SESSION["logged_in"]))
    return view('home_page');
  else
    return view('login');
});

?>
