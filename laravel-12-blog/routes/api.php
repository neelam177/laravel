<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserAuthController;

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

Route::post('signup', [UserAuthController::class, 'signup']);
Route::post('login', [UserAuthController::class, 'login']);

Route::group(['middleware' => "auth:sanctum"], function () {
    // Single route (current)
    Route::get('employee', [EmployeeController::class, 'list']);
    Route::post('add-employee', [EmployeeController::class, 'addEmployee']);
    Route::put('update-employee', [EmployeeController::class, 'updateEmpoyee']);
    Route::delete('delete-employee/{id}', [EmployeeController::class, 'deleteEmployee']);
});

Route::resource('member', MemberController::class);

Route::get('login', [UserAuthController::class, 'login'])->name('login');
