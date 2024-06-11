<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Frontend\ProductsController;
use App\Http\Controllers\Frontend\CartController;


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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::group(
    ['middleware' => 'auth'],
    function () {

        Route::get('/daskbord', function () {
            return view('dashbord');
        })->name('daskbord');

        Route::get('/daskbord/admin', function () {
            return view('layouts.backend_app');
        });


        Route::get('/product/list', [ProductController::class, 'index'])->name('index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('create');              // use to create user from
        Route::post('/create', [ProductController::class, 'store'])->name('user.store');

        Route::get('product/edit/{product}', [ProductController::class, 'edit'])->name('edit');        // it is use to fetch data and create edit from
        Route::PATCH('product/{product}', [ProductController::class, 'update'])->name('user.update');        // create route for update the user details
        Route::post('product/delete_image/{id}', [ProductController::class, 'delete_image'])->name('delete_image');


        Route::delete('/product/delete/{id}', [ProductController::class, 'delete'])->name('user.delete');          // create route for delete user
    }
);

// front side products route
Route::get('/product', [ProductsController::class, 'product']);
Route::get('product-details/{sku?}', [ProductsController::class, 'productdetail'])->name('product.detail');
// Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');


// Route::get('/product/cart', function () {
//     return view('frontend.cart');
// });
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Add item to cart
Route::post('/cart/add', [CartController::class, 'create'])->name('cart.add');

// Remove item from cart
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
