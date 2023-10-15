<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

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


//Login api route
Route::post('/auth/login',[AuthController::class,'login']);


//Register api route
Route::post('/auth/register',[AuthController::class,'register']);


//Get-user information api route
Route::get('getusers', 'App\Http\Controllers\Api\AuthController@getusers');


//Update-user information api route
Route::post('/profile/update_profile',[ProfileController::class,'update_profile'])->middleware('auth:sanctum');


//Change password api route
Route::post('/profile/change_password',[ProfileController::class,'change_password'])->middleware('auth:sanctum');


//Forget password api route
Route::post('/forget_password',[AuthController::class,'forget_password']);


//Add product api route
Route::post('products',[ProductController::class,'store']);


//Get product api route
Route::get('products',[ProductController::class,'index']);


//Update product api route
Route::put('products/{id}',[ProductController::class,'update']);


//Delete product api route
Route::delete('products/{id}',[ProductController::class,'destroy']);


//Assign products to users api route
Route::post('/products/create',[ProductController::class,'create'])->middleware('auth:sanctum');


//Get user's products api route
Route::get('/userproducts',[ProductController::class,'list'])->middleware('auth:sanctum');
