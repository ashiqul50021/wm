<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Admin\AdminApiController;

use App\Http\Controllers\API\Dealer\DealerApiController;
use App\Http\Controllers\API\Frontend\CartApiController;
use App\Http\Controllers\API\Frontend\PageApiController;
use App\Http\Controllers\API\Frontend\UserApiController;
use App\Http\Controllers\API\Admin\AdminAuthApiController;
use App\Http\Controllers\API\Frontend\ProductApiController;
use App\Http\Controllers\API\Dealer\DealerAuthApiController;
use App\Http\Controllers\API\Frontend\CategoryApiController;
use App\Http\Controllers\API\Frontend\FrontendApiController;
use App\Http\Controllers\API\Frontend\UserAuthApiController;
use App\Http\Controllers\API\Dealer\DealerOrderApiController;
use App\Http\Controllers\API\Seller\SellerApiController;
use App\Http\Controllers\API\Seller\SellerAttributeApiController;
use App\Http\Controllers\API\Seller\SellerAuthApiController;
use App\Http\Controllers\API\Seller\SellerBrandApiController;
use App\Http\Controllers\API\Seller\SellerCategoryApiController;
use App\Http\Controllers\API\Seller\SellerCommissionApiController;
use App\Http\Controllers\API\Seller\SellerProductApiController;
use App\Http\Controllers\API\Seller\SellerProfileApiController;
use App\Http\Controllers\API\Seller\SellerUnitApiController;
use App\Http\Controllers\Seller\SellerProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    // Route::post('/logout', [UserApiController::class, 'userLogout']);
});

// User Login
Route::group(['prefix' => 'v1'], function () {
    Route::post('user/register', [UserAuthApiController::class, 'register']);
    Route::post('user/login', [UserAuthApiController::class, 'login']);
});

Route::group(['prefix' => 'v1'], function () {

    Route::get('/', [FrontendApiController::class, 'index']);
    Route::get('slider', [AdminApiController::class, 'slider']);
    Route::get('category/featured', [CategoryApiController::class, 'featuredCategory']);

    Route::get('product/featured', [ProductApiController::class, 'productFeatured']);
    Route::get('product/featured/limit', [ProductApiController::class, 'productFeaturedLimit']);
    Route::get('product/top-selling', [ProductApiController::class, 'topSelling']);
    Route::get('product/top-selling/limit', [ProductApiController::class, 'topSellingLimit']);
    Route::get('product/trending', [ProductApiController::class, 'trendingProduct']);
    Route::get('product/trending/limit', [ProductApiController::class, 'trendingProductLimit']);
    Route::get('product/shop', [ProductApiController::class, 'productShop']);

    //User Controller
    Route::middleware(['auth:sanctum', 'user.api'])->group(function () {
        Route::get('user/dashboard', [UserApiController::class, 'dashboard']);
        Route::get('user/profile', [UserApiController::class, 'userProfile']);
        Route::post('user/profile/update', [UserApiController::class, 'userProfileUpdate']);
        Route::post('user/password/update', [UserApiController::class, 'UserPasswordUpdate']);
        Route::get('user/logout', [UserApiController::class, 'UserLogout']);

        Route::get('division', [UserApiController::class, 'getDivision']);
        Route::get('district', [UserApiController::class, 'getDistrict']);
        Route::get('upazilla', [UserApiController::class, 'getUpazilla']);

        Route::get('division-wise-district/{division_id}', [UserApiController::class, 'divisionWiseDistrict']);
        Route::get('district-wise-upazilla/{district_id}', [UserApiController::class, 'districtWiseUpazilla']);

        Route::post('user/address/store', [UserApiController::class, 'userAddressStore']);
        Route::post('user/address/show/{address_id}', [UserApiController::class, 'userAddressShow']);

        Route::get('user/addresses/delete/{id}', [UserApiController::class, 'address_destroy']);
        Route::get('/addresses/set_default/{id}', [UserApiController::class, 'set_default']);

        Route::get('shipping-cost', [UserApiController::class, 'shippingCost']);
        Route::post('user/place-an-order', [UserApiController::class, 'placeAnOrder']);
        Route::get('user/orders/list', [UserApiController::class, 'orderList']);
        Route::get('user/orders/{invoice_no}', [UserApiController::class, 'orderView']);
        Route::post('user/order-track', [UserApiController::class, 'orderTrack']);
    });

    //Category Controller
    Route::get('categories', [CategoryApiController::class, 'index']);

    //Product Controller
    Route::get('product-details/{slug}', [ProductApiController::class, 'productDetails']);
    Route::post('product-review/store', [ProductApiController::class, 'productReviewStore']);

    //Frontend-Category | Vendor | Tag Wise Product Show
    Route::get('category-product/{slug}', [FrontendApiController::class, 'CategoryWiseProduct']);
    Route::get('vendor-product/{slug}', [FrontendApiController::class, 'VendorWiseProduct']);
    Route::get('tag-product/{id}/{slug}', [FrontendApiController::class, 'TagWiseProduct']);

    //Cart Controller
    Route::get('cart', [CartApiController::class, 'cartIndex']);
    Route::post('add-cart/{id}', [CartApiController::class, 'addToCart']);
    Route::get('get-cart-product', [CartApiController::class, 'getCartProduct']);
    Route::get('product/mini-cart', [CartApiController::class, 'AddMiniCart']);

    //Page Controller
    Route::get('page/{slug}', [PageApiController::class, 'index']);


    /*
    |--------------------------------------------------------------------------
    | DEALER APP API Routes
    |--------------------------------------------------------------------------
    |
    */

    // Dealer Apply
    Route::post('dealer-apply', [DealerAuthApiController::class, 'dealerApply']);
    Route::post('dealer/login', [DealerAuthApiController::class, 'login']);

    Route::get('dealer/pos', [DealerApiController::class, 'dealerPos']);
    Route::get('dealer/category/list', [DealerApiController::class, 'dealerCategoryList']);
    Route::get('dealer/category-wise-pos/{cat_id}', [DealerApiController::class, 'dealerCategoryWisePos']);

    Route::middleware(['auth:sanctum', 'abilities:dealer-api'])->group(function () {
        Route::get('dealer/dashboard', [DealerApiController::class, 'dealerDashboard']);

        Route::get('dealer/profile', [DealerApiController::class, 'dealerProfile']);
        Route::post('dealer/profile/update', [DealerApiController::class, 'updateProfile']);
        Route::post('dealer/update/password', [DealerApiController::class, 'updatePassword']);

        Route::post('dealer/order/store', [DealerOrderApiController::class, 'orderStore']);
        Route::post('dealer/order/update/{id}', [DealerOrderApiController::class, 'orderUpdate']);

        Route::get('dealer/sales/all-requests', [DealerOrderApiController::class, 'allRequest']);
        Route::get('dealer/sales/all-request/{id}', [DealerOrderApiController::class, 'allRequestShow']);
        Route::get('dealer/sales/all-request/delete/{id}', [DealerOrderApiController::class, 'allRequestDestroy']);

        Route::get('dealer/sales/order-confirm', [DealerOrderApiController::class, 'dealerOrderConfirm']);
        Route::get('dealer/sales/order/show/{id}', [DealerOrderApiController::class, 'dealerOrderShow']);
        Route::get('dealer/sales/invoice/download/{id}', [DealerOrderApiController::class, 'dealerSalesInvoice']);

        Route::get('dealer/category-wise-product/{catId}', [DealerOrderApiController::class, 'categoryWiseProduct']);
    });

    // Admin part
    Route::post('admin/login', [AdminAuthApiController::class, 'AdminLogin']);

    Route::middleware(['auth:sanctum', 'abilities:admin-api'])->group(function () {
        Route::get('admin/dashboard', [AdminApiController::class, 'dashboard']);
        Route::get('admin/slider', [AdminApiController::class, 'slider']);
        Route::get('admin/sellerProductApproved/{id}', [AdminApiController::class, 'sellerProductApproved']);
        Route::post('admin/seller/approve/{id}', [AdminApiController::class, 'sellerApprove']);
    });

    /*
    |--------------------------------------------------------------------------
    | SELLER APP API Routes
    |--------------------------------------------------------------------------
    |
    */

    Route::post('seller/register', [SellerAuthApiController::class, 'sellerRegisterStore']);
    Route::post('seller/login', [SellerAuthApiController::class, 'sellerLogin']);


    Route::middleware(['auth:sanctum', 'abilities:seller-api'])->group(function () {
        Route::get('seller/dashboard', [SellerApiController::class, 'sellerDashboard']);
        Route::get('/seller/product', [SellerProductApiController::class, 'ProductView']);
        Route::get('/seller/single_product/{id}', [SellerProductApiController::class, 'singleProductView']);
        Route::post('/seller/product_store', [SellerProductApiController::class, 'StoreProduct']);
        Route::post('/seller/product_update/{id}', [SellerProductApiController::class, 'ProductUpdate']);
        Route::get('seller/product_delete/{id}', [SellerProductApiController::class, 'ProductDelete']);
        Route::get('/product_active/{id}', [SellerProductApiController::class, 'active']);
        Route::get('/product_inactive/{id}', [SellerProductApiController::class, 'inactive']);

        // Category Part
        Route::prefix('category')->group(function () {

            Route::get('/index', [SellerCategoryApiController::class, 'index'])->name('category.index');
            Route::post('/store', [SellerCategoryApiController::class, 'store'])->name('categories.store');
            Route::post('/update/{id}', [SellerCategoryApiController::class, 'update'])->name('category.update');
            Route::get('/delete/{id}', [SellerCategoryApiController::class, 'destroy'])->name('category.delete');

            Route::get('/category_active/{id}', [SellerCategoryApiController::class, 'active'])->name('category.active');
            Route::get('/category_inactive/{id}', [SellerCategoryApiController::class, 'inactive'])->name('category.in_active');

            Route::get('/category_feature_status_change/{id}', [SellerCategoryApiController::class, 'changeFeatureStatus'])->name('category.changeFeatureStatus');
        });


        // Attribute All Route
        Route::apiResource('/attribute', SellerAttributeApiController::class);
        Route::get('/attribute/delete/{id}', [SellerAttributeApiController::class, 'destroy']);

        Route::post('/attribute/value', [SellerAttributeApiController::class, 'value_store']);
        Route::post('/attribute/value/update/{id}', [SellerAttributeApiController::class, 'value_update']);
        Route::get('/attribute_value_active/{id}', [SellerAttributeApiController::class, 'value_active']);
        Route::get('/attribute_value_inactive/{id}', [SellerAttributeApiController::class, 'value_inactive']);
        Route::get('/attribute/value/delete/{id}', [SellerAttributeApiController::class, 'value_destroy']);

        Route::get('/attributes/combination', [SellerAttributeApiController::class, 'combination']);

        // Brand part
        Route::prefix('brand')->group(function () {
            Route::get('/view', [SellerBrandApiController::class, 'BrandView']);
        });
        // Unit part
        Route::prefix('unit')->group(function () {
            Route::get('/view', [SellerUnitApiController::class, 'unitView']);
        });
        // Commission List part
        Route::prefix('commission')->group(function () {
            Route::get('/view', [SellerCommissionApiController::class, 'commissionView']);
        });
        // Profile settings part
        Route::prefix('profile')->group(function () {
            Route::post('/update/{id}', [SellerProfileApiController::class, 'profileUpdate']);
        });

        Route::get('/product_stock', [SellerProductApiController::class, 'productStock']);
    });
});