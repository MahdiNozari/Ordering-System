<?php

use App\Models\About;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});

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