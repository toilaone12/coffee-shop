<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DetailNoteController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitsController;
use App\Models\DetailNote;
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
        Route::post('/delete-all',[RoleController::class, 'deleteAll'])->name('role.deleteAll');
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
        Route::post('/delete-all',[CategoryController::class, 'deleteAll'])->name('category.deleteAll');
        
    });
    //San pham
    Route::prefix('product')->group(function(){
        Route::get('/list',[ProductController::class, 'list'])->name('product.list');
        Route::post('/insert',[ProductController::class, 'insert'])->name('product.insert');
        Route::post('/update',[ProductController::class, 'update'])->name('product.update');
        Route::post('/delete',[ProductController::class, 'delete'])->name('product.delete');
        Route::post('/delete-all',[ProductController::class, 'deleteAll'])->name('product.deleteAll');
    });
    //Danh muc anh san pham
    Route::prefix('gallery')->group(function(){
        Route::get('/list',[GalleryController::class, 'list'])->name('gallery.list');
        Route::post('/insert',[GalleryController::class, 'insert'])->name('gallery.insert');
        Route::post('/update',[GalleryController::class, 'update'])->name('gallery.update');
        Route::post('/delete',[GalleryController::class, 'delete'])->name('gallery.delete');
    });
    //Nguyen lieu
    Route::prefix('ingredients')->group(function(){
        Route::get('/list',[IngredientsController::class, 'list'])->name('ingredients.list');
        Route::post('/update',[IngredientsController::class, 'update'])->name('ingredients.update');
        Route::post('/delete',[IngredientsController::class, 'delete'])->name('ingredients.delete');
    });
    //Cong thuc
    Route::prefix('recipe')->group(function(){
        Route::get('/list',[RecipeController::class, 'list'])->name('recipe.list');
        Route::post('/insert',[RecipeController::class, 'insert'])->name('recipe.insert');
        Route::post('/update',[RecipeController::class, 'update'])->name('recipe.update');
        Route::post('/delete',[RecipeController::class, 'delete'])->name('recipe.delete');
        Route::post('/delete-all',[RecipeController::class, 'deleteAll'])->name('recipe.deleteAll');
    });
    //Cong thuc
    Route::prefix('units')->group(function(){
        Route::get('/list',[UnitsController::class, 'list'])->name('units.list');
        Route::post('/insert',[UnitsController::class, 'insert'])->name('units.insert');
        Route::post('/update',[UnitsController::class, 'update'])->name('units.update');
        Route::post('/delete',[UnitsController::class, 'delete'])->name('units.delete');
        Route::post('/delete-all',[UnitsController::class, 'deleteAll'])->name('units.deleteAll');
    });
    //Quang cao
    Route::prefix('slide')->group(function(){
        Route::get('/list',[SlideController::class, 'list'])->name('slide.list');
        Route::post('/insert',[SlideController::class, 'insert'])->name('slide.insert');
        Route::post('/update',[SlideController::class, 'update'])->name('slide.update');
        Route::post('/delete',[SlideController::class, 'delete'])->name('slide.delete');
        Route::post('/delete-all',[SlideController::class, 'deleteAll'])->name('slide.deleteAll');
    });
    //Phi van chuyen
    Route::prefix('fee')->group(function(){
        Route::get('/list',[FeeController::class, 'list'])->name('fee.list');
        Route::post('/insert',[FeeController::class, 'insert'])->name('fee.insert');
        Route::post('/update',[FeeController::class, 'update'])->name('fee.update');
        Route::post('/delete',[FeeController::class, 'delete'])->name('fee.delete');
        Route::post('/delete-all',[FeeController::class, 'deleteAll'])->name('fee.deleteAll');
    });
    //Nha cung cap
    Route::prefix('supplier')->group(function(){
        Route::get('/list',[SupplierController::class, 'list'])->name('supplier.list');
        Route::post('/insert',[SupplierController::class, 'insert'])->name('supplier.insert');
        Route::post('/update',[SupplierController::class, 'update'])->name('supplier.update');
        Route::post('/delete',[SupplierController::class, 'delete'])->name('supplier.delete');
        Route::post('/delete-all',[SupplierController::class, 'deleteAll'])->name('supplier.deleteAll');
    });
    //Chức vụ
    Route::prefix('customer')->group(function(){
        Route::get('/list',[CustomerController::class, 'list'])->name('customer.list');
    });
    //Phieu hang
    Route::prefix('notes')->group(function(){
        Route::get('/list',[NotesController::class, 'list'])->name('notes.list');
        Route::post('/insert',[NotesController::class, 'insert'])->name('notes.insert');
        Route::post('/update',[NotesController::class, 'update'])->name('notes.update');
        Route::post('/delete',[NotesController::class, 'delete'])->name('notes.delete');
        Route::post('/delete-all',[NotesController::class, 'deleteAll'])->name('notes.deleteAll');
    });
    //Chi tiet phieu hang
    Route::prefix('detail')->group(function(){
        Route::get('/list',[DetailNoteController::class, 'list'])->name('detail.list');
        Route::post('/insert',[DetailNoteController::class, 'insert'])->name('detail.insert');
        Route::post('/update',[DetailNoteController::class, 'update'])->name('detail.update');
        Route::post('/delete',[DetailNoteController::class, 'delete'])->name('detail.delete');
        Route::get('/print-pdf',[DetailNoteController::class, 'printPDF'])->name('detail.pdf');
        Route::get('/export',[DetailNoteController::class, 'export'])->name('detail.export');
    });
    //Phieu hang
    Route::prefix('order')->group(function(){
        Route::get('/list',[OrderController::class, 'list'])->name('order.list');
        Route::post('/insert',[OrderController::class, 'insert'])->name('order.insert');
        Route::post('/update',[OrderController::class, 'update'])->name('order.update');
        Route::post('/delete',[OrderController::class, 'delete'])->name('order.delete');
    });
    //Ma khuyen mai
    Route::prefix('coupon')->group(function(){
        Route::get('/list',[CouponController::class, 'list'])->name('coupon.list');
        Route::post('/insert',[CouponController::class, 'insert'])->name('coupon.insert');
        Route::post('/update',[CouponController::class, 'update'])->name('coupon.update');
        Route::post('/delete',[CouponController::class, 'delete'])->name('coupon.delete');
        Route::post('/delete-all',[CouponController::class, 'deleteAll'])->name('coupon.deleteAll');
    });
    //Danh gia
    Route::prefix('review')->group(function(){
        Route::get('/list',[ReviewController::class, 'list'])->name('review.list');
        Route::post('/reply',[ReviewController::class, 'reply'])->name('review.reply');
        Route::post('/update',[ReviewController::class, 'update'])->name('review.update');
    });
    //Tin tuc
    Route::prefix('news')->group(function(){
        Route::get('/list',[NewsController::class, 'list'])->name('news.list');
        Route::post('/insert',[NewsController::class, 'insert'])->name('news.insert');
        Route::post('/update',[NewsController::class, 'update'])->name('news.update');
        Route::post('/delete',[NewsController::class, 'delete'])->name('news.delete');
        Route::post('/delete-all',[NewsController::class, 'deleteAll'])->name('news.deleteAll');
    });
});
