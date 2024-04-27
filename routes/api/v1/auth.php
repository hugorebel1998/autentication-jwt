<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {

    Route::post('/login', 'AuthController@inicioSesion')->name('login');

});
