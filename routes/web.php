<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

    Route::group(['prefix' => 'auth'], function()
    {
        Route::get('/login', 'AuthController@showLogin')->name('auth.login');
        Route::post('/login', 'AuthController@processLogin');
        Route::get('/logout', 'AuthController@processLogout')->name('auth.logout');
        Route::get('change-password', 'AuthController@showChangePassword')->name('auth.change-password');
        Route::post('change-password', 'AuthController@processChangePassword');
        Route::get('reset-password', 'AuthController@showResetPassword')->name('auth.reset-password');
        Route::post('reset-password', 'AuthController@processResetPassword');
    });
    
    Route::group(['middleware' => ['auth']], function ()
    {
        Route::get('/', 'AuthController@er')->name('index');

        Route::group(['prefix' => 'employees'], function()
        {
            Route::get('/', 'EmployeeController@index')->name('employee.index');
            Route::get('create', 'EmployeeController@create')->name('employee.create');            
            Route::post('/', 'EmployeeController@store')->name('employee.store');
            Route::get('my-profile', 'EmployeeController@myProfile')->name('employee.myProfile');
            Route::get('my-department', 'EmployeeController@myDepartment')->name('employee.myDepartment');
            Route::get('{id}/department', 'EmployeeController@department')->where('id', '[1-9][0-9]*')->name('employee.department');
            Route::get('{id}', 'EmployeeController@show')->where('id', '[1-9][0-9]*')->name('employee.show');
            Route::get('{id}/edit', 'EmployeeController@edit')->where('id', '[1-9][0-9]*')->name('employee.edit');
            Route::put('{id}', 'EmployeeController@update')->where('id', '[1-9][0-9]*')->name('employee.update');
            Route::delete('{id}', 'EmployeeController@destroy')->where('id', '[1-9][0-9]*')->name('employee.delete');
        });

        Route::group(['prefix' => 'leaves'], function()
        {
            Route::get('my-leave', 'LeaveController@myLeave')->name('leave.myLeave');
            Route::post('/', 'LeaveController@store')->name('leave.store');
            Route::get('create', 'LeaveController@create')->name('leave.create');
            Route::get('{id}', 'LeaveController@show')->where('id', '[1-9][0-9]*')->name('leave.show');
            Route::get('/request-pending', 'LeaveController@requestPending')->name('leave.request.pending');
            Route::put('{id}', 'LeaveController@update')->where('id', '[1-9][0-9]*')->name('leave.update');
        });
        
        Route::group(['prefix' => 'devices'], function()
        {
            Route::get('/', 'DeviceController@index')->name('device.index');
            Route::get('create', 'DeviceController@create')->name('device.create');
            Route::post('/', 'DeviceController@store')->name('device.store');
            Route::get('status', 'DeviceController@status')->name('device.status');
            Route::delete('{id}', 'DeviceController@destroy')->where('id', '[1-9][0-9]*')->name('device.delete');
            Route::get('{id}/assign', 'DeviceController@assignCreate')->where('id', '[1-9][0-9]*')->name('device.assign.create');
            Route::post('{id}/assign', 'DeviceController@assignStore')->where('id', '[1-9][0-9]*')->name('device.assign.store');
        });

        Route::group(['prefix' => 'device-types'], function()
        {
            Route::get('/', 'DeviceTypeController@index')->name('device-type.index');
            Route::get('/create', 'DeviceTypeController@create')->name('device-type.create');
            Route::post('/', 'DeviceTypeController@store')->name('device-type.store');
            Route::get('/{id}/edit', 'DeviceTypeController@edit')->where('id', '[1-9][0-9]*')->name('device-type.edit');
            Route::put('/{id}', 'DeviceTypeController@update')->where('id', '[1-9][0-9]*')->name('device-type.update');
        });

        Route::group(['prefix' => 'assign-devices'], function()
        {
            Route::get('/', 'DeviceTypeController@index')->name('assign-device.index');
            Route::get('/create', 'DeviceTypeController@create')->name('assign-device.create');
            Route::post('/', 'DeviceTypeController@store')->name('assign-device.store');
            Route::get('/{id}/edit', 'DeviceTypeController@edit')->where('id', '[1-9][0-9]*')->name('assign-device.edit');
            Route::put('/{id}', 'DeviceTypeController@update')->where('id', '[1-9][0-9]*')->name('assign-device.update');
            Route::delete('/{id}', 'DeviceTypeController@destroy')->where('id', '[1-9][0-9]*')->name('assign-device.delete');
        });

        Route::group(['prefix' => 'departments'], function()
        {
            Route::get('/', 'DepartmentController@index')->name('department.index');
            Route::get('/create', 'DepartmentController@create')->name('department.create');
            Route::post('/', 'DepartmentController@store')->name('department.store');
            Route::get('/{id}/edit', 'DepartmentController@edit')->where('id', '[1-9][0-9]*')->name('department.edit');
            Route::put('/{id}', 'DepartmentController@update')->where('id', '[1-9][0-9]*')->name('department.update');
            Route::delete('/{id}', 'DepartmentController@destroy')->where('id', '[1-9][0-9]*')->name('department.delete');
        });
        
        Route::group(['prefix' => 'positions'], function()
        {
            Route::get('/', 'PositionController@index')->name('position.index');
            Route::get('/create', 'PositionController@create')->name('position.create');
            Route::post('/', 'PositionController@store')->name('position.store');
            Route::get('/{id}/edit', 'PositionController@edit')->where('id', '[1-9][0-9]*')->name('position.edit');
            Route::put('/{id}', 'PositionController@update')->where('id', '[1-9][0-9]*')->name('position.update');
            Route::delete('/{id}', 'PositionController@destroy')->where('id', '[1-9][0-9]*')->name('position.delete');
        });

        Route::group(['prefix' => 'policies'], function()
        {
            Route::get('/', 'PolicyController@index')->name('policy.index');
            Route::get('/create', 'PolicyController@create')->name('policy.create');
            Route::post('/', 'PolicyController@store')->name('policy.store');
            Route::get('/{id}/edit', 'PolicyController@edit')->name('policy.edit');
            Route::put('/{id}', 'PolicyController@update')->where('id', '[1-9][0-9]*')->name('policy.update');
            Route::delete('/{id}', 'PolicyController@destroy')->where('id', '[1-9][0-9]*')->name('policy.delete');
        });

        Route::group(['prefix' => 'news'], function()
        {
            Route::get('/', 'NewsController@index')->name('news.index');
            Route::get('/create', 'NewsController@create')->name('news.create');
            Route::post('/', 'NewsController@store')->name('news.store');
            Route::get('/{id}/show', 'NewsController@show')->name('news.show');
            Route::get('/{id}/edit', 'NewsController@edit')->name('news.edit');
            Route::put('/{id}', 'NewsController@update')->where('id', '[1-9][0-9]*')->name('news.update');
            Route::delete('/{id}', 'NewsController@destroy')->where('id', '[1-9][0-9]*')->name('news.delete');
        });
    });

    Route::get('/test', 'DeviceController@test');

    Auth::routes();
