<?php
Route::group(['middleware' => 'web', 'namespace' => 'NachoFassini'], function () {
    //Login de usuario
    Route::get('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\ExtAuthController@getLogin']);
    Route::post('auth/login', ['as' => 'auth.dologin', 'uses' => 'Auth\ExtAuthController@postLogin']);
    Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\ExtAuthController@getLogout']);
    Route::get('auth/profile', ['as' => 'auth.profile', 'uses' => 'Auth\ExtAuthController@show' ]);
    Route::post('auth/update', ['as' => 'auth.update', 'uses' => 'Auth\ExtAuthController@update' ]);
    Route::get('auth/edit', ['as' => 'auth.edit', 'uses' => 'Auth\ExtAuthController@edit' ]);
    Route::get('auth/edit/password', ['as' => 'auth.edit-pass', 'uses' => 'Auth\ExtAuthController@editPassword' ]);
    Route::post('auth/update/password', ['as' => 'auth.update-password', 'uses' => 'Auth\ExtAuthController@updatePassword' ]);

    //Administracion de usuarios
    Route::get('auth/users/users_por_criterio', ['as' => 'auth.users_por_criterio', 'uses' => 'Auth\AdminUsuariosController@usersPorCriterio' ]);
    Route::get('auth/users/credenciales/{id}', ['as' => 'auth.users.credenciales.edit', 'uses' => 'Auth\AdminUsuariosController@editCredenciales' ]);
    Route::put('auth/users/credenciales/{id}', ['as' => 'auth.users.credenciales.update', 'uses' => 'Auth\AdminUsuariosController@updateCredenciales' ]);
    Route::resource('auth/users', 'Auth\AdminUsuariosController', ['except' => 'destroy']);
});
