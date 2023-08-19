<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ScriptController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HomeSliderController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\BrandingHeaderController;
use App\Http\Controllers\Api\ShippingChargeController;
use App\Http\Controllers\Api\SocialMediaController;

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

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getUser']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::apiResource('products', ProductController::class);

    Route::apiResource('categories', CategoryController::class);
    
    Route::apiResource('users', UserController::class);
    
    Route::apiResource('customers', CustomerController::class);

    Route::apiResource('sliders', HomeSliderController::class);
    // Route::get('sliders/count/{catId}', [HomeSliderController::class, 'getProductCount']);
    Route::get('sliders/products', [HomeSliderController::class, 'getProducts']);
    Route::get('sliders/featured', [HomeSliderController::class, 'getFeatured']);

    Route::apiResource('banner', BannerController::class);

    Route::apiResource('testimonials', TestimonialController::class);

    Route::apiResource('pages', PageController::class);

    Route::apiResource('menus', MenuController::class);
    Route::get('menus/recent', [MenuController::class, 'getRecentMenu']);
    Route::post('menus/{id}/{subtitle}', [MenuController::class, 'addSubtitle']);

    Route::apiResource('branding', BrandingHeaderController::class);

    Route::apiResource('scripts', ScriptController::class);

    Route::apiResource('shipping', ShippingChargeController::class);

    Route::apiResource('socials', SocialMediaController::class);

    Route::post('products/{id}/{dir}', [ProductImageController::class, 'deleteImage']);

    Route::get('/countries', [CustomerController::class, 'countries']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
    Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
    Route::get('orders/{order}', [OrderController::class, 'view']);

    // Dashboard Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/products-count', [DashboardController::class, 'activeProducts']);
    Route::get('/dashboard/orders-count', [DashboardController::class, 'paidOrders']);
    Route::get('/dashboard/income-amount', [DashboardController::class, 'totalIncome']);
    Route::get('/dashboard/orders-by-country', [DashboardController::class, 'ordersByCountry']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);
    Route::get('/dashboard/latest-orders', [DashboardController::class, 'latestOrders']);

    // Report routes
    Route::get('/report/orders', [ReportController::class, 'orders']);
    Route::get('/report/customers', [ReportController::class, 'customers']);
});

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
