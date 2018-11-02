<?php
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware'=>['auth']],function (){
	
});