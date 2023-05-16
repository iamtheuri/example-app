<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Common Research Routes:
// index - show all products
// show - show single product
// create - show form to create new product
// store - store new product
// edit - show form to edit new product
// update - update product
// destroy - delete product

// All Products
Route::get('/', [ProductController::class, 'index']);

// Show Create Form
Route::get('/products/create', [ProductController::class, 'create'])->middleware('auth');

// Store Product Data
Route::post('/products', [ProductController::class, 'store'])->middleware('auth');

// Show Edit Form
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->middleware('auth');

// Update Product
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('auth');

// Delete Product
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('auth');

// Manage Products
Route::get('/products/manage', [ProductController::class, 'manage'])->middleware('auth');

// Single Product
Route::get('/products/{product}', [ProductController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);