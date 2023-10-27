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

            Route::group(['as' => 'plugins.', 'prefix' => 'plugins'], function () {
                Route::resource('/', 'PluginController')->only('index');
                Route::get('/installation', 'PluginController@install')
                    ->name('install-packages');
                Route::get('/uninstallation', 'PluginController@uninstall')
                    ->name('uninstall-packages');
            });


            Route::group(['as' => 'settings.', 'prefix' => 'settings', 'namespace' => 'Settings'], function () {
                Route::resource('users', 'UserController')->except(['show']);

                Route::resource('/menus', 'MenuController')->only('index');
                Route::resource('system_settings', 'SystemSettingController')->except(['show', 'store', 'edit']);
                Route::post('system_settings/{id}/editable', 'SystemSettingController@editable')->name('system_settings.editable');
            });
        });
    });
});
