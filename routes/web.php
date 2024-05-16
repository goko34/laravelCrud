<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;


/* Auth side*/
Route::get('/', function () {return view('auths.register');});
Route::get('/login', [AuthController::class ,"login"])->name("login");
Route::get('/register', [AuthController::class ,"register"])->name("register");
Route::post('/register', [AuthController::class ,"postRegister"])->name("register.post");
Route::post('/login', [AuthController::class ,"postLogin"])->name("login.post");
Route::get('/logout', [AuthController::class ,"logout"])->name("logout");


/* Product side*/
Route::get("/product",[ProductController::class,"home"])->name("product.home");
Route::put("/product/{product}/update", [ProductController::class ,"update"])->name("product.update");
Route::get("/product/{product}/edit", [ProductController::class ,"edit"])->name("product.edit");
Route::get("/product/{product}/detail", [ProductController::class ,"detail"])->name("product.detail");
Route::get("/product/create", [ProductController::class ,"create"])->name("product.create");
Route::post("/product",[ProductController::class,"store"])->name("product.store");
Route::delete("/product/{product}/destroy",[ProductController::class,"destroy"])->name("product.destroy");

