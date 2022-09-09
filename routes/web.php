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
    return redirect()->route('login');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'App\Http\Controllers\DashboardController@index'])->middleware('auth');

Route::controller(App\Http\Controllers\CompanyController::class)->group(function(){
    Route::get('companies', 'index')->name('companies')->middleware('auth');
    Route::get('company/create', 'create')->name('company.create')->middleware('auth');
    Route::post('company/store', 'store')->name('company.store')->middleware('auth');
    Route::get('company/edit/{id}', 'edit')->name('company.edit')->middleware('auth');
    Route::post('company/update', 'update')->name('company.update')->middleware('auth');
    Route::delete('company/{id}', 'destroy')->name('company.destroy')->middleware('auth');    
});

Route::controller(App\Http\Controllers\EmployeeController::class)->group(function(){
    Route::get('employees', 'index')->name('employees')->middleware('auth');  
    Route::get('employee/create', 'create')->name('employee.create')->middleware('auth');
    Route::post('employee/store', 'store')->name('employee.store')->middleware('auth');
    Route::get('employee/edit/{id}', 'edit')->name('employee.edit')->middleware('auth');
    Route::post('employee/update', 'update')->name('employee.update')->middleware('auth');
    Route::delete('employee/{id}', 'destroy')->name('employee.destroy')->middleware('auth');    
});