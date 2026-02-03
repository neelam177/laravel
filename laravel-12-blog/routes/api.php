<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("test", function () {
    return ["name" => "Neelam Gupta", 'channel' => "coding steps"];
});

// // Employee API Routes
// Route::prefix('employees')->group(function () {
//     Route::get('/', [EmployeeController::class, 'list']);
//     Route::post('/', [EmployeeController::class, 'store']);
//     Route::get('/{id}', [EmployeeController::class, 'show']);
//     Route::put('/{id}', [EmployeeController::class, 'update']);
//     Route::delete('/{id}', [EmployeeController::class, 'destroy']);
// });

// Single route (current)
Route::get('employee',[EmployeeController::class,'list']);
Route::post('add-employee',[EmployeeController::class,'addEmployee']);