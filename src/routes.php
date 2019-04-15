<?php

use FacturationRegie\Controllers;

dd('1111111111111111111111111',1111111111111111111111111);


Route::group(['namespace' => Controllers::class, 'prefix'=>'facturation-regie'], function () {
    Route::post('transform-pointable', ['uses'=>'FacturationRegieController@transform'])->name('facturation-regie.transform');

    Route::post('pointage/store', ['uses'=>'FacturationRegieController@store'])->name('facturation-regie.pointage.store');

    Route::post('pointage/verify/daily', ['uses'=>'FacturationRegieController@verifyDaily'])->name('facturation-regie.pointage.verify_daily');

    Route::delete('pointage/{pointage}', ['uses'=>'FacturationRegieController@delete'])->name('facturation-regie.pointage.delete');

    Route::put('pointage/{pointage}', ['uses'=>'FacturationRegieController@update'])->name('facturation-regie.pointage.update');

    Route::get('pointages', ['uses'=>'FacturationRegieController@index'])->name('facturation-regie.pointage.index');
});
