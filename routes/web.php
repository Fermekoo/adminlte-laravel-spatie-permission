<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/engine/home', 'HomeController@index')->name('engine.home');

Route::group(['prefix'  => 'engine'], function(){

    Route::group(['prefix' => 'auth', 'namespace'=>'Auth'],function(){

        Route::get('/login', ['as' => 'login','uses' => 'LoginController@showLoginForm']);

        Route::post('/login', ['as' => '','uses' => 'LoginController@login']);

        Route::get('/logout', 'LoginController@logout' )->name('engine.logout');
    });

    Route::group(['prefix' => 'akun', 'namespace'=> 'Admin'], function(){

        Route::group(['prefix' => 'role'], function(){
            Route::group(['middleware' => ['permission:Read-Akun']], function(){
                Route::get('/','AclController@role')->name('engine.role');
                Route::get('/data','AclController@dataRole')->name('engine.role.data');
            });
            Route::group(['middleware' => ['permission:Read-Akun|Full-Manage-Akun']], function(){
                Route::post('/','AclController@createRole')->name('engine.role.create');
                Route::put('/','AclController@updateRole')->name('engine.role.update');
                Route::delete('/','AclController@deleteRole')->name('engine.role.delete');
                Route::get('/{id}/permission','AclController@givePermissions')->name('engine.role.permission');
                Route::put('/{id}/permission','AclController@assignPermission')->name('engine.role.setPermission');
            });
   
        });

        Route::group(['prefix' => 'permission', 'middleware' => ['permission:Read-Akun|Full-Manage-Akun']], function(){
                Route::get('/','AclController@permission')->name('engine.permission');
                Route::get('/data','AclController@dataPermission')->name('engine.permission.data');
                Route::post('/','AclController@createPermission')->name('engine.permission.create');
                Route::put('/','AclController@updatePermission')->name('engine.permission.update');
                Route::delete('/','AclController@deletePermission')->name('engine.permission.delete');
        });

        Route::group(['prefix' => 'user', 'middleware'  => ['permission:Read-Akun|Full-Manage-Akun']], function(){
                Route::get('/','AdminController@index')->name('engine.user');    
                Route::get('/data','AdminController@adminData')->name('engine.user.data');    
                Route::post('/','AdminController@create')->name('engine.user.create');    
                Route::put('/{id}','AdminController@update')->name('engine.user.update');    
                Route::delete('/{id}','AdminController@delete')->name('engine.user.delete');    
                Route::put('/{id}/password','AdminController@password')->name('engine.user.password');    
                Route::post('/{id}/role','AdminController@addRole')->name('engine.user.role');    
        });
    });
});