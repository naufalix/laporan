<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminHome;
use App\Http\Controllers\Admin\AdminReport;
use App\Http\Controllers\Admin\AdminUser;
use App\Http\Controllers\Dashboard\DashReport;

Route::get('/', function () {
    return redirect('/login');
});

// AUTH
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'index2']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// ADMIN PAGE
Route::group(['prefix'=> 'admin','middleware'=>['auth:admin']], function(){
    Route::get('/', [AdminHome::class, 'index']);
    Route::get('/laporan', [AdminReport::class, 'index']);
    Route::get('/anggota', [AdminUser::class, 'index']);
    
    Route::post('/laporan', [AdminReport::class, 'postHandler']);
    Route::post('/anggota', [AdminUser::class, 'postHandler']);
});

// DASHBOARD PAGE
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
// Route::get('/api/posts', [APIController::class, 'posts']);
// Route::get('/api/admin/{admin:id}', [APIController::class, 'admin']);
// Route::get('/api/cashier/{cashier:id}', [APIController::class, 'cashier']);
Route::get('/api/report/{report:id}', [APIController::class, 'report']);
// Route::get('/api/shop/{shop:id}', [APIController::class, 'shop']);