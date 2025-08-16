<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/about',function(){
    return view('about');
})->name('about');

Route::get('/contact',[ContactController::class,'index'])->name('contact');

Route::post('/contact',[ContactController::class,'store'])->name('contact.store');

Route::get('/products/menu',[ProductController::class,'menu'])->name('products.menu');
Route::get('/products/{product:slug}',[ProductController::class,'show'])->name('products.show');

Route::middleware('guest')->group(function(){
    Route::get('/login',[AuthController::class,'LoginForm'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('auth.login');
    Route::post('/check-otp',[AuthController::class,'checkOtp'])->name('auth.checkOtp');
    Route::post('/resend-otp',[AuthController::class,'resendOtp'])->name('auth.resendOtp');
});


Route::prefix('profile')->middleware('auth')->group(function(){
    Route::get('/',[ProfileController::class,'index'])->name('profile.index');
    Route::put('/{user}',[ProfileController::class,'update'])->name('profile.update');
    Route::get('/addresses',[ProfileController::class,'addresses'])->name('profile.address');
    Route::get('/address/create',[ProfileController::class,'addresscreate'])->name('profile.address.create');
    Route::post('/addresses',[ProfileController::class,'addressstore'])->name('profile.address.store');
    Route::get('address/{address}/edit',[ProfileController::class,'addressedit'])->name('profile.address.edit');
    Route::put('address/{address}',[ProfileController::class,'addressupdate'])->name('profile.address.update');
    Route::get('add-to-wishlist',[ProfileController::class,'addToWishlist'])->name('profile.addtowishlist');
    Route::get('wishlist',[ProfileController::class,'wishlist'])->name('profile.wishlist');
    Route::get('remove-from-wishlist',[ProfileController::class,'removeFromWishlist'])->name('profile.wishlist.remove');
    Route::get('orders',[ProfileController::class,'orders'])->name('profile.order');
    Route::get('transactions',[ProfileController::class,'transactions'])->name('profile.transaction');
});

Route::get('/logout',[AuthController::class,'logout'])->name('logout');

Route::prefix('cart')->middleware('auth')->group(function(){
    Route::get('/',[CartController::class,'index'])->name('cart.index');
    Route::get('/increment',[CartController::class,'increment'])->name('cart.increment');
    Route::get('/add',[CartController::class,'add'])->name('cart.add');
    Route::get('/decrement',[CartController::class,'decrement'])->name('cart.decrement');
    Route::get('/remove',[CartController::class,'remove'])->name('cart.remove');
    Route::get('/clear',[CartController::class,'clear'])->name('cart.clear');
    Route::get('/check-coupon',[CartController::class,'checkCoupon'])->name('cart.checkcoupon');
});

Route::prefix('payments')->middleware('auth')->group(function(){
    Route::post('/send',[PaymentController::class,'send'])->name('payment.send');
    Route::get('/verify',[PaymentController::class,'verify'])->name('payments.verify');
    Route::get('/status',[PaymentController::class,'status'])->name('payments.status');
});