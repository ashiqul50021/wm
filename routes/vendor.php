<?php

use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Vendor\AccountsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VendorAdminController;
use App\Http\Controllers\Vendor\BrandController;
use App\Http\Controllers\Vendor\CategoryController;
use App\Http\Controllers\Vendor\SupplierController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\AttributeController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\PaymentMethodController;
use App\Http\Controllers\Vendor\ReportController;
use App\Http\Controllers\Vendor\PosController;
use App\Http\Controllers\Vendor\RoleController;
use App\Http\Controllers\Vendor\StaffController;
use App\Http\Controllers\Vendor\UserController;

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

/*========================== Start Vendor Route  ==========================*/

Route::get('/vendor/login', [VendorAdminController::class, 'index'])->name('vendor.login_form');
Route::post('/vendor/login', [VendorAdminController::class, 'login'])->name('vendor.login');

Route::get('/vendor-register', [VendorAdminController::class, 'vendorRegister'])->name('vendor.register');
Route::post('/register/store', [VendorAdminController::class, 'vendorRegisterStore'])->name('vendor.register.store');

// Vendor All Routes
Route::prefix('vendor')->name('vendor.')->middleware('vendor')->group(function () {
    Route::get('/dashboard', [VendorAdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [VendorAdminController::class, 'vendorLogout'])->name('logout');

    Route::get('/forgot-password', [VendorAdminController::class, 'AdminForgotPassword'])->name('password.request');
    Route::get('/profile', [VendorAdminController::class, 'profile'])->name('profile');
    Route::get('/edit/profile', [VendorAdminController::class, 'editProfile'])->name('edit.profile');
    Route::post('/store/profile', [VendorAdminController::class, 'storeProfileUpdate'])->name('store.storeProfileUpdate');
    Route::get('/change/password', [VendorAdminController::class, 'changePassword'])->name('change.password');
    Route::post('/update/password', [VendorAdminController::class, 'updatePassword'])->name('update.password');

    /* ================ Vendor Cache Clear ============== */
    Route::get('/cache-cache', [VendorAdminController::class, 'clearCache'])->name('cache.clear');


    // ==================== Vendor Brand All Routes ===================//
    Route::prefix('brand')->group(function () {
        Route::get('/view', [BrandController::class, 'BrandView'])->name('brand.all');
        Route::get('/add', [BrandController::class, 'BrandAdd'])->name('brand.add');
        Route::post('/store', [BrandController::class, 'BrandStore'])->name('brand.store');
        Route::get('/edit/{id}', [BrandController::class, 'BrandEdit'])->name('brand.edit');
        Route::post('/update/{id}', [BrandController::class, 'BrandUpdate'])->name('brand.update');
        Route::get('/delete/{id}', [BrandController::class, 'BrandDelete'])->name('brand.delete');
        Route::get('/brand_active/{id}', [BrandController::class, 'active'])->name('brand.active');
        Route::get('/brand_inactive/{id}', [BrandController::class, 'inactive'])->name('brand.in_active');
    });

    // Vendor Category All Routes
    Route::prefix('category')->group(function () {

        Route::get('/index', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

        Route::get('/category_active/{id}', [CategoryController::class, 'active'])->name('category.active');
        Route::get('/category_inactive/{id}', [CategoryController::class, 'inactive'])->name('category.in_active');

        Route::get('/category_feature_status_change/{id}', [CategoryController::class, 'changeFeatureStatus'])->name('category.changeFeatureStatus');
    });

    // Vendor Brand All Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/view', [SupplierController::class, 'SupplierView'])->name('supplier.all');
        Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/create', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::get('/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('/supplier_active/{id}', [SupplierController::class, 'active'])->name('supplier.active');
        Route::get('/supplier_inactive/{id}', [SupplierController::class, 'inactive'])->name('supplier.in_active');
    });

    // Vendor Product All Routes
    Route::prefix('product')->group(function () {
        Route::get('/view', [ProductController::class, 'ProductView'])->name('product.all');
        Route::get('/add', [ProductController::class, 'ProductAdd'])->name('product.add');
        Route::post('/store', [ProductController::class, 'StoreProduct'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'EditProduct'])->name('product.edit');
        Route::get('/duplicate-product/{id}', [ProductController::class, 'duplicateProduct'])->name('product.duplicate');
        Route::get('/product_reviews', [ProductController::class, 'productReviews'])->name('product.productReviews');
        Route::get('/barcode-genarate/{id}', [ProductController::class, 'barcodeGenarate'])->name('product.barcodeGenarate');
        Route::post('/product_reviews_published/{id}', [ProductController::class, 'productReviewsPublished'])->name('product.productReviewsPublished');

        Route::post('/update/{id}', [ProductController::class, 'ProductUpdate'])->name('product.update');

        Route::get('/multiimg/delete/{id}', [ProductController::class, 'MultiImageDelete'])->name('product.multiimg.delete');

        Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');

        Route::get('/product_active/{id}', [ProductController::class, 'active'])->name('product.active');
        Route::get('/product_inactive/{id}', [ProductController::class, 'inactive'])->name('product.in_active');

        Route::get('/product_featured/{id}', [ProductController::class, 'featured'])->name('product.featured');

        // Add Attribute Add
        Route::post('/add-more-choice-option', [ProductController::class, 'add_more_choice_option'])->name('products.add-more-choice-option');

        // ajax product page //
        Route::get('/category/subcategory/ajax/{category_id}', [ProductController::class, 'GetSubProductCategory']);
        Route::get('/subcategory/minicategory/ajax/{subcategory_id}', [ProductController::class, 'GetSubSubCategory']);
    });

    // Attribute All Route
    Route::resource('/attribute', AttributeController::class);
    Route::get('/attribute/delete/{id}', [AttributeController::class, 'destroy'])->name('attribute.delete');

    // AttributeValue All Route
    Route::post('/attribute/value', [AttributeController::class, 'value_store'])->name('attribute.value_store');
    Route::get('/attribute/value/edit/{id}', [AttributeController::class, 'value_edit'])->name('attribute_value.edit');
    Route::post('/attribute/value/update/{id}', [AttributeController::class, 'value_update'])->name('attribute.val_update');
    Route::get('/attribute_value_active/{id}', [AttributeController::class, 'value_active'])->name('attribute_value.active');
    Route::get('/attribute_value_inactive/{id}', [AttributeController::class, 'value_inactive'])->name('attribute_value.in_active');
    Route::get('/attribute/value/delete/{id}', [AttributeController::class, 'value_destroy'])->name('attribute_value.delete');

    Route::get('/attributes/combination', [AttributeController::class, 'combination'])->name('combination.index');

    //Unit All Route
    Route::get('/unit', [AttributeController::class, 'index_unit'])->name('unit.index');
    Route::get('/unit/create', [AttributeController::class, 'create_unit'])->name('unit.create');
    Route::post('/unit/store', [AttributeController::class, 'store_unit'])->name('unit.store');
    Route::get('/unit/edit/{id}', [AttributeController::class, 'edit_unit'])->name('unit.edit');
    Route::post('/unit/update/{id}', [AttributeController::class, 'update_unit'])->name('unit.update');
    Route::get('/unit/delete/{id}', [AttributeController::class, 'destroy_unit'])->name('unit.delete');
    Route::get('/unit-status/{id}', [AttributeController::class, 'changeStatus'])->name('unit.changeStatus');
    // Report All Route
    Route::get('/stock_report', [ReportController::class, 'index'])->name('stock_report.index');
    Route::get('/sale_report', [ReportController::class, 'saleReport'])->name('saleReport');
    Route::get('/pos_sale_report', [ReportController::class, 'posSaleReport'])->name('posSaleReport');

    // Vendor Customer All Routes
    Route::resource('/customer', UserController::class);
    Route::prefix('orders')->group(function () {
        // Orders All Route
        Route::get('/all_orders', [OrderController::class, 'index'])->name('all_orders.index');
        Route::get('/all_orders/{id}/show', [OrderController::class, 'show'])->name('all_orders.show');

        Route::get('/orders_delete/{id}', [OrderController::class, 'destroy'])->name('delete.orders');
        Route::post('/orders_update/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::get('/invoice/{id}', [OrderController::class, 'invoice_download'])->name('invoice.download');
        Route::get('/print/invoice/{order}', [OrderController::class, 'invoice_print_download'])->name('print.invoice.download');
    });

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

    /*================  Ajax Category Store ==================*/
    Route::post('/category/insert', [ProductController::class, 'categoryInsert'])->name('category.ajax.store');
    /*================  Ajax Brand Store ==================*/
    Route::post('/brand/insert', [ProductController::class, 'brandInsert'])->name('brand.ajax.store');




    /*
    |-----------------------------------------------------------------------------
    |VENDOR POS ROUTES
    |-----------------------------------------------------------------------------
    */
    Route::prefix('pos')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('pos.index');
        Route::post('/get-products', [PosController::class, 'filter'])->name('pos.filter');
        Route::get('/vendor-get-count-products', [PosController::class, 'vendorgetCountProducts'])->name('pos.vendorgetCountProducts');
        Route::POST('/store', [PosController::class, 'store'])->name('pos.store');
        Route::get('/view-order/{id}', [PosController::class, 'viewPosOrder'])->name('pos.viewPosOrder');
        Route::get('/order-print/{id}', [PosController::class, 'orderPrint'])->name('pos.orderPrint');
        Route::get('/product/{id}', [PosController::class, 'getProduct'])->name('pos.getProduct');
        Route::post('/add-to-list', [PosController::class, 'addToList'])->name('pos.addToList');
        Route::post('/update-quantity/{id}', [PosController::class, 'updateQuantity'])->name('pos.updateQuantity');
        Route::get('/remove-product/{id}', [PosController::class, 'removeProduct'])->name('pos.removeProduct');
        Route::post('/update-calculate', [PosController::class, 'updateCalculate'])->name('pos.updateCalculate');
        Route::get('/get-pos-products', [PosController::class, 'getPosProduct'])->name('pos.getPosProduct');
        Route::post('/update-discount/{id}', [PosController::class, 'updateDiscount'])->name('pos.updateDiscount');
        Route::post('/update-discount-type/{id}', [PosController::class, 'updateDiscountType'])->name('pos.updateDiscountType');
        Route::post('/get-customer', [PosController::class, 'getCustomer'])->name('pos.getCustomer');
        Route::post('/get-customer-by-phone', [PosController::class, 'getCustomerByPhone'])->name('pos.getCustomerByPhone');
        // order
        Route::get('/order-list', [PosController::class, 'orderList'])->name('pos.orderList');
        Route::get('/order-list/show/{id}', [PosController::class, 'orderShow'])->name('pos.orderShow');
        Route::get('/order-list/delete/{id}', [PosController::class, 'orderDelete'])->name('pos.orderDelete');
        Route::get('/due-list', [PosController::class, 'orderDue'])->name('pos.orderDue');
        Route::get('/due-collect/{id}', [PosController::class, 'dueCollect'])->name('pos.dueCollect');
        Route::post('/due-collect-update/{id}', [PosController::class, 'dueCollectUpdate'])->name('pos.dueCollectUpdate');
        Route::get('/due-collec-info',[PosController::class,'dueCollectInfo'])->name('pos.dueCollectInfo');
        Route::get('/due-collec-info/print/{id}',[PosController::class,'dueCollectInfoPrint'])->name('pos.dueCollectInfoPrint');
        Route::get('/due-collec-info/delete/{id}',[PosController::class,'dueCollectInfoDelete'])->name('pos.dueCollectInfo.delete');
    });
    Route::post('/pos/customer/insert', [PosController::class, 'customerInsert'])->name('customer.ajax.store.pos');



    /*
    |-----------------------------------------------------------------------------
    |VENDOR STAFF ROUTES
    |-----------------------------------------------------------------------------
    */
    Route::prefix('staff')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/store', [StaffController::class, 'store'])->name('staff.store');
        Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
        Route::post('/update/{id}', [StaffController::class, 'update'])->name('staff.update');
        Route::get('/delete/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
    });


    /*
    |-----------------------------------------------------------------------------
    |VENDOR ROLES & PERMISSION ROUTES
    |-----------------------------------------------------------------------------
    */
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });



    /*
    |-----------------------------------------------------------------------------
    |ACCOUNT ROUTE
    |-----------------------------------------------------------------------------
    */
    Route::prefix('accounts')->group(function () {
        Route::get('/account-ledgers', [AccountsController::class, 'ledgers'])->name('accounts.ledgers');
        Route::get('/account-ledgers/create', [AccountsController::class, 'create_ledger'])->name('accounts.ledgers.create');
        Route::post('/account-ledgers/store', [AccountsController::class, 'store_ledger'])->name('accounts.ledgers.store');
        Route::post('/account-ledgers/report', [AccountsController::class, 'ledger_report'])->name('accounts.leagers.report');
        Route::get('/account-ledgers/report/print', [AccountsController::class, 'ledger_report_print'])->name('accounts.ledgers.report_print');
        Route::get('/account-ledgers/delete/{id}', [AccountsController::class, 'ledger_destroy'])->name('accounts.ledgers.delete');
    });







    Route::get('/settings/index', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('update.setting');
    Route::get('/settings/activation', [SettingController::class, 'activation'])->name('setting.activation');
});
require __DIR__ . '/auth.php';
