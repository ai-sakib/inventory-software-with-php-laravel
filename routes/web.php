<?php
Route::get('reboot', function() {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    file_put_contents(storage_path('logs/laravel.log'),'');
    Artisan::call('key:generate');
    Artisan::call('config:cache');
    return '<center><h1>System Rebooted!</h1></center>';
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
	Route::get('/', function () {
	    return view('welcome');
	});
	Route::get('get-active-menu/{data}','DashboardController@index');
});
Route::group(['middleware' => ['auth','CheckLinkPermission']], function () {
	
	Route::resource('locations','LocationController');
	Route::resource('item-categories','ItemCategoryController');
	Route::resource('items','ItemController');

	Route::resource('customers','CustomerController');
	Route::get('customers/{id}/clearPayment','CustomerController@clearPayment');
	Route::get('customers/{data}/setPayment','CustomerController@setPayment');
	Route::get('customers/{customer_id}/viewPayment','CustomerController@viewPayment');
	Route::get('customers/{id}/clearPaymentEach','CustomerController@clearPaymentEach');
	Route::get('customers/{customer_id}/checkPayment','CustomerController@checkPayment');

	Route::resource('suppliers','SupplierController');
	Route::get('suppliers/{id}/clearPayment','SupplierController@clearPayment');
	Route::get('suppliers/{data}/setPayment','SupplierController@setPayment');
	Route::get('suppliers/{supplier_id}/viewPayment','SupplierController@viewPayment');
	Route::get('suppliers/{id}/clearPaymentEach','SupplierController@clearPaymentEach');
	Route::get('suppliers/{supplier_id}/checkPayment','SupplierController@checkPayment');


	Route::resource('main-menu','MainMenuController');
	Route::resource('sub-menu','SubMenuController');
	Route::resource('admin-roles','AdminRoleController');
	Route::resource('users','UserController');


	Route::resource('stock-in','StockInController');
	Route::get('stock-in/{category_id}/selectCategory','StockInController@selectCategory');
	Route::get('stock-in/{item_id}/selectItem','StockInController@selectItem');
	Route::get('stock-in/{stock_in_id}/getDetails','StockInController@getDetails');
	Route::get('stock-in/{customer_id}/selectSupplier','StockInController@selectSupplier');

	Route::get('stock-in-lists','StockInController@stockInLists');
	Route::get('stock-in-lists/{id}/clearPayment','StockInController@clearPayment');
	Route::get('stock-in-lists/{data}/setPayment','StockInController@setPayment');
	Route::post('stock-in-lists','StockInController@search');
	

	
	
	Route::resource('stock-out','StockOutController');
	Route::get('stock-out/{category_id}/selectCategory','StockOutController@selectCategory');
	Route::get('stock-out/{item_id}/selectItem','StockOutController@selectItem');
	Route::get('stock-out/{stock_out_id}/getDetails','StockOutController@getDetails');
	Route::get('stock-out/{data}/quantityAlert','StockOutController@quantityAlert');
	Route::get('stock-out/{customer_id}/selectCustomer','StockOutController@selectCustomer');

	Route::get('stock-out-lists','StockOutController@stockOutLists');
	Route::get('stock-out-lists/{id}/clearPayment','StockOutController@clearPayment');
	Route::get('stock-out-lists/{data}/setPayment','StockOutController@setPayment');

	Route::resource('transfer','TransferController');
	Route::get('transfers-history','TransferController@transferHistory');
	Route::get('transfer/{category_id}/selectCategory','TransferController@selectCategory');
	Route::get('transfer/{data}/quantityAlert','TransferController@quantityAlert');

	Route::resource('adjust-products','AdjustmentController');
	Route::get('adjustment-history','AdjustmentController@adjustmentHistory');
	Route::get('adjust-products/{category_id}/selectCategory','AdjustmentController@selectCategory');
	Route::get('adjust-products/{data}/quantityAlert','AdjustmentController@quantityAlert');

	

	Route::get('project','ProjectController@index');
	Route::post('project','ProjectController@store');

	Route::get('change-password','ProjectController@changePassword');
	Route::post('change-password','ProjectController@changePasswordStore');

	Route::get('change-password','ProjectController@changePassword');
	Route::post('change-password','ProjectController@changePasswordStore');

	Route::get('admin-priority','ProjectController@adminPriority');
	Route::post('admin-priority','ProjectController@adminPriorityStore');
	Route::post('admin-priority/0/store','ProjectController@adminPermissionStore');

	

	Route::get('location-wise-stock-status','StockStatusController@locationWise');
	Route::get('location-wise-stock-status/{category_id}/selectCategory','StockStatusController@selectCategory');
	Route::get('location-wise-stock-status/{data}/search','StockStatusController@locationWiseSearch');
	Route::get('product-wise-stock-status','StockStatusController@productWise');
	Route::get('product-wise-stock-status/{data}/search','StockStatusController@productWiseSearch');

});

