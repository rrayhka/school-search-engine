<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return view('landing');
});

// make routing to landing controller
Route::get('/search', [LandingController::class, 'search']);
Route::get('/get-kecamatan', [LandingController::class, 'getKecamatan']);