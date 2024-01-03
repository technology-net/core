<?php

use IBoot\Core\App\Http\Middleware\Authenticate;
use IBoot\Core\App\Http\Middleware\LoginMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    $prefix = config('core.route_prefix', 'admin');
    Route::group(['namespace' => 'IBoot\Core\App\Http\Controllers', 'prefix'=> $prefix], function () {
        Route::get('/', function () {
            return redirect()->route('auth.index');
        });
        Route::group(['as' => 'auth', 'prefix' => 'login'], function () {
            Route::get('', 'LoginController@index')->name('.index')
                ->middleware(LoginMiddleware::class);
            Route::post('', 'LoginController@login')->name('.login');

            Route::get('/logout', 'LoginController@logout')->name('.logout');
        });

        Route::middleware(Authenticate::class)->group(callback: function () {
            Route::resource('dashboard', 'HomeController')->only('index');

            Route::group(['as' => 'plugins.', 'prefix' => 'plugins'], function () {
                Route::resource('/', 'PluginController')->only('index');
                Route::get('/installation', 'PluginController@install')
                    ->name('install-packages');
                Route::get('/uninstallation', 'PluginController@uninstall')
                    ->name('uninstall-packages');
                Route::get('/publish', 'PluginController@publisPackage')->name('publish');
            });

            Route::group(['as' => 'media.', 'prefix' => 'media'], function () {
                Route::get('', 'MediaController@index')->name('index');
                Route::get('/{media}', 'MediaController@show')->name('show');
                Route::post('/files/upload', 'MediaController@uploadFiles')->name('upload-files');
                Route::post('/folders', 'MediaController@createFolder')->name('create-folder');
                Route::post('/downloadFile', 'MediaController@downloadFile')->name('downloadFile');
            });

            Route::group(['as' => 'settings.', 'prefix' => 'settings', 'namespace' => 'Settings'], function () {
                Route::resource('/users', 'UserController')->except(['show', 'store']);
                Route::post('users/delete-all', 'UserController@deleteAll')->name('users.deleteAll');
                Route::resource('/menus', 'MenuController')->except(['show', 'store']);
                Route::post('menus/delete-all', 'MenuController@deleteAll')->name('menus.deleteAll');
                Route::resource('system_settings', 'SystemSettingController')->except(['show', 'store', 'edit', 'update']);
                Route::post('system_settings/{id}/update', 'SystemSettingController@update')->name('system_settings.update');
            });

            Route::resource('roles', 'RoleController')->except(['show', 'store']);
            Route::post('roles/delete-all', 'RoleController@deleteAll')->name('roles.deleteAll');
            Route::resource('permissions', 'PermissionController')->except(['show', 'store']);
            Route::post('permissions/delete-all', 'PermissionController@deleteAll')->name('permissions.deleteAll');
        });
    });
});
