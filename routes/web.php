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

Route::namespace('App\Http\Controllers\Admin')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');

        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

        Route::get('password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
        Route::post('password/confirm', 'Auth\ConfirmPasswordController@confirm');

        Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');
        Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

        Route::middleware([
            'auth',
            ])
            ->group(function () {
                Route::get('home', 'HomeController@index')->name('home');

                Route::get('profile', 'ProfileSettings@getProfile')->name('profile');
                Route::put('profile', 'ProfileSettings@updateProfile')->name('update-profile');
                
                //Handle Image
                Route::get('image', 'ImageController@show')->name('show-image');
                Route::get('image/{path}', 'ImageController@getImage')->name('get-image');
                Route::post('image', 'ImageController@save')->name('save-image');
                Route::post('image/handle', 'ImageController@handle')->name('handle-image');
            });
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
