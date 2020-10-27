<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Rokasma\Esa\Http\Controllers'], function() {

    Route::post('esa', 'EsaController@init')->name('esa.init');

});
