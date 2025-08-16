<?php

use App\Models\About;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

Route::middleware('auth')->group(function(){
    Route::get('/',[HomeController::class,'index'])->name('home');

    Route::resource('sliders',SliderController::class);
    Route::resource('features',FeatureController::class);
    Route::resource('about',AboutController::class);

    Route::prefix('contacts')->group(function () {
        Route::get('/',[ContactController::class,'index'])->name('contacts.index');
        Route::get('/{contact}',[ContactController::class,'show'])->name('contacts.show');
        Route::delete('/{contact}',[ContactController::class,'destroy'])->name('contacts.delete');
    });

    Route::prefix('footer')->group(function () {
        Route::get('/',[FooterController::class,'index'])->name('footer.index');
        Route::get('/{footer}/edit',[FooterController::class,'edit'])->name('footer.edit');
        Route::put('/{footer}',[FooterController::class,'update'])->name('footer.update');
    });

    Route::resource('category',CategoryController::class);

    Route::resource('products',ProductController::class);

    Route::resource('coupons',CouponController::class);

    Route::get('/orders',[OrderController::class,'index'])->name('order.index');
    Route::get('/transactions',[TransactionController::class,'index'])->name('transaction.index');

    Route::resource('users', UserController::class);
    Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
});



Route::get('/login',[AuthController::class,'loginform'])->name('auth.loginform');
Route::post('/login',[AuthController::class,'login'])->name('auth.login');
