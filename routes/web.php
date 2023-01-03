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
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function(){
    Route::get('', \App\Http\Livewire\Admin\DashboardView::class)->name('admin.home');
});

Route::group(['prefix' => 'employee', 'middleware' => 'auth.employee'], function(){
    Route::get('', \App\Http\Livewire\Employee\DashboardView::class)->name('employee.home');
});

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

Route::group(['prefix' => 'employee'], function () {
    Route::get('', \App\Http\Livewire\Feature\Employee\IndexView::class)
        ->middleware('log:GET')
        ->name('employee.index');
    Route::get('show/{employee_id}', \App\Http\Livewire\Feature\Employee\ShowView::class)
        ->middleware('log:GET')
        ->name('employee.show');
    Route::get('destroy/{employee_id}', \App\Http\Livewire\Feature\Employee\DestroyView::class)
        ->middleware('log:DELETE')
        ->name('employee.destroy');
    Route::get('edit/{employee_id}', \App\Http\Livewire\Feature\Employee\EditView::class)
        ->middleware('log:PUT')
        ->name('employee.edit');
    Route::get('new', \App\Http\Livewire\Feature\Employee\CreateView::class)
        ->middleware('log:POST')
        ->name('employee.create');
});

Route::group(['prefix' => 'item'], function () {
    Route::get('', \App\Http\Livewire\Feature\Item\IndexView::class)
        ->middleware('log:GET')
        ->name('item.index');
    Route::get('show/{item_id}', \App\Http\Livewire\Feature\Item\ShowView::class)
        ->middleware('log:GET')
        ->name('item.show');
    Route::get('destroy/{item_id}', \App\Http\Livewire\Feature\Item\DestroyView::class)
        ->middleware('log:DELETE')
        ->name('item.destroy');
    Route::get('edit/{item_id}', \App\Http\Livewire\Feature\Item\EditView::class)
        ->middleware('log:PUT')
        ->name('item.edit');
    Route::get('new', \App\Http\Livewire\Feature\Item\CreateView::class)
        ->middleware('log:POST')
        ->name('item.create');

    Route::group(['prefix' => 'location'], function () {
        Route::get('new/{item_id}', \App\Http\Livewire\Feature\Item\CreateLocationView::class)
            ->middleware('log:POST')
            ->name('item.location.create');
        Route::get('edit/{location_id}', \App\Http\Livewire\Feature\Item\EditLocationView::class)
            ->middleware('log:PUT')
            ->name('item.location.edit');
        Route::get('destroy/{location_id}', \App\Http\Livewire\Feature\Item\EditLocationView::class)
            ->middleware('log:DELETE')
            ->name('item.location.destroy');
    });
});

Route::group(['prefix' => 'transaction'], function () {
    Route::get('debit', \App\Http\Livewire\Feature\Transaction\DebitView::class)
        ->middleware('log:GET')
        ->name('transaction.debit');
    Route::get('credit', \App\Http\Livewire\Feature\Transaction\CreditView::class)
        ->middleware('log:GET')
        ->name('transaction.credit');
    Route::get('index', \App\Http\Livewire\Feature\Transaction\TransactionView::class)
        ->middleware('log:GET')
        ->name('transaction.index');
    Route::get('data', \App\Http\Livewire\Feature\Transaction\TransactionSelectionView::class)
        ->middleware('log:GET')
        ->name('transaction.data');
    Route::get('print/{date}', \App\Http\Livewire\Feature\Transaction\TransactionPrintArea::class)
        ->middleware('log:GET')
        ->name('transaction.print');
    Route::get('show/{transaction_id}', \App\Http\Livewire\Feature\Transaction\TransactionDetailView::class)
        ->middleware('log:GET')
        ->name('transaction.show');
});
