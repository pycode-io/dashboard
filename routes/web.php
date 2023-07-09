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
    return view('admin.auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//admin routes
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function(){

    Route::middleware('guest:admin')->group(function(){
        //login routes
        Route::get('login', 'AuthenticateController@create')->name('login');
        Route::Post('login', 'AuthenticateController@store')->name('login');
    });
    
    Route::middleware('admin')->group(function(){
        Route::get('/dashboard', 'Homecontroller@index')->name('dashboard');
        Route::get('logout', 'AuthenticateController@destroy')->name('logout');

        Route::get('/users', 'UsersController@index')->name('users.index');
        Route::get('/user/create', 'UsersController@create')->name('user.create');
        Route::post('/user/store', 'UsersController@store')->name('user.store');
        Route::get('/user/edit/{id}', 'UsersController@edit')->name('user.edit');
        Route::post('/user/edit/store', 'UsersController@update')->name('user.edit.store');

        Route::post('/users/{id}/delete', 'UsersController@deleteUser')->name('users.delete');
        Route::delete('/users/{id}', 'UsersController@destroy')->name('users.destroy');

        Route::get('/user/show/{id}', 'UsersController@show')->name('user.show');
        Route::get('/user/status/update', 'UsersController@updateStatus')->name('user.change.status');
        //Deleted users Opertation
        Route::get('/deletes/users', 'UsersController@deleted_users')->name('users.archive');
        Route::get('/users/restore/{id}', 'UsersController@restore')->name('users.restore');
        Route::get('/users/permanents/delete/{id}', 'UsersController@delete_permanent')->name('users.permanents_delete');

        //Admin Languages Routes
        Route::get('/languages', 'LanguageController@index')->name('languages.index');
        Route::get('/languages/search', 'LanguageController@index')->name('languages.search');
        Route::get('/language/create', 'LanguageController@create')->name('language.create');
        Route::post('/language/store', 'LanguageController@store')->name('language.store');
        Route::get('/language/edit/{id}', 'LanguageController@edit')->name('language.edit');
        Route::get('/language/delete/{id}', 'LanguageController@delete')->name('language.delete');


        Route::get('/employee/index', 'EmployeeController@index')->name('employee.index');
        Route::get('/employee/search', 'EmployeeController@index')->name('employee.search');
        Route::get('/employee/create', 'EmployeeController@create')->name('employee.create');
        Route::post('/employee/store', 'EmployeeController@store')->name('employee.store');
        Route::get('/employee/edit/{id}', 'EmployeeController@edit')->name('employee.edit');
        Route::get('/employee/delete/{id}', 'EmployeeController@delete')->name('employee.delete');
        Route::get('/employee/status/update', 'EmployeeController@updateStatus')->name('employee.change.status');

        //Talent Routes
        Route::get('/talents', 'TalentController@index')->name('talents.index');
        Route::get('/talents/search', 'TalentController@index')->name('talents.search');
        Route::get('/talents/view/{id}', 'TalentController@show_talents')->name('talents.view');
        Route::get('/talents/status/update', 'TalentController@updateStatus')->name('talents.change.status');
        Route::get('/talents/comments/{id}', 'TalentController@show_comments')->name('talents.comments');

        //Deleted Talent videos Opertation
        Route::get('/deletes/talents', 'TalentController@deleted_records')->name('talents.archive');
        Route::get('/talents/restore/{id}', 'TalentController@restore')->name('talents.restore');
        Route::get('/talents/permanents/delete/{id}', 'TalentController@delete_permanent')->name('talents.permanents_delete');


        //TalentHunt Subscriptions Routes
        Route::get('/talents/subscription', 'TalentHuntSubscriptions@index')->name('talents.subscriptions');
        Route::get('/talents/subscription/invoice/{id}', 'TalentHuntSubscriptions@invoice')->name('talents.subscriptions.invoice');
        Route::get('/talents/subscription/show/{id}', 'TalentHuntSubscriptions@showTalentSubscription')->name('talents.subscriptions.show');
        Route::get('/talents/subscription/search', 'TalentHuntSubscriptions@index')->name('talents.subscription.search');

        //Talent Subscriptions Plans Controllers
        Route::get('/talent/plan', 'TalentPlanController@index')->name('talents.plan.index');
        Route::get('/talent/plan/search', 'TalentPlanController@index')->name('talents.plan.search');
        Route::get('/talent/plan/create', 'TalentPlanController@create')->name('talent.plan.create');
        Route::post('/talent/plan/store', 'TalentPlanController@store')->name('talent.plan.store');
        Route::get('/talent/plan/edit/{id}', 'TalentPlanController@edit')->name('talent.plan.edit');
        Route::get('/talent/plan/delete/{id}', 'TalentPlanController@destroy')->name('talent.plan.delete');

        //Admin Banner Routes
        Route::get('/banners', 'BannerController@index')->name('banners.index');
        Route::get('/banners/search', 'BannerController@index')->name('banners.search');
        Route::get('/banner/create', 'BannerController@create')->name('banner.create');
        Route::post('/banner/store', 'BannerController@store')->name('banner.store');
        Route::get('/banner/edit/{id}', 'BannerController@edit')->name('banner.edit');
        Route::get('/banner/delete/{id}', 'BannerController@delete')->name('banner.delete');

        //Admin Movies Routes
        Route::get('/movies', 'MoviesController@index')->name('movies.index');
        Route::get('/movies/search', 'MoviesController@index')->name('search.movies');
        Route::get('/movies/between-dates', 'MoviesController@getDataBetweenDates')->name('movies.between-dates');
        Route::get('/movies/create', 'MoviesController@create')->name('movies.create');
        Route::post('/movies/store', 'MoviesController@store')->name('movies.store');
        Route::get('/movies/edit/{id}', 'MoviesController@edit')->name('movies.edit');
        Route::post('/movies/edit/store', 'MoviesController@update')->name('movies.edit.store');
        Route::get('/movies/view/{id}', 'MoviesController@show')->name('movies.show');
        Route::get('/movies/delete/{id}', 'MoviesController@delete')->name('movies.delete');
        Route::get('/movies/status/update', 'MoviesController@updateStatus')->name('movies.change.status');

        Route::get('/deletes/movies', 'MoviesController@deleted_movies')->name('movies.archive');
        Route::get('/movies/restore/{id}', 'MoviesController@restore')->name('movies.restore');
        Route::get('/movies/permanents/delete/{id}', 'MoviesController@permanents_delete')->name('movies.permanents_delete');
        //Admin Genre Routes
        Route::get('/genres', 'GenreController@index')->name('genres.index');
        Route::get('/genres/search', 'GenreController@index')->name('genres.search');
        Route::get('/genre/create', 'GenreController@create')->name('genre.create');
        Route::post('/genre/store', 'GenreController@store')->name('genre.store');
        Route::get('/genre/edit/{id}', 'GenreController@edit')->name('genre.edit');
        Route::get('/genre/delete/{id}', 'GenreController@delete')->name('genre.delete');

        //Admin Advertisement Routes
        Route::get('/advertisements', 'AdvertisementController@index')->name('advertisements.index');
        Route::get('/advertisements/search', 'AdvertisementController@index')->name('advertisements.search');
        Route::get('/advertisement/create', 'AdvertisementController@create')->name('advertisement.create');
        Route::post('/advertisement/store', 'AdvertisementController@store')->name('advertisement.store');
        Route::get('/advertisement/edit/{id}', 'AdvertisementController@edit')->name('advertisement.edit');
        Route::get('/advertisement/delete/{id}', 'AdvertisementController@delete')->name('advertisement.delete');

        //Orders Routes
        Route::get('/orders','OrdersController@showOrders')->name('orders.index');
        Route::get('/orders/details/{id}','OrdersController@showOrderDetails')->name('orders.details');

        //subscriptions Routes
        Route::get('/subscriptions','SubscriptionController@index')->name('subscriptions.index');
        Route::get('/subscriptions/search','SubscriptionController@index')->name('subscriptions.search');
        Route::get('/subscription/details/{id}','SubscriptionController@showOrderDetails')->name('subscription.details');

        //Deleted Subscription Opertation
        Route::get('/deletes/subscription', 'SubscriptionController@deleted_users')->name('subscription.archive');
        Route::get('/subscription/restore/{id}', 'SubscriptionController@restore')->name('subscription.restore');
        Route::get('/subscription/permanents/delete/{id}', 'SubscriptionController@delete_permanent')->name('subscription.permanents_delete');


        //Movies plans Routes
        Route::get('/movies/plans','MoviePlansController@index')->name('plans.index');
        Route::get('/movies/search','MoviePlansController@index')->name('plans.search');
        Route::get('/plans/create', 'MoviePlansController@create')->name('plans.create');
        Route::post('/plans/store', 'MoviePlansController@store')->name('plans.store');
        Route::get('/plans/edit/{id}', 'MoviePlansController@edit')->name('plans.edit');
        Route::get('/plans/delete/{id}', 'MoviePlansController@delete')->name('plans.delete');

    });
    
});

