<?php

use App\Http\Controllers\Seller\SellerAttributeController;
use App\Http\Controllers\Seller\SellerBrandController;
use App\Http\Controllers\Seller\SellerCategoryController;
use App\Http\Controllers\Seller\SellerCommissionController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerReportController;
use App\Http\Controllers\Seller\SellerSupplierController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| LOGIN ROUTES FOR WORKER (ROUTE)
|--------------------------------------------------------------------------
*/
Route::get('/seller/login',[SellerController::class, 'index'])->name('seller.login_form');
Route::post('/seller/login',[SellerController::class, 'login'])->name('seller.login');
Route::get('/seller/signup',[SellerController::class, 'sellerRegister'])->name('seller.register_form');
Route::post('/register/store', [SellerController::class, 'sellerRegisterStore'])->name('seller.register.store');




/*
|--------------------------------------------------------------------------
|  ROUTES FOR WORKER (ROUTE)
|--------------------------------------------------------------------------
*/
Route::prefix('seller')->name('seller.')->middleware('seller')->group(function(){
	Route::get('/dashboard',[SellerController::class, 'dashboard'])->name('dashboard');
	Route::get('/logout',[SellerController::class, 'sellerLogout'])->name('logout');
	Route::get('/profile',[SellerController::class, 'profile'])->name('profile');
	Route::get('/edit/profile',[SellerController::class, 'editProfile'])->name('edit.profile');
	Route::post('/store/profile',[SellerController::class, 'storeProfile'])->name('store.profile');
	Route::get('/change/password',[SellerController::class, 'changePassword'])->name('change.password');
	Route::post('/update/password',[SellerController::class, 'updatePassword'])->name('update.password');

	/* ================ Seller Cache Clear ============== */
	Route::get('/cache-cache',[SellerController::class, 'clearCache'])->name('cache.clear');


	// Worker Payment Route
    Route::prefix('payment')->group(function(){
		Route::get('/index', [SellerController::class, 'viewPayment'])->name('worker.viewPayment');

	});

    // ==================== Seller Brand All Routes ===================//
    Route::prefix('brand')->group(function () {
        Route::get('/view', [SellerBrandController::class, 'BrandView'])->name('brand.all');
        Route::get('/add', [SellerBrandController::class, 'BrandAdd'])->name('brand.add');
        Route::post('/store', [SellerBrandController::class, 'BrandStore'])->name('brand.store');
        Route::get('/edit/{id}', [SellerBrandController::class, 'BrandEdit'])->name('brand.edit');
        Route::post('/update/{id}', [SellerBrandController::class, 'BrandUpdate'])->name('brand.update');
        Route::get('/delete/{id}', [SellerBrandController::class, 'BrandDelete'])->name('brand.delete');
        Route::get('/brand_active/{id}', [SellerBrandController::class, 'active'])->name('brand.active');
        Route::get('/brand_inactive/{id}', [SellerBrandController::class, 'inactive'])->name('brand.in_active');
    });

    // Seller Category All Routes
    Route::prefix('category')->group(function () {

        Route::get('/index', [SellerCategoryController::class, 'index'])->name('category.index');
        Route::get('/create', [SellerCategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [SellerCategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{id}', [SellerCategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [SellerCategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [SellerCategoryController::class, 'destroy'])->name('category.delete');

        Route::get('/category_active/{id}', [SellerCategoryController::class, 'active'])->name('category.active');
        Route::get('/category_inactive/{id}', [SellerCategoryController::class, 'inactive'])->name('category.in_active');

        Route::get('/category_feature_status_change/{id}', [SellerCategoryController::class, 'changeFeatureStatus'])->name('category.changeFeatureStatus');
    });

    // Seller Supplier All Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/view', [SellerSupplierController::class, 'SupplierView'])->name('supplier.all');
        Route::get('/create', [SellerSupplierController::class, 'create'])->name('supplier.create');
        Route::post('/create', [SellerSupplierController::class, 'store'])->name('supplier.store');
        Route::get('/edit/{id}', [SellerSupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/update/{id}', [SellerSupplierController::class, 'update'])->name('supplier.update');
        Route::get('/delete/{id}', [SellerSupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('/supplier_active/{id}', [SellerSupplierController::class, 'active'])->name('supplier.active');
        Route::get('/supplier_inactive/{id}', [SellerSupplierController::class, 'inactive'])->name('supplier.in_active');
    });

    // Seller Product All Routes
    Route::prefix('product')->group(function () {
        Route::get('/view', [SellerProductController::class, 'ProductView'])->name('product.all');
        Route::get('/add', [SellerProductController::class, 'ProductAdd'])->name('product.add');
        Route::post('/store', [SellerProductController::class, 'StoreProduct'])->name('product.store');
        Route::get('/edit/{id}', [SellerProductController::class, 'EditProduct'])->name('product.edit');
        Route::get('/duplicate-product/{id}', [SellerProductController::class, 'duplicateProduct'])->name('product.duplicate');
        Route::get('/product_reviews', [SellerProductController::class, 'productReviews'])->name('product.productReviews');
        Route::get('/barcode-genarate/{id}', [SellerProductController::class, 'barcodeGenarate'])->name('product.barcodeGenarate');
        Route::post('/product_reviews_published/{id}', [SellerProductController::class, 'productReviewsPublished'])->name('product.productReviewsPublished');

        Route::post('/update/{id}', [SellerProductController::class, 'ProductUpdate'])->name('product.update');

        Route::get('/multiimg/delete/{id}', [SellerProductController::class, 'MultiImageDelete'])->name('product.multiimg.delete');

        Route::get('/delete/{id}', [SellerProductController::class, 'ProductDelete'])->name('product.delete');

        Route::get('/product_active/{id}', [SellerProductController::class, 'active'])->name('product.active');
        Route::get('/product_inactive/{id}', [SellerProductController::class, 'inactive'])->name('product.in_active');

        Route::get('/product_featured/{id}', [SellerProductController::class, 'featured'])->name('product.featured');

        // Add Attribute Add
        Route::post('/add-more-choice-option', [SellerProductController::class, 'add_more_choice_option'])->name('products.add-more-choice-option');

        // ajax product page //
        Route::get('/category/subcategory/ajax/{category_id}', [SellerProductController::class, 'GetSubProductCategory']);
        Route::get('/subcategory/minicategory/ajax/{subcategory_id}', [SellerProductController::class, 'GetSubSubCategory']);

          /*================  Ajax Category Store ==================*/
    Route::post('/category/insert', [SellerProductController::class, 'categoryInsert'])->name('category.ajax.store');
    /*================  Ajax Brand Store ==================*/
    Route::post('/brand/insert', [SellerProductController::class, 'brandInsert'])->name('brand.ajax.store');
    });

    // Attribute All Route
    Route::resource('/attribute', SellerAttributeController::class);
    Route::get('/attribute/delete/{id}', [SellerAttributeController::class, 'destroy'])->name('attribute.delete');

    // AttributeValue All Route
    Route::post('/attribute/value', [SellerAttributeController::class, 'value_store'])->name('attribute.value_store');
    Route::get('/attribute/value/edit/{id}', [SellerAttributeController::class, 'value_edit'])->name('attribute_value.edit');
    Route::post('/attribute/value/update/{id}', [SellerAttributeController::class, 'value_update'])->name('attribute.val_update');
    Route::get('/attribute_value_active/{id}', [SellerAttributeController::class, 'value_active'])->name('attribute_value.active');
    Route::get('/attribute_value_inactive/{id}', [SellerAttributeController::class, 'value_inactive'])->name('attribute_value.in_active');
    Route::get('/attribute/value/delete/{id}', [SellerAttributeController::class, 'value_destroy'])->name('attribute_value.delete');

    Route::get('/attributes/combination', [SellerAttributeController::class, 'combination'])->name('combination.index');

    //Unit All Route
    Route::get('/unit', [SellerAttributeController::class, 'index_unit'])->name('unit.index');
    Route::get('/unit/create', [SellerAttributeController::class, 'create_unit'])->name('unit.create');
    Route::post('/unit/store', [SellerAttributeController::class, 'store_unit'])->name('unit.store');
    Route::get('/unit/edit/{id}', [SellerAttributeController::class, 'edit_unit'])->name('unit.edit');
    Route::post('/unit/update/{id}', [SellerAttributeController::class, 'update_unit'])->name('unit.update');
    Route::get('/unit/delete/{id}', [SellerAttributeController::class, 'destroy_unit'])->name('unit.delete');
    Route::get('/unit-status/{id}', [SellerAttributeController::class, 'changeStatus'])->name('unit.changeStatus');
    // Report All Route
    Route::get('/stock_report', [SellerReportController::class, 'index'])->name('stock_report.index');
    Route::get('/sale_report', [SellerReportController::class, 'saleReport'])->name('saleReport');
    Route::get('/pos_sale_report', [SellerReportController::class, 'posSaleReport'])->name('posSaleReport');


    // commission Part

    Route::get('/seller_commission', [SellerCommissionController::class, 'sellerCommission'])->name('commission');

});






require __DIR__.'/auth.php';
