<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Student;

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



// Removed duplicate route - use the grouped routes below instead

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Test route to check database
Route::get('/test-db', function () {
    try {
        $count = \App\Models\Employee::count();
        return response()->json([
            'status' => 'success',
            'message' => 'Database connected',
            'employee_count' => $count
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
});

// Student API Routes
Route::prefix('students')->group(function () {
    Route::post('/', [Student::class, 'store']);
    Route::get('/', [Student::class, 'index']);
    Route::get('/{id}', [Student::class, 'show']);
    Route::put('/{id}', [Student::class, 'update']);
    Route::delete('/{id}', [Student::class, 'destroy']);
});

// Alternative: Resource Route (Cleaner approach)
// Route::apiResource('students', Student::class);

// Employee API Routes (if needed)
// Route::prefix('employees')->group(function () {
//     Route::post('/', [EmployeeController::class, 'store']);
//     Route::get('/', [EmployeeController::class, 'index']);
//     Route::get('/{id}', [EmployeeController::class, 'show']);
//     Route::put('/{id}', [EmployeeController::class, 'update']);
//     Route::delete('/{id}', [EmployeeController::class, 'destroy']);
// });