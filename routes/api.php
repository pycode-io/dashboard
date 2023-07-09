<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
require __DIR__.'/auth.php';

Route::post('register','Api\UserController@register');
Route::get('genres','Api\GenreController@index');
Route::get('advertisements','Api\AdvertisementController@index');

Route::post('/login', 'Api\LoginController@login')->middleware('guest');
Route::post('/verify-otp', 'Api\LoginController@verifyOTP')->middleware('guest');

Route::get('/latest-movies', 'Api\LatestMovieController@getLatestMovies');

Route::get('/languages', 'Api\LanguageController@languages');

Route::get('/similar-movies', 'Api\MoviesController@similarMovies');
Route::get('/popular-movies', 'Api\MoviesController@getPopularMovies');

Route::get('/search-movies', 'Api\MoviesController@searchMovies');

Route::get('/talent/getTalentByUser/{id}', 'Api\TalentHuntController@getTalentByUser');

Route::post('/feedback', 'Api\FeedbackController@addFeedback');

Route::get('/privacy-policy', 'Api\PrivacyPolicyController@index');

Route::get('/terms', 'Api\TermController@index');

Route::get('/subscription-history/{user}', 'Api\SubscriptionController@subscriptionHistories');

Route::post('/subscriptions', 'Api\SubscriptionController@subscribe');

Route::post('/talent/video/store', 'Api\TalentVideoController@storeVideo');
