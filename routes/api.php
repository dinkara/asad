<?php

use Illuminate\Http\Request;

//Default auth routes
Route::post('login', 'Auth\AuthController@login')->name('auth.login');
Route::post('auth/facebook', 'Auth\AuthController@facebookAuth')->name('auth.facebookAuth');
Route::post('auth/google', 'Auth\AuthController@googleAuth')->name('auth.googleAuth');
Route::post('register', 'Auth\AuthController@register')->name('auth.register');
Route::post('forgot/password', 'Auth\ForgotPasswordController@forgot')->name('auth.forgot');
Route::get('email/confirmation/{confirmation_code}', 'Auth\AuthController@confirmEmail')->name('auth.confirmEmail');
Route::post('password/reset', 'Auth\ForgotPasswordController@resetPassword')->name('auth.resetPassword');


Route::middleware(['dinkoapi.auth', 'user.check.status'])->group(function (){
    Route::get('token/refresh', 'Auth\AuthController@getToken')->name('auth.getToken');
    Route::post('logout', 'Auth\AuthController@logout')->name('auth.logout');
    
    /*===================== SrkController route section =====================*/
    Route::group(['prefix' => 'srks'], function(){
        
    });   

    Route::apiResource('srks', 'SrkController', [
        'parameters' => [
            'srks' => 'id'
        ],
        'only' => [
            'index','show','store','update','destroy'
        ]
    ]);
    /* End SrkController route section */
    
    /*===================== UserController route section =====================*/
    Route::group(['prefix' => 'users'], function(){
                
        Route::get('me', 'UserController@me')->name('users.me');
        
        Route::post('me', 'UserController@update')->name('users.update');

    });   

    Route::apiResource('users', 'UserController', [
        'parameters' => [
            'users' => 'id'
        ],
        'only' => [
            
        ]
    ]);
    /* End UserController route section */


});

