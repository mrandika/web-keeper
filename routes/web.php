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

Route::get('error', function () {
    return view('layouts/error');
})->name('error');

Route::group(['middleware' => 'guest'], function() {
    Route::get('login', \App\Http\Livewire\Auth\LoginView::class)->name('auth.login');
    Route::get('register', \App\Http\Livewire\Auth\RegisterView::class)->name('auth.register');
    Route::get('reset_password', \App\Http\Livewire\Auth\ResetPasswordView::class)->name('auth.reset-password');
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', [\App\Http\Controllers\AuthBridgeController::class, 'divert'])->name('home');
});

Route::group(['prefix' => 'super_admin', 'middleware' => 'auth.super-admin'], function(){
    Route::get('', \App\Http\Livewire\Dashboard\DashboardPartialView::class)->name('superadmin.home');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function(){
    Route::get('', \App\Http\Livewire\Dashboard\DashboardPartialView::class)->name('admin.home');
});

Route::group(['prefix' => 'employee', 'middleware' => 'auth.employee'], function(){
    Route::get('', \App\Http\Livewire\Dashboard\DashboardPartialView::class)->name('employee.home');
});
