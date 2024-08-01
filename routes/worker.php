<?php

use App\Http\Controllers\Worker\WorkerAdminController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| LOGIN ROUTES FOR WORKER (ROUTE)
|--------------------------------------------------------------------------
*/
Route::get('/worker/login',[WorkerAdminController::class, 'index'])->name('worker.login_form');
Route::post('/worker/login',[WorkerAdminController::class, 'login'])->name('worker.login');
Route::get('/worker/signup',[WorkerAdminController::class, 'register'])->name('worker.register_form');
Route::post('/worker/signup-request',[WorkerAdminController::class, 'storeSignupRequest'])->name('worker.registerRequest');




/*
|--------------------------------------------------------------------------
|  ROUTES FOR WORKER (ROUTE)
|--------------------------------------------------------------------------
*/
Route::prefix('worker')->name('worker.')->middleware('worker')->group(function(){
	Route::get('/dashboard',[WorkerAdminController::class, 'dashboard'])->name('dashboard');
	Route::get('/logout',[WorkerAdminController::class, 'workerLogout'])->name('logout');
	// Route::get('/register',[DealerAdminController::class, 'dealerRegister'])->name('regester');
	// Route::post('/register/store',[DealerAdminController::class, 'dealerRegisterStore'])->name('register.store');
	// Route::get('/forgot-password',[DealerAdminController::class, 'AdminForgotPassword'])->name('password.request');
	Route::get('/profile',[WorkerAdminController::class, 'profile'])->name('profile');
	Route::get('/edit/profile',[WorkerAdminController::class, 'editProfile'])->name('edit.profile');
	Route::post('/store/profile',[WorkerAdminController::class, 'storeProfile'])->name('store.profile');
	Route::get('/change/password',[WorkerAdminController::class, 'changePassword'])->name('change.password');
	Route::post('/update/password',[WorkerAdminController::class, 'updatePassword'])->name('update.password');
	Route::get('/order-print/{id}', [WorkerAdminController::class, 'orderPrint'])->name('manufacture.printOrder');


	/* ================ dealer Cache Clear ============== */
	Route::get('/cache-cache',[WorkerAdminController::class, 'clearCache'])->name('cache.clear');

	//  Worker Order All Routes
	Route::prefix('order')->group(function(){
		Route::get('/index', [WorkerAdminController::class, 'viewOrder'])->name('worker.vieworder');
        Route::get('/date/worker_search', [WorkerAdminController::class, 'DateWiseSearch'])->name('DateWiseSearch');
        Route::get('/date/pending/worker_search', [WorkerAdminController::class, 'pendingDateWiseSearch'])->name('pendingDateWiseSearch');
        Route::get('/date/confirm/worker_search', [WorkerAdminController::class, 'confirmDateWiseSearch'])->name('confirmDateWiseSearch');
		Route::get('/pending', [WorkerAdminController::class, 'pendingOrder'])->name('worker.pending');
		Route::get('/confirmed', [WorkerAdminController::class, 'confirmedOrder'])->name('worker.confirmed');
		Route::get('/print-order/{id}', [WorkerAdminController::class, 'printOrder'])->name('worker.printOrder');

	});

	// Worker Payment Route
    Route::prefix('payment')->group(function(){
		Route::get('/index', [WorkerAdminController::class, 'viewPayment'])->name('worker.viewPayment');

	});


});


require __DIR__.'/auth.php';