<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('user')->group(function(){
Route::post('register',[RegistrationController::class,'store'])->name('user.registration');
Route::post('login',[RegistrationController::class,'login'])->name('user.login');
});
route::prefix('product')->middleware('auth.user')->group(function(){
    Route::post('create',[ProductController::class,'create'])->name('product.create');
    Route::post('{id}/edit',[ProductController::class,'edit'])->name('product.edit');
    Route::get('delete/{id}',[ProductController::class,'delete'])->name('product.delete');
    Route::get('all',[ProductController::class,'getallproduct'])->name('product.all');
    Route::post('{id}/search',[ProductController::class,'search'])->name('product.search');
});
