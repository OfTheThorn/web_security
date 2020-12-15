<?php

use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/privacy', function(){
   return view('privacypolicy');
});
Route::get('/cookies', function(){
   return view('cookiepolicy');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/user/profile/detailsJSON', [GeneralController::class, "index"])->name("get_user_details");

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
