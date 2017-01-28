<?php

Auth::routes();

Route::group(['middleware'=>['auth']],function(){

	Route::get('/dummy', 'HomeController@dummyData');
	Route::get('/', 'HomeController@index')->name('dashboard::index');
//    Generators
	Route::get('/generator/{generator}/status', 'GeneratorsController@status')->name('generator::status');
	Route::resource('/generators','GeneratorsController');
	Route::delete('generator/delete','GeneratorsController@delete')->name('generator::delete');
	//Maintenance Action
	Route::get('/maintenances/{generator}/create','MaintenancesController@create')->name('maintenances.create');
	Route::post('/maintenances/{generator}','MaintenancesController@store')->name('maintenances.store');
	Route::get('/maintenances/{maintenance}/show','MaintenancesController@show')->name('maintenances.show');
	Route::get('/maintenaces',"MaintenancesController@index")->name('maintenances::index');
	Route::get('/maintenaces/search/{generator}',"MaintenancesController@searchLog")->name('maintenances::saerch');
	Route::delete('/maintenance/delete',"MaintenancesController@delete")->name('maintenances::delete');
	//Diesel
	Route::get('diesel/{generator}/fill','GeneratorsController@fillDiesel')->name('diesel.fill');
	Route::post('diesel/{generator}/fill/store','GeneratorsController@fillDieselStore')->name('diesel.fill.store');
	//Auth
	Route::get('/user/edit','Auth\RegisterController@edit')->name('auth::edit');
	Route::post('/user/edit','Auth\RegisterController@update')->name('auth::update');
    // OverHauls
    Route::get('/overhauls/{generator}/create','OverhaulsController@create')->name('overhauls.create');
    Route::post('/overhauls/{generator}/store','OverhaulsController@store')->name('overhauls::store');
    Route::get('/overhauls/{overhaul}/show','OverhaulsController@show')->name('overhauls.show');
    Route::get('/overhauls',"OverhaulsController@index")->name('overhauls::index');
    Route::get('/overhauls/search/{generator}',"OverhaulsController@searchLog")->name('overhauls::saerch');
    Route::delete('/overhauls/delete',"OverhaulsController@delete")->name('overhauls::delete');
    //diff
    Route::post('/diff/{generator}/store','GeneratorsController@storeDiff')->name('diff::store');
    Route::delete('/diff/delete',"GeneratorsController@deleteDiff")->name('diff::delete');

});

Route::any('{any}',function(){
    Return "<h1 class='text-center'>404</h1>";
})->where(['any'=>'.*']);