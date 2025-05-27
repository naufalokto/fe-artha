<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/about', function () {
    return view('about'); // Pastikan file view about.blade.php sudah ada
})->name('about');

Route::get('/', function () {
    return view('welcome');
});

// Customer
Route::get('/products', function() {
    return view('products'); // Jika file ada di resources/views/
})->name('products');

Route::get('/customer/products', function() {
    return view('productsCustomer'); // Jika file ada di resources/views/
})->name('productsCustomer');

// Admin
Route::get('/admin/dashboard', function() {
    return view('admin.dashboard'); // Buat view dashboard admin
});

// Manager
Route::get('/manager/dashboard', function() {
    return view('manager.dashboard'); // Buat view dashboard manager
});

// Sales
Route::get('/sales/dashboard', function() {
    return view('sales.dashboard'); // Buat view dashboard sales
});

Route::fallback(function () {
    return redirect('/signup');
});

Route::get('/signup', function () {
    return view('signup');
})->name('signup');  // Add this name definition

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/signup', [ApiController::class, 'signup']);
Route::post('/login', [ApiController::class, 'login']);
Route::post('/midtrans/webhook', [ApiController::class, 'midtransWebhook']);

// Admin
Route::post('/admin/create-account', [ApiController::class, 'createAccount']);

// Sales
Route::post('/sales/stocks', [ApiController::class, 'insertProductAndStock']);
Route::put('/sales/stocks', [ApiController::class, 'updateProductStock']);
Route::post('/sales/rawmaterial', [ApiController::class, 'insertRawMaterial']);
Route::get('/sales/rawmaterial', [ApiController::class, 'getRawMaterialsSorted']);

// Manager
Route::post('/manager/gemini/analyze', [ApiController::class, 'analyzeAllProducts']);
Route::get('/manager/transaction-view', [ApiController::class, 'salesRecap']);

// Customer
Route::get('/customer/transactions', [ApiController::class, 'viewTransaction']);
Route::post('/customer/checkout', [ApiController::class, 'checkout']);
Route::post('/customer/cart', [ApiController::class, 'addToCart']);
Route::get('/customer/cart', [ApiController::class, 'getUserCart']);
Route::delete('/customer/cart', [ApiController::class, 'deleteCartItems']);