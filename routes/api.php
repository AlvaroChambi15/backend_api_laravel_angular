<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//------------ AGRUPANDO LAS RUTAS CON UN PREFIJO "v1/auth" ------------
Route::prefix("v1/auth")->group(function(){

    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);

    //------------ PROTEGIENDO RUTAS CON MIDDLEWARE DE AUTENTICACIÓN ------------
    Route::middleware('auth:sanctum')->group(function () {

        Route::get("/profile", [AuthController::class, "funProfile"]);
        Route::get("/logout", [AuthController::class, "funLogout"]);

    });

});
