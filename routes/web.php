<?php

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

Route::get('/login', function () {
    return view('login');
});

Route::get('/mlogin', function () {
    return view('mfitbit/mlogin');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/deviceManagement', function () {
    return view('deviceManagement');
});

Route::post('/getAccount', function () {
    return view('getAccount');
});

Route::post('/updateAccount', function () {
  return view('updateAccount');
});

Route::post('/updatePassword', function () {
  return view('updatePassword');
});
 //steps
Route::post('/getSteps', function () {
  return view('getSteps');
});

Route::post('/storeSteps', function () {
  return view('storeSteps');
});





/* FOR API */

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
