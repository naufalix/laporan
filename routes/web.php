<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminAdmin;
use App\Http\Controllers\Admin\AdminShop;
use App\Http\Controllers\Dashboard\DashReport;

Route::get('/', function () {
    return redirect('/login');
});

// AUTH
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// ADMIN PAGE
Route::group(['prefix'=> 'admin','middleware'=>['auth:admin']], function(){
    Route::get('/', [AdminDashboard::class, 'index']);
    Route::get('/admin', [AdminAdmin::class, 'index']);
    Route::get('/shop', [AdminShop::class, 'index']);
    
    Route::post('/admin', [AdminAdmin::class, 'postHandler']);
    Route::post('/shop', [AdminShop::class, 'postHandler']);
});

// OWNERS PAGE
Route::group(['prefix'=> 'dashboard','middleware'=>['auth:user']], function(){
    Route::get('/', function () {return redirect('/dashboard/buat-laporan');});
    Route::get('/buat-laporan', [DashReport::class, 'index']);
    Route::get('/anggota', [DashMember::class, 'index']);
    Route::get('/laporan', [DashReport::class, 'index2']);
    
    Route::post('/buat-laporan', [DashReport::class, 'postHandler']);
    Route::post('/anggota', [DashMember::class, 'postHandler']);
    Route::post('/laporan', [DashReport::class, 'postHandler']);
});

// CASHIER PAGE
// Route::group(['prefix'=> 'cashier','middleware'=>['auth:cashier']], function(){
//     Route::get('/', [CashierDashboard::class, 'index']);
//     Route::get('/history', [CashierHistory::class, 'index']);
//     Route::get('/invoice', [CashierInvoice::class, 'index']);
    
//     Route::post('/invoice', [CashierInvoice::class, 'postHandler']);
// });

// API
Route::get('/api/posts', [APIController::class, 'posts']);
Route::get('/api/admin/{admin:id}', [APIController::class, 'admin']);
Route::get('/api/cashier/{cashier:id}', [APIController::class, 'cashier']);
Route::get('/api/product/{product:id}', [APIController::class, 'product']);
Route::get('/api/shop/{shop:id}', [APIController::class, 'shop']);