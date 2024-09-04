<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ------------ start admin auth routes -----------------
Route::group(['prefix'=>'admin'],function(){
    require __DIR__ .'/admin/admin_auth.php';
});
// ------------ end admin auth routes -----------------

// ------------- start book management routes -----------
Route::group(['prefix'=>'admin','middleware'=>['ApiAdminAuth']],function(){
    require __DIR__ . '/admin/book_manage_routes.php';
});

// ------------- end book management routes -----------

// ---------------- start public book routes ---------------
require __DIR__ . '/public/book_routes.php';
// ---------------- end public book routes ---------------

// --------------- start visitor routes -------------------
require __DIR__ . '/visitors_route.php';
// --------------- end visitor routes -------------------
