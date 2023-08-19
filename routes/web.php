<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HeaderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\SearchController;

// require_once __DIR__.'/breadcrumbs.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guestOrVerified', 'fetchHeaderAndFooterData'])->group(function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/categories', function(){
        return redirect("/#categories");
    })->name('categories');

    Route::get('/pages/{page:slug}', [PageController::class, 'view'])->name('page.view');
    // Route::get('/products', [ProductController::class, 'index'])->name('products');

    Route::get('/products', function () {
        $menuItems = app()->make('App\Http\Controllers\MenuController')->getMenuItems();
        $products = app()->make('App\Http\Controllers\ProductController')->index();
        $productImage = app()->make('App\Http\Controllers\ProductImageController')->index();
        $categories = app()->make('App\Http\Controllers\CategoryController')->index();

        return view('product.index', [
            'menuItems' => $menuItems,
            'products' => $products, 
            'productImage' => $productImage, 
            'categories' => $categories,
        ]);
    })->name('products');

    Route::get('/categories/{catId}', [ProductController::class, 'getCategoryProducts'])->name('categories.view');
    Route::get('/product/{product:slug}', [ProductController::class, 'view'])->name('product.view');


    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');
    });

    Route::get("/search", [SearchController::class, 'searchProduct'])->name('search.product');
});

Route::middleware(['auth', 'verified', 'fetchHeaderAndFooterData'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.update');
    Route::post('/profile/password-update', [ProfileController::class, 'passwordUpdate'])->name('profile_password.update');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/{order}', [CheckoutController::class, 'checkoutOrder'])->name('cart.checkout-order');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'view'])->name('order.view');
});

Route::post('/webhook/stripe', [CheckoutController::class, 'webhook']);

require __DIR__ . '/auth.php';
