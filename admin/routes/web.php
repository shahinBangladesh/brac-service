<?php
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::group([/*'middleware'=>['vendorPanel'],*/'prefix'=>'vendor'],function() {
  Route::get('login', 'Auth\VendorLoginController@showLoginForm')->name('vendor.login');
  Route::post('/login', 'Auth\VendorLoginController@login')->name('vendor.login.submit');

  Route::namespace('vendor')->group(function () {
    Route::get('/', 'VendorController@index')->name('vendor.dashboard');
  });


  Route::get('logout',function (){
      Auth::guard('vendorPanel')->logout();
      return redirect()->route('vendor.login');
  })->name('vendor.logout');
});

Auth::routes();
Route::group(['middleware'=>['auth'/*,'notification'*/]],function (){
  // Route::get('dashboard', 'DashboardController@index')->name('dashboard');
  Route::get('dashboard', 'DashboardController@index')->name('dashboard');
  
  // User Type
  Route::resource('user-type','UserTypeController');
  
  // User
  Route::resource('user','UserController');
  /*Route::get('user/create','CorporateUserController@corporateCreate')->name('user.create');
  Route::get('user/index','CorporateUserController@corporateIndex')->name('user.index');
  Route::post('user/create','CorporateUserController@corporateStore')->name('user.store');
  Route::get('user/{id}/edit','CorporateUserController@corporateEdit')->name('user.edit');
  Route::put('user/{id}/edit','CorporateUserController@corporateUpdate')->name('user.update');
  Route::DELETE('user/{id}/destroy','CorporateUserController@corporateDestroy')->name('user.destroy');*/
  
  // Vendor
  Route::resource('vendor-company','VendorCompanyController');
  // Asset
  Route::resource('asset','AssetController');
  Route::get('asset/approve/{slug}','AssetController@approve')->name('asset/approve');
  Route::post('asset/approved','AssetController@assetApproved')->name('asset.approved');

/*  Route::get('asset/create','CorporateAssetController@corporateCreate')->name('asset.create');
  Route::get('asset/index','CorporateAssetController@corporateIndex')->name('asset.index');
  Route::post('asset/create','CorporateAssetController@corporateStore')->name('asset.store');
  Route::get('asset/{id}/edit','CorporateAssetController@corporateEdit')->name('asset.edit');
  Route::put('asset/{id}/edit','CorporateAssetController@corporateUpdate')->name('asset.update');
  Route::DELETE('asset/{id}/destroy','CorporateAssetController@corporateDestroy')->name('asset.destroy');*/

  // Branch
  Route::resource('branch','BranchController');
/*  Route::get('branch/create','BranchController@corporateCreate')->name('branch.create');
  Route::get('branch/index','BranchController@corporateIndex')->name('branch.index');
  Route::post('branch/create','BranchController@corporateStore')->name('branch.store');
  Route::get('branch/{id}/edit','BranchController@corporateEdit')->name('branch.edit');
  Route::put('branch/{id}/edit','BranchController@corporateUpdate')->name('branch.update');
  Route::DELETE('branch/{id}/destroy','BranchController@corporateDestroy')->name('branch.destroy');*/

  Route::resource('cart-req','RequestCartController');
  Route::post('cartSubmitToRequest','RequestCartController@cartSubmitToRequest')->name('cartSubmitToRequest');
  /*Request*/
  Route::get('req/create','JobRequestsController@create')->name('req.create');
  Route::get('req/estimate/reject','DashboardController@rejectEstimate')->name('req.estimate.reject');
  Route::get('req/index','JobRequestsController@index')->name('req.index');
  Route::post('req/create','JobRequestsController@store')->name('req.store');
  Route::get('req/{id}/edit','JobRequestsController@edit')->name('req.edit');
  Route::put('req/{id}/edit','JobRequestsController@update')->name('req.update');
  Route::get('req/details/{jobId}','JobRequestsController@show')->name('details');
  Route::get('notification/details/{jobId}/{notificationId}','JobRequestsController@show')->name('notification.details');
  Route::get('assetNotification/details/{id}','AssetController@notificationDetails')->name('assetNotification.details');
  Route::get('assetListFromBranchId','AssetController@assetListFromBranchId')->name('assetListFromBranchId');
  // Route::DELETE('req/{id}/destroy','JobRequestsController@CorporateDestroy')->name('req.destroy');

  /*Service Type*/
  Route::resource('service','ServiceController');
  Route::resource('serviceType','ServiceTypeController');
/*  Route::get('serviceType/create','CorporateTypeController@corporateCreate')->name('serviceType.create');
  Route::get('serviceType/index','CorporateTypeController@corporateIndex')->name('serviceType.index');
  Route::post('serviceType/create','CorporateTypeController@corporateStore')->name('serviceType.store');
  Route::get('serviceType/{id}/edit','CorporateTypeController@corporateEdit')->name('serviceType.edit');
  Route::put('serviceType/{id}/edit','CorporateTypeController@corporateUpdate')->name('serviceType.update');
  Route::DELETE('serviceType/{id}/destroy','CorporateTypeController@corporateDestroy')->name('serviceType.destroy');*/

  /*Approval Action*/
  Route::get('approved/{id}','DashboardController@approveAction')->name('approved');
  Route::get('estimate/{id}','DashboardController@estimateAction')->name('estimate');
  Route::post('req/approved','DashboardController@reqApproved')->name('req.approved');
  Route::post('estimate/approved','DashboardController@estimateApproved')->name('estimate.approved');
  Route::get('asset/{id}','DashboardController@assetReqList')->name('asset');
  Route::get('estimate/list','DashboardController@estimateList')->name('estimate.list');
  // Route::get('req/reject/{id}','DashboardController@rejectRequest')->name('req.reject');
   
  /*Reports*/
  Route::get('reports','DashboardController@report')->name('reports');
  Route::get('tatLists','DashboardController@tatLists')->name('tatLists');
  Route::post('reports','DashboardController@getReport')->name('reports');

  //Dashbaord Section See All
  Route::get('unassigned','DashboardController@unassigned')->name('unassigned');
  Route::get('waitingForEstimateApproval','DashboardController@waitingForEstimateApproval')->name('waitingForEstimateApproval');
  Route::get('pending','DashboardController@pending')->name('pending');
  Route::get('inProcess','DashboardController@inProcess')->name('inProcess');
  Route::get('waitingForEssSchedule','DashboardController@waitingForEssSchedule')->name('waitingForEssSchedule');
});

Route::get('logout',function (){
    Auth::logout();
    return redirect()->route('login');
})->name('logout');