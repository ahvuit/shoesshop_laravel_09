<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SaleDetailsController;
use App\Http\Controllers\SizeTableController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SearchHistoryController;
use App\Http\Controllers\OrderController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(UserController::class)->group(function(){
    Route::get('/getAllUsers','index');
    Route::get('/getUserDetails/{id}','detail');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::put('/updateUser/{id}','update');
});

Route::controller(ProfileController::class)->group(function(){
    Route::get('/getProfileDetails/{id}','detail');
    Route::put('/updateProfile/{id}','update');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/getAllProducts','index');
    Route::get('/getProductDetails/{id}','detail');
    Route::post('/insertProduct', 'create');
    Route::put('/updateProduct/{id}', 'update');
});

Route::controller(BrandController::class)->group(function(){
    Route::get('/getAllBrands','index');
    Route::get('/getBrandDetails/{id}','detail');
    Route::post('/insertBrand', 'create');
    Route::put('/updateBrand/{id}', 'update');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('/getAllCategories','index');
    Route::get('/getCategoryDetails/{id}','detail');
    Route::post('/insertCategory', 'create');
    Route::put('/updateCategory/{id}', 'update');
});

Route::controller(SalesController::class)->group(function(){
    Route::get('/getAllSales','index');
    Route::get('/getSalesById/{id}','detail');
    Route::post('/insertSales', 'create');
    Route::put('/updateSales/{id}', 'update');
});

Route::controller(SaleDetailsController::class)->group(function(){
    Route::get('/getSaleDetailsBySalesId/{id}','detail');
    Route::post('/insertSalesDetails', 'create');
    Route::delete('/deleteSaleDetails/{id}', 'delete');
});

Route::controller(OrderController::class)->group(function(){
    Route::post('/insertOrder', 'create');
    Route::get('/getOrderDetails/{id}','detail');
    Route::get('/getOrderByUserId/{id}','getOrderByUserId');
    Route::get('/getAllOrders','index');
    Route::put('/payment/{id}', 'payment');
});

Route::controller(SizeTableController::class)->group(function(){
    Route::get('/getSizeTableDetails/{id}','detail');
    Route::get('/getAllSizeTables','index');
});

Route::controller(CommentController::class)->group(function(){
    Route::get('/getAllComments/{id}','index');
    Route::post('/insertComment','create');
});

Route::controller(SearchHistoryController::class)->group(function(){
    Route::put('/insertOrUpdateKeyword','insertOrUpdateKeyword');
    Route::get('/getProductByUserId/{id}','detail');
});

