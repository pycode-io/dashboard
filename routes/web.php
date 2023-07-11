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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

//admin routes
Route::namespace('Admin')->prefix('admin')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        //login routes
        Route::get('login', 'AuthenticateController@create')->name('admin.login');
        Route::Post('login', 'AuthenticateController@store')->name('admin.login');
    });

    Route::middleware('admin')->group(function () {

        Route::get('/dashboard', 'Homecontroller@index')->name('admin.dashboard');
        Route::get('logout', 'AuthenticateController@destroy')->name('admin.logout');
        
        //User Routes 
        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::get('/users/create', 'UsersController@create')->name('users.create');
        Route::post('/users/store', 'UsersController@store')->name('users.store');
        Route::get('/users/edit/{id}', 'UsersController@edit')->name('users.edit');
        Route::post('/users/update/{id}', 'UsersController@update')->name('users.update');
        Route::get('/users/show/{id}', 'UsersController@show')->name('users.show');
        Route::get('/users/delete/{id}', 'UsersController@destroy')->name('users.delete');
        Route::get('/user/status/update', 'UsersController@updateStatus')->name('users.change.status');
       

         //Admin Banner Routes
         Route::get('/banners', 'BannerController@index')->name('banners.index');
         Route::get('/banners/search', 'BannerController@index')->name('banners.search');
         Route::get('/banner/create', 'BannerController@create')->name('banner.create');
         Route::post('/banner/store', 'BannerController@store')->name('banner.store');
         Route::get('/banner/edit/{id}', 'BannerController@edit')->name('banner.edit');
         Route::get('/banner/delete/{id}', 'BannerController@delete')->name('banner.delete');


        Route::get('/employee/index', 'EmployeeController@index')->name('employee.index');
        Route::get('/employee/search', 'EmployeeController@index')->name('employee.search');
        Route::get('/employee/create', 'EmployeeController@create')->name('employee.create');
        Route::post('/employee/store', 'EmployeeController@store')->name('employee.store');
        Route::get('/employee/edit/{id}', 'EmployeeController@edit')->name('employee.edit');
        Route::get('/employee/delete/{id}', 'EmployeeController@delete')->name('employee.delete');
        Route::get('/employee/status/update', 'EmployeeController@updateStatus')->name('employee.change.status');


    });
});
