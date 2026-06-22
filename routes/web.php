<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ReceiptController;
use App\Livewire\Attendant\CatalogueManager;
use App\Livewire\Attendant\ProductManager;
use Illuminate\Support\Facades\Route;

Route::get('/', [StoreController::class,'home'])->name('home');
Route::get('/shop', [StoreController::class,'shop'])->name('shop');
Route::get('/products/{product:slug}', [StoreController::class,'product'])->name('products.show');
Route::middleware('guest')->group(function(){ Route::get('/attendant/login',[AuthController::class,'show'])->name('login'); Route::post('/attendant/login',[AuthController::class,'login'])->name('login.store'); });
Route::middleware(['auth','attendant'])->prefix('attendant')->name('attendant.')->group(function(){
    Route::view('/', 'attendant.dashboard')->name('dashboard');
    Route::get('/products', ProductManager::class)->name('products');
    Route::get('/catalogue', CatalogueManager::class)->name('catalogue');
    Route::get('/orders/{order}/receipt', ReceiptController::class)->name('orders.receipt');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});
Route::view('/offline','offline')->name('offline');
