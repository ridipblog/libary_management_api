<?php

use App\Http\Controllers\VisitorController;
use Illuminate\Support\Facades\Route;
// ------------ reserve book routee -------------
Route::post('/reserve-book',[VisitorController::class,'reserveBook']);
// ----------- borrow history route --------------
Route::post('/borrow-history',[VisitorController::class,'borrowHistory']);
