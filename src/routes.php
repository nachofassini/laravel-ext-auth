<?php
Route::group(['middleware' => 'web', 'namespace' => 'NachoFassini\Auth'], function () {
    //Login de usuario
    Route::get('login', ['as' => 'auth.login', 'uses' => 'ExtAuthController@getLogin']);
    Route::post('login', ['as' => 'auth.dologin', 'uses' => 'ExtAuthController@postLogin']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'ExtAuthController@getLogout']);
    //Agregar configuracion para permitir elegir si el sistema permitira alta de usuarios y recuperacion de pass
    if (true) {
        Route::post('password/email', function () { abort(403, 'Accion no permitida'); });
        Route::post('password/reset', function () { abort(403, 'Accion no permitida'); });
        Route::get('password/reset/{token?}', function () { abort(403, 'Accion no permitida'); });
        Route::get('register', function () { abort(403, 'Accion no permitida'); });
        Route::post('register', function () { abort(403, 'Accion no permitida'); });
    }
    Route::get('auth/profile', ['as' => 'auth.profile', 'uses' => 'ExtAuthController@show' ]);
    Route::post('auth/update', ['as' => 'auth.update', 'uses' => 'ExtAuthController@update' ]);
    Route::get('auth/edit', ['as' => 'auth.edit', 'uses' => 'ExtAuthController@edit' ]);
    Route::get('auth/edit/password', ['as' => 'auth.edit-pass', 'uses' => 'ExtAuthController@editPassword' ]);
    Route::post('auth/update/password', ['as' => 'auth.update-password', 'uses' => 'ExtAuthController@updatePassword' ]);

    //Administracion de usuarios
    Route::get('auth/users/por-criterio', ['as' => 'auth.users.por_criterio', 'uses' => 'AdminUsuariosController@usersPorCriterio' ]);
    Route::get('auth/users/credenciales/{id}', ['as' => 'auth.users.credenciales.edit', 'uses' => 'AdminUsuariosController@editCredenciales' ]);
    Route::put('auth/users/credenciales/{id}', ['as' => 'auth.users.credenciales.update', 'uses' => 'AdminUsuariosController@updateCredenciales' ]);
    Route::resource('auth/users', 'AdminUsuariosController', ['except' => 'destroy']);
});
