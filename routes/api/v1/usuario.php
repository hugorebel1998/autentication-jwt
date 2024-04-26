<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'usuarios', 'namespace' => 'Usuario'], function () {

    Route::get('/', 'UsuarioController@listar')->name('listar');
    Route::get('/{usuario_id}', 'UsuarioController@listar')->name('listar');
    Route::post('/', 'UsuarioController@crear')->name('crear');
    Route::put('/{usuario_id}', 'UsuarioController@actualizar')->name('actualizar');
    Route::delete('/{usuario_id}', 'UsuarioController@eliminar')->name('eliminar');
    Route::get('/restablecer/{usuario_id}', 'UsuarioController@restablecer')->name('restablecer');
});
