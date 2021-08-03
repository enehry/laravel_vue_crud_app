<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SupplierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

Route::prefix('admin')->middleware('JWT')->group(function () {
    Route::get('/all/employee', [EmployeeController::class, 'index']);
    Route::post('/create/employee', [EmployeeController::class, 'store']);
    Route::get('/delete/employee/{id}', [EmployeeController::class, 'destroy']);
    Route::get('/edit/employee/{id}', [EmployeeController::class, 'edit']);
    Route::post('/update/employee/{id}', [EmployeeController::class, 'update']);
    
    // Route supplier
    Route::get('/supplier/all', [SupplierController::class, 'index']);
    Route::post('/supplier/create', [SupplierController::class, 'store']);
    Route::get('/supplier/edit/{id}', [SupplierController::class, 'edit']);
    Route::get('/supplier/delete/{id}', [SupplierController::class, 'destroy']);
    Route::post('/supplier/update/{id}', [SupplierController::class, 'update']);

    Route::get('/category/all', [CategoryController::class, 'index']);
    Route::post('/category/create', [CategoryController::class, 'store']);
    Route::get('/category/delete/{id}', [CategoryController::class, 'destroy']);
    Route::post('/category/update', [CategoryController::class, 'update']);

    Route::get('/product/all', [ProductController::class, 'index']);
    Route::get('/product/categorySupplier', [ProductController::class, 'getCategoryAndSupplier']);
    Route::post('/product/create', [ProductController::class, 'store']);
    Route::get('/product/delete/{id}', [ProductController::class, 'destroy']);
    Route::get('/product/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/product/update/{id}', [ProductController::class, 'update']);
});