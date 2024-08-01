<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DealerAdminController;
use App\Http\Controllers\Dealer\BrandController;
use App\Http\Controllers\Dealer\CategoryController;
use App\Http\Controllers\Dealer\SupplierController;
use App\Http\Controllers\Dealer\ProductController;
use App\Http\Controllers\Dealer\AttributeController;
use App\Http\Controllers\Dealer\OrderController;
use App\Http\Controllers\Dealer\PaymentMethodController;
use App\Http\Controllers\Dealer\ReportController;
use App\Http\Controllers\Dealer\PosController;
use App\Http\Controllers\Dealer\UserController;

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

/*========================== Start dealer Route  ==========================*/

Route::get('/dealer/login', [DealerAdminController::class, 'index'])->name('dealer.login_form');
Route::post('/dealer/login', [DealerAdminController::class, 'login'])->name('dealer.login');
Route::get('/dealer/register', [DealerAdminController::class, 'dealerRegister'])->name('dealer.register');
Route::post('/dealer/register/store', [DealerAdminController::class, 'dealerRegisterStore'])->name('dealer.register.store');

// dealer All Routes
Route::prefix('dealer')->name('dealer.')->middleware('dealer')->group(function () {
    Route::get('/dashboard', [DealerAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [DealerAdminController::class, 'dealerLogout'])->name('logout');

    Route::get('/forgot-password', [DealerAdminController::class, 'AdminForgotPassword'])->name('password.request');
    Route::get('/profile', [DealerAdminController::class, 'profile'])->name('profile');
    Route::get('/edit/profile', [DealerAdminController::class, 'editProfile'])->name('edit.profile');
    Route::post('/store/profile', [DealerAdminController::class, 'storeProfile'])->name('store.profile');
    Route::get('/change/password', [DealerAdminController::class, 'changePassword'])->name('change.password');
    Route::post('/update/password', [DealerAdminController::class, 'updatePassword'])->name('update.password');

    /* ================ dealer Cache Clear ============== */
    Route::get('/cache-cache', [DealerAdminController::class, 'clearCache'])->name('cache.clear');

    // dealer Product All Routes
    // Route::prefix('product')->group(function () {
    //     Route::get('/view', [ProductController::class, 'ProductView'])->name('product.all');
    //     Route::get('/add', [ProductController::class, 'ProductAdd'])->name('product.add');
    //     Route::post('/store', [ProductController::class, 'StoreProduct'])->name('product.store');
    //     Route::get('/edit/{id}', [ProductController::class, 'EditProduct'])->name('product.edit');
    //     Route::post('/update/{id}', [ProductController::class, 'ProductUpdate'])->name('product.update');
    //     Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
    //     Route::get('/multiimg/delete/{id}', [ProductController::class, 'MultiImageDelete'])->name('product.multiimg.delete');
    //     Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');
    //     Route::get('/product_active/{id}', [ProductController::class, 'active'])->name('product.active');
    //     Route::get('/product_inactive/{id}', [ProductController::class, 'inactive'])->name('product.in_active');
    //     Route::get('/product_featured/{id}', [ProductController::class, 'featured'])->name('product.featured');
    //     // Add Attribute Add
    //     Route::post('/add-more-choice-option', [ProductController::class, 'add_more_choice_option'])->name('products.add-more-choice-option');
    //     // ajax product page //
    //     Route::get('/category/subcategory/ajax/{category_id}', [ProductController::class, 'GetSubProductCategory']);
    //     Route::get('/subcategory/minicategory/ajax/{subcategory_id}', [ProductController::class, 'GetSubSubCategory']);
    // });

    // Payment Methods Route
    Route::get('/payment-methods/configuration', [PaymentMethodController::class, 'index'])->name('paymentMethod.config');
    Route::post('/payment-methods/update', [PaymentMethodController::class, 'update'])->name('paymentMethod.update');
    // payment status
    Route::post('/orders/update_payment_status', [OrderController::class, 'update_payment_status'])->name('orders.update_payment_status');
    // delivery status
    Route::post('/orders/update_delivery_status', [OrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');

    /*================  Admin Address Updated  ==================*/
    Route::post('/address/update/{id}', [OrderController::class, 'admin_address_update'])->name('address.update');
    /*================  Admin User Updated  ==================*/
    Route::post('/user/update/{id}', [OrderController::class, 'admin_user_update'])->name('user.update');
    /*================  Ajax  ==================*/
    Route::get('/division-district/ajax/{division_id}', [OrderController::class, 'getdivision'])->name('division.ajax');
    Route::get('/district-upazilla/ajax/{district_id}', [OrderController::class, 'getupazilla'])->name('upazilla.ajax');
    /*================  Ajax  ==================*/

    Route::prefix('requests')->group(function () {
        // Orders All Route
        Route::get('/all-requests', [OrderController::class, 'index'])->name('all_request.index');
        Route::get('/all-request/{id}/show', [OrderController::class, 'show'])->name('all_request.show');
        Route::get('/request-delete/{id}', [OrderController::class, 'destroy'])->name('delete.request');
        // Route::post('/orders_update/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
        // Route::get('/invoice/{id}', [OrderController::class, 'invoice_download'])->name('invoice.download');
        // Route::get('/print/invoice/{order}', [OrderController::class, 'invoice_print_download'])->name('print.invoice.download');
    });
    Route::prefix('orders')->group(function () {
        Route::get('/dealer/all', [OrderController::class, 'dealerOrderIndex'])->name('order.confirm');
        Route::get('/dealer/{id}/show', [OrderController::class, 'dealerShow'])->name('order.show');
        Route::get('/dealer/invoice/{id}', [OrderController::class, 'dealerInvoiceDownload'])->name('invoice.download');
    });

    //Admin POS All Routes
    Route::prefix('pos')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('pos.index');
        Route::get('/product/{id}', [PosController::class, 'getProduct'])->name('pos.getProduct');
        Route::post('/get-products', [PosController::class, 'filter'])->name('pos.filter');
        Route::POST('/store', [PosController::class, 'store'])->name('pos.request.store');
    });
    // Route::post('/pos/customer/insert',[PosController::class,'customerInsert'])->name('customer.ajax.store.pos');

});
require __DIR__ . '/auth.php';
