<?php
Route::group(['middleware' => 'web', 'namespace' => 'NachoFassini\Auth'], function () {
    Route::group(['as' => 'auth.'], function () {
        //Login de usuario
        Route::get('login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
        Route::post('login', ['as' => 'dologin', 'uses' => 'LoginController@login']);
        Route::group(['middleware' => 'auth'], function () {
            //Logout
            Route::post('logout', ['as' => 'logout', 'uses' => 'LoginController@logout']);
            //Perfil del usuario
            Route::get('auth/profile', ['as' => 'profile', 'uses' => 'ExtAuthController@show']);
            Route::get('auth/edit', ['as' => 'edit', 'uses' => 'ExtAuthController@edit']);
            Route::post('auth/update', ['as' => 'update', 'uses' => 'ExtAuthController@update']);
            Route::get('auth/edit/password', ['as' => 'edit-pass', 'uses' => 'ExtAuthController@editPassword']);
            Route::post('auth/update/password', ['as' => 'update-password', 'uses' => 'ExtAuthController@updatePassword']);
            //Administracion de usaurios
            Route::get('auth/users/por-criterio', ['as' => 'users.por_criterio', 'uses' => 'UsersController@usersPorCriterio']);
            Route::get('auth/users/credenciales/{id}', ['as' => 'users.credenciales.edit', 'uses' => 'UsersController@editCredenciales']);
            Route::put('auth/users/credenciales/{id}', ['as' => 'users.credenciales.update', 'uses' => 'UsersController@updateCredenciales']);
            Route::resource('auth/users', 'UsersController', ['except' => 'destroy']);
        });
    });

    if (config('laravel-ext-auth.reset_passwords', false)) {
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm');
        Route::post('password/reset', 'ResetPasswordController@reset');
    };

    if (config('laravel-ext-auth.register', false)) {
        Route::get('register', 'RegisterController@showRegistrationForm');
        Route::post('register', 'RegisterController@register');
    }
});
