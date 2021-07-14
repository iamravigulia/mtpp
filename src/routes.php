<?php
use Illuminate\Support\Facades\Route;

Route::get('mtpp/test', 'EdgeWizz\Mtpp\Controllers\MtppController@test')->name('test');

Route::post('fmt/mtpp/store', 'EdgeWizz\Mtpp\Controllers\MtppController@store')->name('fmt.mtpp.store');

Route::post('fmt/mtpp/csv_upload', 'EdgeWizz\Mtpp\Controllers\MtppController@csv_upload')->name('fmt.mtpp.csv_upload');

Route::post('fmt/mtpp/update/{id}', 'EdgeWizz\Mtpp\Controllers\MtppController@update')->name('fmt.mtp.update');
Route::any('fmt/mtpp/inactive/{id}',  'EdgeWizz\Mtpp\Controllers\MtppController@inactive')->name('fmt.mtp.inactive');
Route::any('fmt/mtpp/active/{id}',  'EdgeWizz\Mtpp\Controllers\MtppController@active')->name('fmt.mtp.active');

