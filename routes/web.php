<?php
use App\Http\Controllers\CnpjController;
use App\Http\Controllers\NcmController;

Route::get('/', function () {
    return view('home');
});

Route::resource('ncms', NcmController::class);

Route::resource('cnpjs', CnpjController::class);