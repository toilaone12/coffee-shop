<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SlideController;
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
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/sign-in', [AdminController::class, 'signIn'])->name('admin.signIn');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    //Chức vụ
    Route::prefix('role')->group(function(){
        Route::get('/list',[RoleController::class, 'list'])->name('role.list');
        Route::post('/insert',[RoleController::class, 'insert'])->name('role.insert');
        Route::post('/update',[RoleController::class, 'update'])->name('role.update');
        Route::post('/delete',[RoleController::class, 'delete'])->name('role.delete');
    });
    //Tài khoản
    Route::prefix('account')->group(function(){
        Route::get('/list',[AccountController::class, 'list'])->name('account.list');
        Route::get('/setting',[AccountController::class, 'setting'])->name('account.setting');
        Route::post('/insert',[AccountController::class, 'insert'])->name('account.insert');
        Route::post('/update',[AccountController::class, 'updateInfo'])->name('account.update');
        Route::post('/delete',[AccountController::class, 'delete'])->name('account.delete');
    });
    //Danh muc san pham
    Route::prefix('category')->group(function(){
        Route::get('/list',[CategoryController::class, 'list'])->name('category.list');
        Route::post('/insert',[CategoryController::class, 'insert'])->name('category.insert');
        Route::post('/update',[CategoryController::class, 'update'])->name('category.update');
        Route::post('/delete',[CategoryController::class, 'delete'])->name('category.delete');
    });
    //San pham
    Route::prefix('product')->group(function(){
        Route::get('/list',[ProductController::class, 'list'])->name('product.list');
        Route::post('/insert',[ProductController::class, 'insert'])->name('product.insert');
        Route::post('/update',[ProductController::class, 'update'])->name('product.update');
        Route::post('/delete',[ProductController::class, 'delete'])->name('product.delete');
    });
    //Danh muc anh san pham
    Route::prefix('gallery')->group(function(){
        Route::get('/list',[GalleryController::class, 'list'])->name('gallery.list');
        Route::post('/insert',[GalleryController::class, 'insert'])->name('gallery.insert');
        Route::post('/update',[GalleryController::class, 'update'])->name('gallery.update');
        Route::post('/delete',[GalleryController::class, 'delete'])->name('gallery.delete');
    });
    //Quang cao
    Route::prefix('slide')->group(function(){
        Route::get('/list',[SlideController::class, 'list'])->name('slide.list');
        Route::post('/insert',[SlideController::class, 'insert'])->name('slide.insert');
        Route::post('/update',[SlideController::class, 'update'])->name('slide.update');
        Route::post('/delete',[SlideController::class, 'delete'])->name('slide.delete');
    });
    //Nha cung cap
    Route::prefix('supplier')->group(function(){
        Route::get('/list',[SupplierController::class, 'list'])->name('supplier.list');
        Route::post('/insert',[SupplierController::class, 'insert'])->name('supplier.insert');
        Route::post('/update',[SupplierController::class, 'update'])->name('supplier.update');
        Route::post('/delete',[SupplierController::class, 'delete'])->name('supplier.delete');
    });
    //Chức vụ
    Route::prefix('customer')->group(function(){
        Route::get('/list',[CustomerController::class, 'list'])->name('customer.list');
    });
});
