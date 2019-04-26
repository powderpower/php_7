<?php
Route::get('/', 'PagesController@index');
Route::get('useyield', 'PagesController@useYield');
Route::get('useyieldfrom', 'PagesController@useYieldFrom');
Route::get('useoperators', 'PagesController@useOperators');
Route::get('oop', 'PagesController@OOP');
Route::get('error', 'PagesController@getError');
Route::get('classes', 'PagesController@phpClasses');
