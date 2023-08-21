<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Models\Supplier;
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
Route::prefix('admin')->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    //Danh muc san pham
    Route::prefix('category')->group(function(){
        Route::get('/list',[CategoryController::class, 'list'])->name('category.list');
        Route::post('/insert',[CategoryController::class, 'insert'])->name('category.insert');
        Route::post('/update',[CategoryController::class, 'update'])->name('category.update');
        Route::post('/delete',[CategoryController::class, 'delete'])->name('category.delete');
    });
    //Nha cung cap
    Route::prefix('supplier')->group(function(){
        Route::get('/list',[SupplierController::class, 'list'])->name('supplier.list');
        Route::post('/insert',[SupplierController::class, 'insert'])->name('supplier.insert');
        Route::post('/update',[SupplierController::class, 'update'])->name('supplier.update');
        Route::post('/delete',[SupplierController::class, 'delete'])->name('supplier.delete');
    });
});
