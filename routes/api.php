<?php

use Facade\FlareClient\Stacktrace\File;
use Faker\Provider\File as ProviderFile;
use Illuminate\Http\Request;
use Illuminate\Http\Testing\File as TestingFile;
use Illuminate\Support\Facades\File as FacadesFile;

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('storage/{filename}', function ($filename) {
        $path = storage_path('public/' . $filename);
        if (!TestingFile::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/users', function () {
        return App\User::all();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    // manager home
    Route::post('home/banner', 'HomeBannerController@store');
    Route::get('home/data', 'HomeBannerController@index');
    Route::put('home/update', 'HomeBannerController@update');
    Route::get('nick/detail-day', 'HomeBannerController@detailAddDay');
    Route::post('nick/create-add-day', 'HomeBannerController@createAddDay');
    Route::get('nick/view-detail-day/{id}', 'HomeBannerController@viewAddDay');

    Route::get('nick/detail-add-day', 'HomeBannerController@addDayDetail');
    //end manager nick

    // manager project
    Route::post('project/add', 'ProjectController@store');
    Route::get('project/data', 'ProjectController@index');
    Route::put('ctv/update', 'ProjectController@update');
    //end manager ctv

    // total day
    Route::post('total/add', 'TotalDayController@store');
    Route::get('total/data', 'TotalDayController@index');
    Route::put('total/update', 'TotalDayController@update');
    //end total day

    //home
    Route::get('home1/data', 'HomeController@staticsAdd');
    Route::get('home1/post', 'HomeController@searchPost');
    

    //end home

    //post
    Route::post('post/add', 'PostController@store');
    Route::get('post/data', 'PostController@index');
    Route::put('post/update/{id}', 'PostController@update');
    Route::put('post/delete/{id}', 'PostController@deletePost');
    // endPost

    // statistic
    Route::get('statistic/month', 'StatisticController@indexMonth');
    //end statistic





});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
