<?php

use IBoot\Core\app\Http\Middleware\Authenticate;
use IBoot\Core\app\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::group(['namespace' => 'IBoot\Core\app\Http\Controllers', 'prefix'=>'admin'], function () {
        Route::group(['as' => 'auth', 'prefix' => 'login'], function () {
            Route::get('', 'LoginController@index')->name('.index')
                ->middleware(LoginMiddleware::class);
            Route::post('', 'LoginController@login')->name('.login');

            Route::get('/logout', 'LoginController@logout')->name('.logout');
        });

        Route::middleware(Authenticate::class)->group(function () {
            Route::resource('dashboard', 'HomeController')->only('index');

            Route::get('/run-command', 'PluginController@install')->name('install.package');

            Route::resource('/plugins', 'PluginController');
        });
    });
});
