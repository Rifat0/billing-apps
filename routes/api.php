<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Buyer\BuyerSellerController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Seller\SellerBuyerController;
use App\Http\Controllers\Buyer\BuyerCategoryController;
use App\Http\Controllers\Product\ProductBuyerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Category\CategoryBuyerController;
use App\Http\Controllers\Category\CategorySellerController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Category\CategoryProductController;
use App\Http\Controllers\Seller\SellerTransactionController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use App\Http\Controllers\Product\ProductTransactionController;
use App\Http\Controllers\Category\CategoryTransactionController;
use App\Http\Controllers\Transaction\TransactionSellerController;
use App\Http\Controllers\Transaction\TransactionCategoryController;

Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);
Route::get('users/email-verify/{token}', [UserController::class, 'verify'])->name('users.emailVerify');
Route::get('users/change-email/{token}', [UserController::class, 'changeEmail'])->name('users.changeEmail');
Route::get('users/{user}/resend-email', [UserController::class, 'resendVerificationEmail'])->name('users.resend');
// Route::get('users/{user}/confirm/{token}', [UserController::class, 'confirm'])->name('users.confirm');

Route::resource('buyers', BuyerController::class, ['only' => ['index', 'show']]);
Route::get('buyers/{buyer}/transactions', [BuyerTransactionController::class, 'index'])->name('buyers.transactions');
Route::get('buyers/{buyer}/products', [BuyerProductController::class, 'index'])->name('buyers.products');
Route::get('buyers/{buyer}/sellers', [BuyerSellerController::class, 'index'])->name('buyers.sellers');
Route::get('buyers/{buyer}/categories', [BuyerCategoryController::class, 'index'])->name('buyers.categories');

Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);
Route::get('sellers/{seller}/transactions', [SellerTransactionController::class, 'index'])->name('sellers.transactions');
Route::get('sellers/{seller}/categories', [SellerCategoryController::class, 'index'])->name('sellers.categories');
Route::get('sellers/{seller}/buyers', [SellerBuyerController::class, 'index'])->name('sellers.buyers');
Route::resource('sellers.products', SellerProductController::class, ['except' => ['create']]);

Route::resource('categories', CategoryController::class, ['except' => ['create', 'edit']]);
Route::get('categories/{category}/products', [CategoryProductController::class, 'index'])->name('categories.products');
Route::get('categories/{category}/sellers', [CategorySellerController::class, 'index'])->name('categories.sellers');
Route::get('categories/{category}/transactions', [CategoryTransactionController::class, 'index'])->name('categories.transactions');
Route::get('categories/{category}/buyers', [CategoryBuyerController::class, 'index'])->name('categories.buyers');

Route::resource('products', ProductController::class, ['only' => ['index', 'show']]);
Route::get('products/{product}/transaction', [ProductTransactionController::class, 'index']);
Route::get('products/{product}/buyer', [ProductBuyerController::class ,'index'])->name('product.buyer');
Route::post('products/{product}/transaction', [ProductTransactionController::class ,'update']);
Route::resource('products.categories', ProductCategoryController::class);

Route::resource('transactions', TransactionController::class, ['only' => ['index', 'show']]);
Route::get('transactions/{transaction}/categories', [TransactionCategoryController::class, 'index'])->name('transactions.categories');
Route::get('transactions/{transaction}/sellers', [TransactionSellerController::class, 'index'])->name('transactions.sellers');

// Route::post('oauth/token', [AccessTokenController::class, 'issueToken']);