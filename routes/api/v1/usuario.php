<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'usuarios', 'namespace' => 'Usuario'], function () {

    Route::get('/', 'UsuarioController@listar')->name('listar')->middleware('mainAuth');
    Route::get('/{usuario_id}', 'UsuarioController@listar')->name('listar')->middleware('mainAuth');
    Route::post('/', 'UsuarioController@crear')->name('crear')->middleware('mainAuth');
    Route::put('/{usuario_id}', 'UsuarioController@actualizar')->name('actualizar')->middleware('mainAuth');
    Route::delete('/{usuario_id}', 'UsuarioController@eliminar')->name('eliminar')->middleware('mainAuth');
    Route::get('/restablecer/{usuario_id}', 'UsuarioController@restablecer')->name('restablecer')->middleware('mainAuth');
});
