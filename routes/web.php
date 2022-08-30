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

/*Route::get('/', function () {
    return view('welcome');
});*/

//Route::get('/products', 'ProductController@getData')->name('products');

/*
Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/login', function () {
    if(Auth::check()){  return Redirect::to('/usuarios'); }
    return view('operations.login');
});

Route::get('/registro', function () {
    if(Auth::check()){  return Redirect::to('/usuarios'); }
    return view('operations.register');
});

Route::get('/', function () {
    if(Auth::check()){return Redirect::to('home');}
     return view('welcome');
 });



Route::get('/usuarios', 'UserController@getData')->name('users');

Route::post('/usersadd', 'UserController@store');

Route::post('/login', 'LoginController@login')->name('login');

Route::group(['middleware' => ['auth']], function() {

    Route::resource('usersactions', UserController::class);
    Route::put('/usersedit', 'UserController@update');
    Route::get('/usuarios', 'UserController@getData')->name('users');
    Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
});

