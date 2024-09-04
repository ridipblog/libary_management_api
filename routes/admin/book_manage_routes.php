<?php

use App\Http\Controllers\admin\BookManageController;
use Illuminate\Support\Facades\Route;

// ----------- add book details routes ---------------------
Route::post('/add-book',[BookManageController::class,'addBook']);
// -------------- update book details routes -----------------
Route::post('/update-book',[BookManageController::class,'updateBook']);
// -------------- remove book details route ---------------
Route::post('/remove-book',[BookManageController::class,'removeBook']);
// ----------- generate year --------------
Route::get('/generate-year',[BookManageController::class,'generateYear']);
