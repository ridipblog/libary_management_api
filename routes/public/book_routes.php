<?php

use App\Http\Controllers\public\BookController;
use Illuminate\Support\Facades\Route;
// ------------- search and get all books -----------------
Route::post('/all-books',[BookController::class,'searchAllBooks']);
// ------------ view particular book details --------------
Route::post('/book-details',[BookController::class,'viewBookDetails']);
