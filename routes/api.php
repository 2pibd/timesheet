<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {

  Route::get("/user-data", function (){
        return ["name"=>'Zamil'];
    });

    Route::get("getUserList", function () {
        return ["name" => 'Zamil'];
    });
});



Route::middleware('auth:sanctum')->get('/user-data', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
    ]);
});

