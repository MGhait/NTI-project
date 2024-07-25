<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoggedMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function() {
    return view('login.index');
})->name('login');
// for login and logout
Route::Post('/verifyLogin', [LogController::class,'verifyLogin'])->name('verifyLogin.user');
Route::get('/logout', [LogController::class,'logout'])->name('logout.user');
Route::group(['prefix'=>'dashboard', 'middleware'=> LoggedMiddleware::class], function (){
    // -------------------------- Categories ---------------------------- //
    Route::get('/categories', function (){
        return view('dashboard.categories.index');
    });
    Route::resource("/categories", CategoryController::class);
    Route::post('/categories/isActive/{category}', 'App\Http\Controllers\CategoryController@isActive')->name('categories.isActive');

    // --------------------------- Products ---------------------------- //
    Route::get('/products', function (){
        return view('dashboard.products.index');
    });
    Route::resource("/products", ProductController::class);
    Route::post('/products/bulk', [ProductController::class, 'bulk'])->name('products.bulk');
    Route::get('/products/publish/{product}', 'App\Http\Controllers\ProductController@publish')->name('products.publish');
    // ----------------------------- Users ---------------------------- //
    Route::get('/users', function (){
        return view('dashboard.users.index');
    })->name('users.index');
    Route::resource("/users", UserController::class);
    Route::get('/users/publish/{product}', 'App\Http\Controllers\ProductController@publish')->name('users.publish');
    Route::post('/users/isActive/{user}', 'App\Http\Controllers\UserController@isActive')->name('users.isActive');


});
