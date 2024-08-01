<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SupplierController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Backend\DealerController;
use App\Http\Controllers\Backend\CampaingController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\ShippingController;
use App\Http\Controllers\Backend\PaymentMethodController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SmsController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\StaffController;
use App\Http\Controllers\Backend\SubscriberController;
use App\Http\Controllers\Backend\AccountsController;
use App\Http\Controllers\Backend\AdminSellerCommissionController;
use App\Http\Controllers\Backend\AdminSellerController;
use App\Http\Controllers\Backend\ManufactureController;
use App\Http\Controllers\Backend\PosController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WorkerController;
use App\Http\Controllers\Seller\SellerController;

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


/*========================== Start Admin Route  ==========================*/

Route::get('/admin', [AdminController::class, 'Index'])->name('admin.login_form');
Route::post('/admin', [AdminController::class, 'Login'])->name('admin.login');

// Admin All Routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'AminLogout'])->name('admin.logout');
    Route::get('/register', [AdminController::class, 'AdminRegister'])->name('admin.regester');
    Route::post('/register/store', [AdminController::class, 'AdminRegisterStore'])->name('admin.register.store');
    Route::get('/forgot-password', [AdminController::class, 'AdminForgotPassword'])->name('admin.password.request');
    Route::get('/profile', [AdminController::class, 'Profile'])->name('admin.profile');
    Route::get('/edit/profile', [AdminController::class, 'EditProfile'])->name('edit.profile');
    Route::post('/store/profile', [AdminController::class, 'StoreProfile'])->name('store.profile');
    Route::get('/change/password', [AdminController::class, 'ChangePassword'])->name('change.password');
    Route::post('/update/password', [AdminController::class, 'UpdatePassword'])->name('update.password');

    /* ================ Admin Cache Clear ============== */
    Route::get('/cache-cache', [AdminController::class, 'clearCache'])->name('cache.clear');

    // ==================== Admin Brand All Routes ===================//
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

    // Admin Category All Routes
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

    // Admin Brand All Routes
    Route::prefix('supplier')->group(function () {
        Route::get('/view', [SupplierController::class, 'SupplierView'])->name('supplier.all');
        Route::get('/create', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/create', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::get('/view-info/{id}', [SupplierController::class, 'viewInfo'])->name('supplier.viewInfo');
        Route::post('/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::get('/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
        Route::get('/supplier_active/{id}', [SupplierController::class, 'active'])->name('supplier.active');
        Route::get('/supplier_inactive/{id}', [SupplierController::class, 'inactive'])->name('supplier.in_active');
    });

    // Admin Tags All Routes
    Route::prefix('tag')->group(function () {
        Route::get('/view', [TagController::class, 'TagView'])->name('tag.all');
        Route::get('/add', [TagController::class, 'TagAdd'])->name('tag.add');
        Route::post('/store', [TagController::class, 'TagStore'])->name('tag.store');
        Route::get('/edit/{id}', [TagController::class, 'TagEdit'])->name('tag.edit');
        Route::post('/update/{id}', [TagController::class, 'TagUpdate'])->name('tag.update');
        Route::get('/delete/{id}', [TagController::class, 'TagDelete'])->name('tag.delete');
        Route::get('/tag_active/{id}', [TagController::class, 'active'])->name('tag.active');
        Route::get('/tag_inactive/{id}', [TagController::class, 'inactive'])->name('tag.in_active');
    });

    // Admin Product All Routes
    Route::prefix('product')->group(function () {
        Route::get('/view', [ProductController::class, 'ProductView'])->name('product.all');

        Route::post('/update-quantity/ajax/{id}', [ProductController::class, 'updateQuantity'])->name('update.quantity');
        Route::get('/add', [ProductController::class, 'ProductAdd'])->name('product.add');
        Route::post('/store', [ProductController::class, 'StoreProduct'])->name('product.store');

        Route::post('/store-duplicate', [ProductController::class, 'StoreDuplicateProduct'])->name('product.duplicate.store');
        Route::get('/edit/{id}', [ProductController::class, 'EditProduct'])->name('product.edit');
        Route::get('/quantity/information/{id}', [ProductController::class, 'quantityInformation'])->name('product.quantity.info');
        Route::get('/duplicate/{id}', [ProductController::class, 'DuplicateProduct'])->name('product.duplicate');

        Route::post('/update/{id}', [ProductController::class, 'ProductUpdate'])->name('product.update');

        Route::get('/multiimg/delete/{id}', [ProductController::class, 'MultiImageDelete'])->name('product.multiimg.delete');

        Route::get('/delete/{id}', [ProductController::class, 'ProductDelete'])->name('product.delete');


        Route::get('/product_reviews', [ProductController::class, 'productReviews'])->name('product.productReviews');
        Route::get('/barcode-genarate/{id}', [ProductController::class, 'barcodeGenarate'])->name('product.barcodeGenarate');
        Route::post('/product_reviews_published/{id}', [ProductController::class, 'productReviewsPublished'])->name('product.productReviewsPublished');
        Route::get('/product_reviews_delete/{id}', [ProductController::class, 'productReviewsDelete'])->name('product.productReviewsDelete');
        Route::get('/product_active/{id}', [ProductController::class, 'active'])->name('product.active');

        Route::get('/product_inactive/{id}', [ProductController::class, 'inactive'])->name('product.in_active');

        Route::get('/product_featured/{id}', [ProductController::class, 'featured'])->name('product.featured');
        Route::get('/product_approved/{id}', [ProductController::class, 'approved'])->name('product.approved');

        // Add Attribute Add
        Route::post('/add-more-choice-option', [ProductController::class, 'add_more_choice_option'])->name('products.add-more-choice-option');

        // ajax product page //
        Route::get('/category/subcategory/ajax/{category_id}', [ProductController::class, 'GetSubProductCategory']);
        Route::get('/subcategory/minicategory/ajax/{subcategory_id}', [ProductController::class, 'GetSubSubCategory']);


        // Menufacturing Image
        Route::get('/menufacturing-image', [ProductController::class, 'menufacturingImage'])->name('menufacturing.index');
        Route::get('/menufacturing-image/{id}', [ProductController::class, 'menufacturingImagePrint'])->name('menufacturing.print');
        Route::get('/save-qty/{id}/{qty}', [ProductController::class, 'saveQty'])->name('save.qty');
        Route::get('/save-staff/{staffId}/{id}', [ProductController::class, 'saveStaff'])->name('save.staff');
        Route::get('/menufacturing-image/type/{type}', [ProductController::class, 'menufacturingImageType'])->name('menufacturing.type');
        Route::get('/menufacturing-image-barcode', [ProductController::class, 'menufacturingImageBarcode'])->name('menufacturingImageBarcode');
    });


    // Admin Manufacture All Route
    Route::prefix('manufacture')->group(function () {
        Route::get('/index', [ManufactureController::class, 'index'])->name('manufacture.index');
        Route::get('/date_worker_search', [ManufactureController::class, 'dateAndWorkerWiseSearch'])->name('date.worker.search');
        Route::get('/pending_date_worker_search', [ManufactureController::class, 'pendingDateSearch'])->name('pendingDateSearch');
        Route::get('/confirmed_date_worker_search', [ManufactureController::class, 'confirmedDateSearch'])->name('confirmedDateSearch');
        Route::get('/create', [ManufactureController::class, 'create'])->name('manufacture.create');
        Route::post('/store', [ManufactureController::class, 'store'])->name('manufacture.store');
        Route::get('/pending', [ManufactureController::class, 'pendingOrder'])->name('manufacture.pending');
        Route::get('/confirmed', [ManufactureController::class, 'confirmedOrder'])->name('manufacture.confirmed');
        Route::get('/completed-order', [ManufactureController::class, 'completedOrder'])->name('manufacture.complete');
        Route::post('/manufacture-search-product', [ManufactureController::class, 'manufactureSearchProduct'])->name('manufacture.search.product');
        Route::get('/edit/{id}', [ManufactureController::class, 'edit'])->name('manufacture.edit');
        Route::post('/update/{id}', [ManufactureController::class, 'update'])->name('manufacture.update');
        Route::get('/manufacture-stock', [ManufactureController::class, 'ManufactureStock'])->name('manufacture.manufactureStock');
        Route::get('/manufacture-stock/delete/{id}', [ManufactureController::class, 'ManufactureStockDelete'])->name('manufacture.ManufactureStockDelete');
        Route::get('/manufacture-payment-info', [ManufactureController::class, 'ManufacturePaymentInfo'])->name('manufacture.ManufacturePaymentInfo');
        Route::get('/manufacture-payment-expense', [ManufactureController::class, 'ManufacturePaymentExpense'])->name('manufacture.ManufacturePayment.expense');
        Route::get('/print-payment-info/{id}', [ManufactureController::class, 'PrintPaymentInfo'])->name('manufacture.PrintPaymentInfo');
        Route::get('/delete-payment-info/{id}', [ManufactureController::class, 'deletePaymentInfo'])->name('manufacture.deletePaymentInfo');
        Route::get('/delete-payment-expense/{id}', [ManufactureController::class, 'deleteExpense'])->name('manufacture.delete.expense');
        Route::get('/bodypart-order-info', [ManufactureController::class, 'bodyPartOrderInfo'])->name('manufacture.bodyPartOrderInfo');
        Route::get('/get-manufacture-by-id/{id}', [ManufactureController::class, 'getManufactureByid'])->name('manufacture.getManufactureByid');
        Route::post('/post-manufacture-by-id/{id}', [ManufactureController::class, 'postManufactureByid'])->name('manufacture.postManufactureByid');

        // Route::get('/discard-order/{id}', [ManufactureController::class, 'discardOrder'])->name('manufacture.discardOrder');
        Route::post('/confirm-order/{id}', [ManufactureController::class, 'confirmOrder'])->name('manufacture.confirmOrder');
        Route::get('/complete-order{id}', [ManufactureController::class, 'completeOrder'])->name('manufacture.completeOrder');
        Route::get('/incomplete-order{id}', [ManufactureController::class, 'incompleteOrder'])->name('manufacture.incompleteOrder');
        Route::get('/order-payment', [ManufactureController::class, 'orderPayment'])->name('manufacture.orderPayment');
        Route::get('/get-order/{code}', [ManufactureController::class, 'getOrder'])->name('manufacture.getOrder');
        Route::post('/paymnet-store', [ManufactureController::class, 'paymentStore'])->name('manufacture.paymentStore');
        Route::get('/payment-list', [ManufactureController::class, 'paymentList'])->name('manufacture.paymentList');
        Route::get('/payment-edit/{id}', [ManufactureController::class, 'paymentEdit'])->name('manufacture.paymentedit');
        Route::post('/payment-update/{id}', [ManufactureController::class, 'paymentUpdate'])->name('manufacture.paymentUpdate');
        Route::get('/delete/{id}', [ManufactureController::class, 'destroy'])->name('manufacture.delete');
        Route::get('/order-delete/{id}', [ManufactureController::class, 'destroyOrder'])->name('manufacture.orderDelete');
        Route::get('/order-print/{id}', [ManufactureController::class, 'orderPrint'])->name('manufacture.printOrder');
        Route::get('/get-product-id/{id}', [ManufactureController::class, 'GetProductId'])->name('GetProductId');
        Route::get('/get-product-manufacture/{id}', [ManufactureController::class, 'GetProductOrder'])->name('GetProductOrder');
        Route::post('/get-worker-manufacture', [ManufactureController::class, 'GetWorkerManufacture'])->name('GetWorkerManufacture');
        Route::post('/get-dealer-manufacture',[ManufactureController::class, 'getDealerManufacture'])->name('getDealerManufacture');


    });

    // Admin Slider All Routes
    Route::resource('/slider', SliderController::class);
    Route::get('/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
    Route::get('/slider_active/{id}', [SliderController::class, 'active'])->name('slider.active');
    Route::get('/slider_inactive/{id}', [SliderController::class, 'inactive'])->name('slider.in_active');

    // Admin Vendor All Routes
    Route::resource('/vendor', VendorController::class);
    Route::get('/vendor/delete/{id}', [VendorController::class, 'destroy'])->name('vendor.delete');
    Route::get('/vendor/admin/change-password/{id}', [VendorController::class, 'changePassowrd'])->name('vendor.adminChangePassword');
    Route::post('/vendor/admin/update-password/{id}', [VendorController::class, 'updatePassword'])->name('vendor.adminUpdatePassword');
    Route::get('/vendor_active/{id}', [VendorController::class, 'active'])->name('vendor.active');
    Route::get('/vendor_inactive/{id}', [VendorController::class, 'inactive'])->name('vendor.in_active');
    Route::get('/vendor-approved/{id}', [VendorController::class, 'approved'])->name('admin.vendor.approved');

    // Admin dealer All Routes
    Route::resource('/dealer', DealerController::class);
    Route::get('/dealer/delete/{id}', [DealerController::class, 'destroy'])->name('dealer.delete');
    Route::get('/dealer_active/{id}', [DealerController::class, 'active'])->name('dealer.active');
    Route::get('/dealer_inactive/{id}', [DealerController::class, 'inactive'])->name('dealer.in_active');
    Route::get('/dealer-approved/{id}', [DealerController::class, 'approved'])->name('admin.dealer.approved');
    Route::post('/dealer-password/{id}', [DealerController::class, 'updatePassword'])->name('admin.dealer.password.update');
    Route::get('/all-request/dealer', [DealerController::class, 'DealerAllRequest'])->name('admin.dealer.all_request');
    Route::get('/all-request/{id}/show/dealer', [DealerController::class, 'showDealerRequest'])->name('admin.all_request.show');
    Route::get('/request-delete/{id}/dealer', [DealerController::class, 'destroyDealerRequest'])->name('admin.delete.request');
    Route::get('/dealer-reorder', [DealerController::class, 'dealerReorder'])->name('admin.dealer.dealerReorder');
    Route::get('/dealer-reorder/details/{id}', [DealerController::class, 'dealerReorderDetails'])->name('admin.dealer.dealerReorderDetails');




    // Admin worker all Routes
    Route::resource('/worker', WorkerController::class);
    Route::get('/worker/delete/{id}', [WorkerController::class, 'destroy'])->name('worker.delete');
    Route::get('/worker_active/{id}', [WorkerController::class, 'active'])->name('worker.active');
    Route::get('/worker_inactive/{id}', [WorkerController::class, 'inactive'])->name('worker.in_active');
    Route::get('/worker-approved/{id}', [WorkerController::class, 'approved'])->name('admin.worker.approved');
    Route::get('/workers-balance', [WorkerController::class, 'workerBalance'])->name('worker.workerBalance');
    Route::get('/workers-inactive', [WorkerController::class, 'workerInactive'])->name('worker.inactive');
    Route::get('/workers-change-status/{id}', [WorkerController::class, 'workerChangeStatus'])->name('worker.change.status');
    Route::get('/workers-payment/{id}', [WorkerController::class, 'workerPayment'])->name('worker.workerPayment');
    Route::post('/workers-payment-update/{id}', [WorkerController::class, 'workerPaymentUpdate'])->name('worker.workerPaymentUpdate');
    Route::post('/worker-password/{id}', [WorkerController::class, 'updatePassword'])->name('admin.worker.password.update');
    Route::get('/worker/registration/request', [WorkerController::class, 'workerRegistrationRequest'])->name('worker.workerRegistration');
    Route::get('/worker/registration/request/show/{id}', [WorkerController::class, 'workerRegistrationRequestShow'])->name('worker.workerRegistrationShow');
    Route::get('/worker/registration/request/accept/{id}', [WorkerController::class, 'workerRegistrationRequestAccept'])->name('worker.workerRegistrationAccept');
    Route::get('/worker/registration/request/delete/{id}', [WorkerController::class, 'workerRegistrationRequestDelete'])->name('worker.workerRegistrationDelete');


    //Admin Seller All Route

    Route::resource('/seller', AdminSellerController::class);
    Route::get('/seller/delete/{id}', [AdminSellerController::class, 'destroy'])->name('seller.delete');
    Route::get('/seller/admin/change-password/{id}', [AdminSellerController::class, 'changePassowrd'])->name('seller.adminChangePassword');
    Route::post('/seller/admin/update-password/{id}', [AdminSellerController::class, 'updatePassword'])->name('seller.adminUpdatePassword');
    Route::get('/seller_active/{id}', [AdminSellerController::class, 'active'])->name('seller.active');
    Route::get('/productRequest', [AdminSellerController::class, 'productRequest'])->name('seller.productRequest');
    Route::get('/seller_inactive/{id}', [AdminSellerController::class, 'inactive'])->name('seller.in_active');
    Route::get('/seller-approved/{id}', [AdminSellerController::class, 'approved'])->name('admin.seller.approved');
    Route::get('/seller-in_approved/{id}', [AdminSellerController::class, 'inApproved'])->name('admin.seller.inApproved');

    // Admin Seller Commission All Route
    Route::resource('/sellerCommission', AdminSellerCommissionController::class)->except(['show']);;
      // Admin Customer All Routes
    Route::resource('/customer', UserController::class);
    Route::get('/customer/delete/{id}', [UserController::class, 'customerDelete'])->name('customer.delete');
    Route::get('/outCustomer', [UserController::class, 'outCustomer'])->name('outCustomer');

    //Admin Campaign All Route
    Route::resource('/campaing', CampaingController::class);
    Route::get('/campaing/delete/{id}', [CampaingController::class, 'destroy'])->name('campaing.delete');
    Route::get('/campaing_active/{id}', [CampaingController::class, 'active'])->name('campaing.active');
    Route::get('/campaing_inactive/{id}', [CampaingController::class, 'inactive'])->name('campaing.in_active');

    Route::post('/flash_deals/product_discount', [CampaingController::class, 'product_discount'])->name('flash_deals.product_discount');
    Route::post('/flash-deals/product-discount-edit', [CampaingController::class, 'product_discount_edit'])->name('flash_deals.product_discount_edit');

    // <--------- Banner route start ------>
    Route::resource('/banner', BannerController::class);
    Route::post('/banner/update/{id}', [BannerController::class, 'update'])->name('banner.update');
    Route::get('/banner/delete/{id}', [BannerController::class, 'destroy'])->name('banner.delete');
    Route::get('/banner_active/{id}', [BannerController::class, 'active'])->name('banner.active');
    Route::get('/banner_inactive/{id}', [BannerController::class, 'inactive'])->name('banner.in_active');

    // <--------- Blog route start ------>
    Route::resource('/blog', BlogController::class);
    Route::post('/blog/update/{id}', [BlogController::class, 'update'])->name('blog.update');
    Route::get('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog.delete');
    Route::get('/blog_active/{id}', [BlogController::class, 'active'])->name('blog.active');
    Route::get('/blog_inactive/{id}', [BlogController::class, 'inactive'])->name('blog.in_active');

    // <--------- Page route start ------>
    Route::resource('/page', PageController::class);
    Route::get('/page/delete/{id}', [PageController::class, 'destroy'])->name('page.delete');
    Route::get('/page_active/{id}', [PageController::class, 'active'])->name('page.active');
    Route::get('/page_inactive/{id}', [PageController::class, 'inactive'])->name('page.in_active');

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

    //Unit All Route
    Route::get('/unit', [AttributeController::class, 'index_unit'])->name('unit.index');
    Route::get('/unit/create', [AttributeController::class, 'create_unit'])->name('unit.create');
    Route::post('/unit/store', [AttributeController::class, 'store_unit'])->name('unit.store');
    Route::get('/unit/edit/{id}', [AttributeController::class, 'edit_unit'])->name('unit.edit');
    Route::post('/unit/update/{id}', [AttributeController::class, 'update_unit'])->name('unit.update');
    Route::get('/unit/delete/{id}', [AttributeController::class, 'destroy_unit'])->name('unit.delete');
    Route::get('/unit-status/{id}', [AttributeController::class, 'changeStatus'])->name('unit.changeStatus');


    // Setting All Route
    Route::get('/settings/index', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings/update', [SettingController::class, 'update'])->name('update.setting');

    Route::get('/settings/activation', [SettingController::class, 'activation'])->name('setting.activation');

    // Facebook plugin
    Route::get('/facebook_plugin_setting', [SettingController::class, 'facebook_plugin_setting'])->name('setting.facebook_plugin_setting');
    Route::post('/facebook_plugin_setting', [SettingController::class, 'update'])->name('setting.facebook_plugin_setting');

    // Shipping Methods Route
    Route::get('/shipping/index', [ShippingController::class, 'index'])->name('shipping.index');
    Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
    Route::post('/shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
    Route::get('/shipping/edit/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
    Route::post('/shipping/update/{id}', [ShippingController::class, 'update'])->name('shipping.update');
    Route::get('/shipping/delete/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');
    Route::get('/shipping_active/{id}', [ShippingController::class, 'active'])->name('shipping.active');
    Route::get('/shipping_inactive/{id}', [ShippingController::class, 'inactive'])->name('shipping.in_active');

    Route::get('/attributes/combination', [AttributeController::class, 'combination'])->name('combination.index');

    // Payment Methods Route
    Route::get('/payment-methods/configuration', [PaymentMethodController::class, 'index'])->name('paymentMethod.config');
    Route::post('/payment-methods/update', [PaymentMethodController::class, 'update'])->name('paymentMethod.update');

    Route::prefix('orders')->group(function () {
        // Orders All Route
        Route::get('/all_orders', [OrderController::class, 'index'])->name('all_orders.index');
        Route::get('/all_orders/{id}/show', [OrderController::class, 'show'])->name('all_orders.show');
        Route::post('/update-delivery-status', [OrderController::class, 'updateDeliveryStatus'])->name('updateDeliveryStatus');

        Route::get('/orders_delete/{id}', [OrderController::class, 'destroy'])->name('delete.orders');
        Route::get('/dealer_request_confirm_orders_delete/{id}', [OrderController::class, 'dealerOrderdestroy'])->name('delete.dealerOrderdestroy');
        Route::post('/orders_update/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::get('/invoice/{id}', [OrderController::class, 'invoice_download'])->name('invoice.download');
        Route::get('/all_order-print/{id}', [OrderController::class, 'orderPrints'])->name('orderPrints');
        Route::get('/print/invoice/{order}', [OrderController::class, 'invoice_print_download'])->name('print.invoice.download');

        Route::get('/dealer/order/all', [OrderController::class, 'dealerOrderIndex'])->name('admin.dealer.order.confirm');
        Route::get('/dealer/order/delivered', [OrderController::class, 'dealerOrderDelivered'])->name('admin.dealer.order.delivered');
        Route::get('/dealer/order/due', [OrderController::class, 'dealerOrderDue'])->name('admin.dealer.order.due');
        Route::get('/dealer/order/due-delete/{id}', [OrderController::class, 'dealerOrderdueDelete'])->name('admin.dealer.order.dueDelete');
        Route::get('/dealer/order/manufacture/{id}', [OrderController::class, 'dealerOrderManufacture'])->name('admin.dealer.order.dueManufacture');
        Route::post('/dealer/order', [OrderController::class, 'dealer_order'])->name('admin.dealer.order');
        Route::get('/dealer/request-image/{id}/{dealer}', [OrderController::class, 'dealer_menuimg_print'])->name('admin.dealer.menufacturing');
        Route::get('/dealer/order/{id}/{dealer}', [OrderController::class, 'dealer_order_menuimg_print'])->name('admin.dealer.order.menufacturing');
        Route::get('/dealer/orders/{id}/show', [OrderController::class, 'dealerShow'])->name('orders.dealer.show');
        Route::get('/dealer/invoice/{id}', [OrderController::class, 'dealerInvoiceDownload'])->name('order.dealer.invoice.download');
        Route::get('/dealer/invoice-new/{id}', [OrderController::class, 'dealerNewInvoiceDownload'])->name('order.dealer.new.invoice.download');
        Route::post('/dealer-reorder/store', [OrderController::class, 'dealerReorderStore'])->name('order.dealer.dealerReorderStore');
    });

    // payment status
    Route::post('/orders/update_payment_status', [OrderController::class, 'update_payment_status'])->name('orders.update_payment_status');
    // delivery status
    Route::post('/orders/update_delivery_status', [OrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');

    // Report All Route
    Route::get('/stock_report', [ReportController::class, 'index'])->name('stock_report.index');
    Route::get('/sale_report', [ReportController::class, 'saleReport'])->name('sale_report');
    Route::get('/order_sale_report', [ReportController::class, 'OrderSaleReport'])->name('order_sale_report');
    Route::get('/search-by-allOrders-report', [ReportController::class, 'searchByAllOrderSaleReport'])->name('searchByAllOrderSaleReport');
    Route::get('/search-by-report', [ReportController::class, 'searchBySaleReport'])->name('searchBySaleReport');
    Route::get('/profit-report', [ReportController::class, 'profitReport'])->name('profit.report');
    Route::get('/show-order-profit-report', [ReportController::class, 'showOrderProfitReport'])->name('show.order.profit.report');
    Route::get('/show-pos-order-profit-report', [ReportController::class, 'showPosOrderProfitReport'])->name('show.pos.order.profit.report');
    Route::get('/all-order-profit-report', [ReportController::class, 'allOrderProfitReport'])->name('all.order.profit.report');
    Route::get('/pos-order-profit-report', [ReportController::class, 'posOrderProfitReport'])->name('pos.order.profit.report');

    /*================  Admin Address Updated  ==================*/
    Route::post('/address/update/{id}', [OrderController::class, 'admin_address_update'])->name('admin.address.update');
    /*================  Admin User Updated  ==================*/
    Route::post('/user/update/{id}', [OrderController::class, 'admin_user_update'])->name('admin.user.update');
    /*================  Ajax  ==================*/
    Route::get('/division-district/ajax/{division_id}', [OrderController::class, 'getdivision'])->name('division.ajax');
    Route::get('/district-upazilla/ajax/{district_id}', [OrderController::class, 'getupazilla'])->name('upazilla.ajax');
    /*================  Ajax  ==================*/

    /*================  Ajax Category Store ==================*/
    Route::post('/category/insert', [ProductController::class, 'categoryInsert'])->name('category.ajax.store');
    /*================  Ajax Brand Store ==================*/
    Route::post('/brand/insert', [ProductController::class, 'brandInsert'])->name('brand.ajax.store');

    // <--------- Coupon route start ------>
    Route::resource('/coupons', CouponController::class);
    Route::post('/coupon/update/{id}', [CouponController::class, 'update'])->name('coupons.update');
    Route::get('/coupon/delete/{id}', [CouponController::class, 'destroy'])->name('coupon.delete');
    Route::get('/coupon_active/{id}', [CouponController::class, 'active'])->name('coupon.active');
    Route::get('/coupon_inactive/{id}', [CouponController::class, 'inactive'])->name('coupon.in_active');

    // sms-templates //
    Route::get('/sms-templates', [SmsController::class, 'template_index'])->name('sms.templates');
    Route::post('/sms-templates/store', [SmsController::class, 'store'])->name('sms.templates.store');
    Route::post('/sms-templates/update/{template_id}', [SmsController::class, 'template_update'])->name('sms.templates.update');

    // sms-providers //
    Route::get('/sms-providers', [SmsController::class, 'provider_index'])->name('sms.providers');
    Route::post('/sms-providers/store', [SmsController::class, 'providersStore'])->name('sms.providers.store');
    Route::post('/sms-providers/update/{provider_id}', [SmsController::class, 'provider_update'])->name('sms.providers.update');

    // role premissions //
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // role premissions staffs //
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::post('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::get('/staff/delete/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    //Subscribers
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('/subscribers/destroy/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // Admin Accounting All Routes
    Route::prefix('accounts')->group(function () {
        Route::get('/account-heads', [AccountsController::class, 'heads'])->name('accounts.heads');
        Route::get('/account-heads/create', [AccountsController::class, 'create_head'])->name('accounts.heads.create');
        Route::post('/account-heads/store', [AccountsController::class, 'store_head'])->name('accounts.heads.store');
        Route::get('/account-heads/change-status/{id}', [AccountsController::class, 'change_status_head'])->name('accounts.heads.change_status');
        Route::get('/account-heads/delete/{id}', [AccountsController::class, 'head_destroy'])->name('accounts.heads.delete');
        Route::get('/account-ledgers', [AccountsController::class, 'ledgers'])->name('accounts.ledgers');
        Route::get('/account-ledgers/create', [AccountsController::class, 'create_ledger'])->name('accounts.ledgers.create');
        Route::post('/account-ledgers/store', [AccountsController::class, 'store_ledger'])->name('accounts.ledgers.store');
        Route::post('/account-ledgers/report', [AccountsController::class, 'ledger_report'])->name('accounts.leagers.report');
        Route::get('/account-ledgers/report/print', [AccountsController::class, 'ledger_report_print'])->name('accounts.ledgers.report_print');
        Route::get('/account-ledgers/delete/{id}', [AccountsController::class, 'ledger_destroy'])->name('accounts.ledgers.delete');
    });

    /*================  Ajax Customer Store ==================*/
    Route::post('/pos/customer/insert', [PosController::class, 'customerInsert'])->name('customer.ajax.store.pos');

    //Admin POS All Routes
    Route::prefix('pos')->group(function () {
        Route::get('/', [PosController::class, 'index'])->name('pos.index');
        Route::get('/product/{id}', [PosController::class, 'getProduct'])->name('pos.getProduct');
        Route::get('/get-count-products', [PosController::class, 'getCountProducts'])->name('getCountProducts');
        Route::post('/add-to-list', [PosController::class, 'addToList'])->name('pos.addToList');
        Route::get('/remove-product/{id}', [PosController::class, 'removeProduct'])->name('pos.removeProduct');
        Route::post('/update-quantity/{id}', [PosController::class, 'updateQuantity'])->name('pos.updateQuantity');
        Route::post('/update-discount/{id}', [PosController::class, 'updateDiscount'])->name('pos.updateDiscount');
        Route::post('/update-discount-type/{id}', [PosController::class, 'updateDiscountType'])->name('pos.updateDiscountType');
        Route::post('/update-unit-price/{id}', [PosController::class, 'updateUnitPrice'])->name('pos.updateUnitPrice');
        Route::post('/update-calculate', [PosController::class, 'updateCalculate'])->name('pos.updateCalculate');
        Route::get('/get-products', [PosController::class, 'filter'])->name('pos.filter');


        Route::get('/get-pos-products', [PosController::class, 'getPosProduct'])->name('pos.getPosProduct');
        Route::post('/get-customer', [PosController::class, 'getCustomer'])->name('pos.getCustomer');
        Route::post('/get-customer-by-phone', [PosController::class, 'getCustomerByPhone'])->name('pos.getCustomerByPhone');

        Route::POST('/store', [PosController::class, 'store'])->name('pos.store');
        Route::get('/view-order/{id}', [PosController::class, 'viewPosOrder'])->name('pos.viewPosOrder');
        Route::get('/order-print/{id}', [PosController::class, 'orderPrint'])->name('pos.orderPrint');
        Route::get('/barcode-product/{id}', [PosController::class, 'barcode_ajax'])->name('barcode.ajax');
        Route::get('/barcode-product-search/{id}', [PosController::class, 'barcode_search_ajax'])->name('barcode.search.ajax');
        Route::get('/order-list', [PosController::class, 'orderList'])->name('pos.orderList');
        Route::get('/PosReports', [PosController::class, 'searchByPosReport'])->name('searchByPosReport');

        Route::get('/order-list/show/{id}', [PosController::class, 'orderShow'])->name('pos.orderShow');
        Route::get('/order-list/delete/{id}', [PosController::class, 'orderDelete'])->name('pos.orderDelete');
        Route::get('/due-list', [PosController::class, 'orderDue'])->name('pos.orderDue');
        Route::get('/due-collect/{id}', [PosController::class, 'dueCollect'])->name('pos.dueCollect');
        Route::post('/due-collect-update/{id}', [PosController::class, 'dueCollectUpdate'])->name('pos.dueCollectUpdate');
        Route::get('/getOrder/for-due/{id}', [PosController::class, 'getOrderForDue'])->name('pos.getOrderForDue');
        Route::get('/due-collec-info',[PosController::class,'dueCollectInfo'])->name('pos.dueCollectInfo');
        Route::get('/due-collec-info/print/{id}',[PosController::class,'dueCollectInfoPrint'])->name('pos.dueCollectInfoPrint');
        Route::get('/due-collec-info/delete/{id}',[PosController::class,'dueCollectInfoDelete'])->name('pos.dueCollectInfo.delete');

        // Route::get('/admin/pos/invoice-print/{order}', [PosController::class, 'invoicePosDownload'])->name('admin.pos.invoice.download');

    });
});

/*========================== End Admin Route  ==========================*/

require __DIR__ . '/auth.php';