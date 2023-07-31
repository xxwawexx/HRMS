<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth', 'namespace' => 'Api', 'as' => 'api.'], function () {

    Route::post('login', 'AuthController@login')->name('auth.login');
    Route::post('register', 'AuthController@register')->name('auth.register');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout')->name('auth.logout');
    });

});

Route::group(['prefix' => 'users', 'namespace' => 'Api', 'as' => 'api.'], function () {

    Route::get('search', 'UserController@search')->name('users.search');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('me', 'UserController@me')->name('users.me');
        Route::patch('password', 'UserController@setMyPassword')->name('users.me.set.password');
        Route::patch('password/{user}', 'UserController@setPassword')->name('users.set.password');
    });

});

Route::group(['prefix' => 'employees', 'namespace' => 'Api', 'as' => 'api.'], function () {

    Route::group(['middleware' => 'auth:api'], function() {

        Route::get('me', 'EmployeeController@myProfile')->name('me.profile');
        Route::get('search', 'EmployeeController@search')->name('employees.search');
        Route::get('profile/{user}', 'EmployeeController@getProfile')->name('employees.get.profile');
        Route::post('store', 'EmployeeController@store')->name('employees.store');
        Route::post('profile_image/{user}', 'EmployeeController@uploadProfileImage')->name('employees.upload.profile_image');
        Route::patch('personal_details/{user}', 'EmployeeController@updatePersonalDetails')->name('employees.set.personal_details');
        Route::patch('emergency_contact/{id}', 'EmployeeController@updateEmergencyContact')->name('employees.set.emergency_contact');
        Route::patch('social/{id}', 'EmployeeController@updateSocial')->name('employees.set.social');
        Route::post('social/{user}', 'EmployeeController@addSocial')->name('employees.add.social');
        Route::patch('government_id/{id}', 'EmployeeController@updateGovID')->name('employees.set.gov_id');
        Route::post('government_id/{user}', 'EmployeeController@addGovID')->name('employees.add.gov_id');
        Route::post('emergency_contact/{user}', 'EmployeeController@addEmergencyContact')->name('employees.add.emergency_contact');
        Route::patch('status/{id}', 'EmployeeController@toggleEmployee')->name('employees.toggle.status');
    });

});

Route::group(['prefix' => 'payrolls', 'namespace' => 'Api', 'as' => 'api.'], function () {

    Route::group(['middleware' => 'auth:api'], function() {

        Route::get('all', 'PayrollController@getPayrolls')->name('employee.payrolls');
        Route::get('earnings/{user}', 'PayrollController@earnings')->name('employees.get.earnings');
        Route::post('earnings', 'PayrollController@storeEarning')->name('employees.store.earnings');
        Route::get('deductions/{user}', 'PayrollController@deductions')->name('employee.get.deductions');
        Route::post('deductions', 'PayrollController@storeDeduction')->name('employee.store.deductions');
        Route::post('payslip', 'PayrollController@storePayslip')->name('employee.store.payslip');
        Route::get('payslips/{user_id}', 'PayrollController@getPayslips')->name('employee.get.payslips');
        Route::get('payslip/{payslip_id}', 'PayrollController@getPayslip')->name('employee.get.payslip');
        Route::patch('payslip/status', 'PayrollController@togglePayslip')->name('employee.payslip.status');

    });

});

Route::group(['namespace' => 'Api', 'as' => 'api'], function (){

    Route::get('email/verify/{user}', 'AuthController@verify')->name('auth.verification.verify');
    Route::get('email/resend', 'AuthController@resend')->name('auth.verification.resend');

});
