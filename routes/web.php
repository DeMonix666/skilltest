<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;

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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('users', '\App\Http\Controllers\UsersController');

Route::get('/', function () {
    return view('home');
});

Route::get('company/data', '\App\Http\Controllers\CompanyDataController@index');
Route::get('company/list', '\App\Http\Controllers\CompanyController@list');
Route::resource('company','\App\Http\Controllers\CompanyController');

Route::get('employee/list', '\App\Http\Controllers\EmployeeController@list');
Route::resource('employee','\App\Http\Controllers\EmployeeController');

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});