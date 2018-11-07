<?php
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Auth::routes();
Route::group(['middleware'=>['auth'/*,'notification'*/]],function (){
  // Route::get('dashboard', 'CorporateController@index')->name('dashboard');
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
/*  Route::get('asset/create','CorporateAssetController@corporateCreate')->name('asset.create');
  Route::get('asset/approve/{slug}','CorporateAssetController@approve')->name('asset/approve');
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

  /*Request*/
  Route::get('req/create','JobRequestController@corporateCreate')->name('req.create');
  Route::get('req/estimate/reject','CorporateController@rejectEstimate')->name('req.estimate.reject');
  Route::get('req/index','JobRequestController@CorporateIndex')->name('req.index');
  Route::post('req/create','JobRequestController@CorporateStore')->name('req.store');
  Route::get('req/{id}/edit','JobRequestController@CorporateEdit')->name('req.edit');
  Route::put('req/{id}/edit','JobRequestController@CorporateUpdate')->name('req.update');
  Route::get('req/details/{jobId}','JobRequestController@CorporateDetails')->name('details');
  Route::get('notification/details/{jobId}/{notificationId}','JobRequestController@CorporateDetails')->name('notification.details');
  Route::get('assetNotification/details/{id}','CorporateAssetController@notificationDetails')->name('assetNotification.details');
  Route::get('assetListFromBranchId','CorporateAssetController@assetListFromBranchId')->name('assetListFromBranchId');
  // Route::DELETE('req/{id}/destroy','JobRequestController@CorporateDestroy')->name('req.destroy');

  /*Service Type*/
  Route::get('serviceType/create','CorporateTypeController@corporateCreate')->name('serviceType.create');
  Route::get('serviceType/index','CorporateTypeController@corporateIndex')->name('serviceType.index');
  Route::post('serviceType/create','CorporateTypeController@corporateStore')->name('serviceType.store');
  Route::get('serviceType/{id}/edit','CorporateTypeController@corporateEdit')->name('serviceType.edit');
  Route::put('serviceType/{id}/edit','CorporateTypeController@corporateUpdate')->name('serviceType.update');
  Route::DELETE('serviceType/{id}/destroy','CorporateTypeController@corporateDestroy')->name('serviceType.destroy');

  /*Approval Action*/
  Route::get('approved/{id}','CorporateController@approveAction')->name('approved');
  Route::get('estimate/{id}','CorporateController@estimateAction')->name('estimate');
  Route::post('req/approved','CorporateController@reqApproved')->name('req.approved');
  Route::post('estimate/approved','CorporateController@estimateApproved')->name('estimate.approved');
  Route::post('asset/approved','CorporateAssetController@assetApproved')->name('asset.approved');
  Route::get('asset/{id}','CorporateController@assetReqList')->name('asset');
  Route::get('estimate/list','CorporateController@estimateList')->name('estimate.list');
  // Route::get('req/reject/{id}','CorporateController@rejectRequest')->name('req.reject');
   
  /*Reports*/
  Route::get('reports','CorporateController@report')->name('reports');
  Route::get('tatLists','CorporateController@tatLists')->name('tatLists');
  Route::post('reports','CorporateController@getReport')->name('reports');

  //Dashbaord Section See All
  Route::get('unassigned','CorporateController@unassigned')->name('unassigned');
  Route::get('waitingForEstimateApproval','CorporateController@waitingForEstimateApproval')->name('waitingForEstimateApproval');
  Route::get('pending','CorporateController@pending')->name('pending');
  Route::get('inProcess','CorporateController@inProcess')->name('inProcess');
  Route::get('waitingForEssSchedule','CorporateController@waitingForEssSchedule')->name('waitingForEssSchedule');
});

Route::get('logout',function (){
    Auth::logout();
    return redirect()->route('login');
})->name('logout');