<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServicePorovider within a group which
| contains the "web" middleware group. Nw create something great!
|
*/

/*
======================
Temporary Test Routes
======================
*/

Route::get('resettest', 'LockerController@turnOffLockers');

Route::get('locker/{id}', 'LockerController@locker');
Route::get('locker/on/{id}', 'LockerController@lockerOn');
Route::get('locker/off/{id}', 'LockerController@lockerOff');

Route::get('/reset', 'LockerController@resetLockers');
// Route::get('/turnoff/{id}', 'LockerController@turnOffLockers');
Route::get('/lockers/{code}', 'LockerController@getLockers');

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    return 'Cache is cleared';
});

Route::get('/job', function () {
    Artisan::call('queue:listen');
    return 'Job Started....';
});

Route::get('/session-clear', function () {
    session()->flush();
    return 'Session is cleared';
});

Route::get('/updateapp', function () {
    Artisan::call('dump-autoload');
    return 'dump-autoload complete';
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/terms', 'HomeController@terms')->name('terms');

Auth::routes();

/*
======================
Temporary Test Routes for request
======================
*/

Route::get('/request', 'RequestController@renderRequestForm')->name('request.form');
Route::post('/request/save', 'RequestController@saveRequest')->name('request.save');

/*
======================
Admin Panel Routes
======================
*/
Route::prefix('admin')->group(function () {
    Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('dashboard/{days}', 'AdminController@getDashboardInfo');

    Route::get('login', 'Auth\LoginController@showAdminLoginForm')->name('admin.login');
    Route::post('login', 'Auth\LoginController@loginAdmin')->name('admin.login.submit');
    Route::get('register', 'Auth\RegisterController@showAdminRegisterForm')->name('admin.register');
    Route::post('register', 'Auth\RegisterController@createAdmin')->name('admin.register.submit');

    /*
    ======================
    Product, Product Category, Product Brand Routes
    ======================
    */
    Route::prefix('product')->group(function () {
        Route::prefix('category')->group(function () {
            Route::get('/', 'ProductCategoryController@index')->name('product_category_index');
            Route::get('create', 'ProductCategoryController@create')->name('product_category_create');
            Route::post('/', 'ProductCategoryController@store')->name('product_category_store');
            Route::get('edit/{id}', 'ProductCategoryController@edit')->name('product_category_edit');
            Route::put('edit/{id}', 'ProductCategoryController@update')->name('product_category_update');
            Route::get('{id}', 'ProductCategoryController@destroy')->name('product_category_destroy');
        });

        Route::prefix('brand')->group(function () {
            Route::get('/', 'ProductBrandController@index')->name('product_brand_index');
            Route::get('create', 'ProductBrandController@create')->name('product_brand_create');
            Route::post('/', 'ProductBrandController@store')->name('product_brand_store');
            Route::get('edit/{id}', 'ProductBrandController@edit')->name('product_brand_edit');
            Route::put('edit/{id}', 'ProductBrandController@update')->name('product_brand_update');
            Route::get('/{id}', 'ProductBrandController@destroy')->name('product_brand_destroy');
        });

        Route::get('/', 'ProductController@index')->name('product_index');
        Route::get('create', 'ProductController@create')->name('product_create');
        Route::post('/', 'ProductController@store')->name('product_store');
        Route::get('edit/{id}', 'ProductController@edit')->name('product_edit');
        Route::put('edit/{id}', 'ProductController@update')->name('product_update');
        Route::get('{id}', 'ProductController@destroy')->name('product_destroy');
    });

    /*
    ======================
    Vendor Routes
    ======================
    */

    Route::prefix('vendor')->group(function () {
        Route::get('category', 'VendorAccountController@category')->name('vendor_account_category');
        Route::get('inactive', 'VendorAccountController@inactive')->name('vendor_account_inactive');
        Route::get('/', 'VendorAccountController@active')->name('vendor_account_active');
        Route::get('requests', 'VendorAccountController@requests')->name('vendor_account_request');

        Route::post('/', 'VendorAccountController@store')->name('vendor_account_store');
        Route::get('create', 'VendorAccountController@create')->name('vendor_account_create');
        Route::get('show/{id}', 'VendorAccountController@show')->name('vendor_account_show');
        Route::get('edit/{id}', 'VendorAccountController@edit')->name('vendor_account_edit');
        Route::put('edit/{id}', 'VendorAccountController@update')->name('vendor_account_update');
        Route::get('{id}', 'VendorAccountController@destroy')->name('vendor_account_destroy');
        Route::get('{id}', 'VendorAccountController@toggleVendor')->name('vendor_account_toggle');

        Route::get('machine/{id}', 'VendorAccountController@getLockerMachine')->name('vendor_account_locker_machine');
        Route::get('{vendor_id}/machine/create/', 'VendorAccountController@createLockerMachine')->name('vendor_account_locker_machine_create');
        Route::post('machine/store/', 'VendorAccountController@storeLockerMachine')->name('vendor_account_locker_machine_store');
        Route::get('{vendor_id}/machine/show/{model}/{machine_id}', 'VendorAccountController@showLockerMachine')->name('vendor_account_locker_machine_show');
        Route::get('{vendor_id}/machine/edit/{model}/{machine_id}', 'VendorAccountController@editLockerMachine')->name('vendor_account_locker_machine_edit');
        Route::post('machine/update', 'VendorAccountController@updateLockerMachine')->name('vendor_account_locker_machine_update');
        Route::get('{vendor_id}/{model}/{machine_id}', 'VendorAccountController@toggleLockerMachine')->name('vendor_account_machine_toggle');

        // Route::get('/request/show/{id}', 'VendorAccountController@showRequest')->name('vendor.request.show');
        // Route::get('/request/{id}', 'VendorAccountController@showRequestApprove')->name('vendor.request.approve');
        // Route::get('request/delete/{id}', 'VendorAccountController@vendorRequestDestroy')->name('vendor.request.destroy');
    });

    /*
    ======================
    Transaction Panel Routes
    ======================
    */
    // this route is not necessary, may be in future.

    Route::prefix('transaction')->group(function () {
        Route::get('search', 'AdminController@searchTransactions')->name('admin_transaction_search');
        Route::post('search', 'AdminController@search')->name('admin_transaction_search');

        Route::get('/{vendor_id}', 'AdminController@getTransactions')->name('vendor_account_transactions');
        Route::get('{vendor_id}/{id}', 'AdminController@showTransactionDetails')->name('vendor_account_transaction_details');
    });
});

/*
======================
Vendor Dashboard Routes
======================
*/
Route::prefix('vendor')->group(function () {
    Route::get('dashboard', 'VendorController@dashboard')->name('vendor_dashboard');
    Route::get('dashboard/{days}', 'VendorController@getDashboardInfo');

    Route::get('login', 'Auth\LoginController@showVendorLoginForm')->name('vendor.login');
    Route::post('login', 'Auth\LoginController@loginVendor')->name('vendor.login.submit');
    Route::get('register', 'Auth\RegisterController@showVendorRegisterForm')->name('vendor.register');
    Route::post('register', 'Auth\RegisterController@createVendor')->name('vendor.register.submit');

    Route::get('machines', 'VendorMachineController@getLockerMachine')->name('vendor_locker_machine');
    Route::get('machine/{model}/{id}', 'VendorMachineController@showLockerMachine')->name('vendor_locker_machine_show');
    Route::get('locker/{model}/{machine_id}/', 'VendorMachineController@getLocker')->name('vendor_locker_machine_locker');
    Route::get('locker/{model}/{machine_id}/{locker_id}', 'VendorMachineController@showLocker')->name('vendor_locker_machine_locker_show');

    Route::get('locker/open/{model}/{machine_id}/{locker_id}', 'VendorMachineController@openLocker')->name('vendor_locker_machine_open_locker');
    Route::get('locker/close/{model}/{machine_id}/{locker_id}', 'VendorMachineController@closeLocker')->name('vendor_locker_machine_close_locker');

    Route::post('refill', 'VendorMachineController@refillLocker')->name('vendor_locker_machine_refill');
    Route::get('transaction', 'VendorMachineController@getTransactions')->name('vendor_locker_machine_transactions');
    Route::get('transaction/{id}', 'VendorMachineController@showTransactionDetails')->name('vendor_locker_machine_transaction_details');
});

Route::get('user', 'UserController@dashboard')->name('user.dashboard');

Route::post('/vend', 'AdminController@vend')->name('vend');

/*
======================
Manager Panel Routes : future implementation
======================
*/
// Route::prefix('manager')->group(function () {
//     Route::get('login', 'Auth\LoginController@showManagerLoginForm')->name('manager.login');
//     Route::post('login', 'Auth\LoginController@loginManager')->name('manager.login.submit');
//     Route::get('register', 'Auth\RegisterController@showManagerRegisterForm')->name('manager.register');
//     Route::post('register', 'Auth\RegisterController@createManager')->name('manager.register.submit');
// });
