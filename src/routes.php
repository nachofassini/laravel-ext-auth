<?php
Route::group(['middleware' => 'web', 'namespace' => 'NachoFassini'], function () {
    //Login de usuario
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\ExtAuthController@getLogin']);
    Route::post('login', ['as' => 'auth.dologin', 'uses' => 'Auth\ExtAuthController@postLogin']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\ExtAuthController@getLogout']);
    //Agregar configuracion para permitir elegir si el sistema permitira alta de usuarios y recuperacion de pass
    if (true) {
        Route::post('password/email', function () { abort(403, 'Accion no permitida'); });
        Route::post('password/reset', function () { abort(403, 'Accion no permitida'); });
        Route::get('password/reset/{token?}', function () { abort(403, 'Accion no permitida'); });
        Route::get('register', function () { abort(403, 'Accion no permitida'); });
        Route::post('register', function () { abort(403, 'Accion no permitida'); });
    }
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
