<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::group(['prefix' => 'super_admin', 'middleware' => 'auth.super-admin'], function(){
    Route::get('', \App\Http\Livewire\SuperAdmin\DashboardView::class)->name('superadmin.home');

    Route::group(['prefix' => 'warehouse'], function() {
        Route::get('', \App\Http\Livewire\Feature\Warehouse\IndexView::class)
            ->middleware('log:GET')
            ->name('warehouse.index');
        Route::get('show/{warehouse_id}', \App\Http\Livewire\Feature\Warehouse\ShowView::class)
            ->middleware('log:GET')
            ->name('warehouse.show');
        Route::get('destroy/{warehouse_id}', \App\Http\Livewire\Feature\Warehouse\DestroyView::class)
            ->middleware('log:DELETE')
            ->name('warehouse.destroy');
        Route::get('edit/{warehouse_id}', \App\Http\Livewire\Feature\Warehouse\EditView::class)
            ->middleware('log:PUT')
            ->name('warehouse.edit');

        Route::group(['prefix' => 'new'], function() {
            Route::get('', \App\Http\Livewire\Feature\Warehouse\CreateView::class)
                ->middleware('log:POST')
                ->name('warehouse.create');
            Route::get('{warehouse_id}/storage', \App\Http\Livewire\Feature\Warehouse\CreateStorageView::class)
                ->middleware('log:POST')
                ->name('warehouse.create.storage');
            Route::get('{warehouse_id}/summary', \App\Http\Livewire\Feature\Warehouse\CreateSummaryView::class)
                ->middleware('log:GET')
                ->name('warehouse.create.summary');
        });
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function(){
    Route::get('', \App\Http\Livewire\Admin\DashboardView::class)->name('admin.home');
});

Route::group(['prefix' => 'employee', 'middleware' => 'auth.employee'], function(){
    Route::get('', \App\Http\Livewire\Employee\DashboardView::class)->name('employee.home');
});
