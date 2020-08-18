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

Route::get('/', 'ShowRoot');
Route::any('login', 'Login');
Route::any('logout', 'Logout');
Route::any('configuration/load_paper_prices', 'Configuration\LoadPaperPrices');
Route::get('configuration/show_paper_prices', 'Configuration\ShowPaperPrices');
Route::any('configuration/set_dollar_price', 'Configuration\SetDollarPrice');
Route::any('configuration/show_dollar_prices', 'Configuration\ShowDollarPrices');
Route::any('configuration/add_client', 'Configuration\AddClient');
Route::any('configuration/add_client_popup', 'Configuration\AddClient@popup');
Route::any('configuration/show_clients', 'Configuration\ShowClients');
Route::any('budget/calculate/common/get_input', 'Budget\Calculate\Common\GetInput');
Route::any('budget/calculate/common/show_result', 'Budget\Calculate\Common\ShowResult');
Route::any('budget/calculate/common/show_job_paper', 'Budget\Calculate\Common\ShowResult');
Route::any('budget/view/common/listing', 'Budget\View\Common\Listing');
Route::any('budget/view/common/show_job/{common_job_id}', 'Budget\View\Common\ShowJob');
Route::any('budget/calculate/magazine/first_form', 'Budget\Calculate\Magazine\FirstForm');
Route::any('budget/calculate/magazine/config_pages', 'Budget\Calculate\Magazine\ConfigPages');
Route::any('budget/calculate/magazine/select_papers', 'Budget\Calculate\Magazine\SelectPapers');


//Route::any('budget/calculate/common/select_paper', 'Budget\Calculate\Common\SelectPaper');

//Route::any('budget/make', 'Budget\MakeBudget');
//Route::any('budget/make/fetch', 'Budget\MakeBudget@fetch')->name('budget/make.fetch');;
/************Tests****************
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
Route::get('test_controller/with_path', 'ShowPage');
Route::get('test_controller/{id}', 'ShowPage');
*/
