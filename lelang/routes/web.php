<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AdminController;

// Home
Route::get('/', [BarangController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Barang Routes
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');

Route::middleware('auth')->group(function () {
    Route::get('/barang/create/new', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/my-items', [BarangController::class, 'myItems'])->name('barang.myitems');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');
    
    // Bid Routes
    // Tambahkan route ini
    // routes/web.php - PASTIKAN ada route ini:
    //Route::post('/barang/{barang_id}/bid', [BidController::class, 'store'])->name('bid.store')->middleware('auth');
    Route::post('/bid', [BidController::class, 'store'])->name('bid.store')->middleware('auth');
    Route::get('/my-bids', [BidController::class, 'myBids'])->name('bid.mybids');
});

// Admin Routes
// Admin Routes (TAMBAHAN - jangan hapus routes yang lama)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::post('/users/{id}/toggle-role', [App\Http\Controllers\AdminController::class, 'toggleRole'])->name('admin.users.toggle-role');
    
    // Barang Management
    Route::get('/barangs', [App\Http\Controllers\AdminController::class, 'barangs'])->name('admin.barangs');
    Route::delete('/barangs/{id}', [App\Http\Controllers\AdminController::class, 'deleteBarang'])->name('admin.barangs.delete');
    Route::post('/barangs/{id}/status', [App\Http\Controllers\AdminController::class, 'updateStatusBarang'])->name('admin.barangs.status');
    
    // Bid Management
    Route::get('/bids', [App\Http\Controllers\AdminController::class, 'bids'])->name('admin.bids');
    Route::delete('/bids/{id}', [App\Http\Controllers\AdminController::class, 'deleteBid'])->name('admin.bids.delete');
    
    // Reports
    Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');
});

    Route::get('/reports/pdf/{type}', [AdminController::class, 'downloadPDF'])->name('reports.pdf');
    Route::get('/reports/csv/{type}', [AdminController::class, 'downloadCSV'])->name('reports.csv');
    Route::get('/reports/excel/{type}', [AdminController::class, 'downloadExcel'])->name('reports.excel');
    Route::get('/reports/download-all', [AdminController::class, 'downloadAll'])->name('reports.download-all');