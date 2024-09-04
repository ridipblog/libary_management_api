<?php

use App\Http\Controllers\admin\AdminAuthController;
use Illuminate\Support\Facades\Route;
// ----------- admin login routes ---------------
Route::post('/login',[AdminAuthController::class,'login']);
// -------------- admin logout routes --------------

Route::get('/admin-logout',[AdminAuthController::class,'adminLogout']);
