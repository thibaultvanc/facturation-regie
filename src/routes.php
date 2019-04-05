<?php

use FacturationRegie\Controllers;

Route::group(['namespace' => Controllers::class, 'prefix'=>'facturation-regie'], function () {
    Route::post('transform-pointable', ['uses'=>'FacturationRegieController@transform'])->name('facturation-regie.transform');

    Route::post('pointage/store', ['uses'=>'FacturationRegieController@store'])->name('facturation-regie.pointage.store');

    Route::post('pointage/store/daily', ['uses'=>'FacturationRegieController@storeDay'])->name('facturation-regie.pointage.store_daily');
});
