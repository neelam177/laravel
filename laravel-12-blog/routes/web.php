<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

// Route::redirect('/home', '/');

// Route::get('/about/{name}', function ($name) {
//     // echo $name;
//     // return view('about');
//     return view('about', ['name' => $name]);
// });

Route::get('user',[UserController::class, 'getuser']);
Route::get('demo/{name}',[UserController::class, 'aboutUser']);

Route::get('admin-login',[UserController::class,'adminLogin']);



//option1
// Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
// Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
// Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
// Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
// Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
// Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

//option2
Route::resource('employees', EmployeeController::class);

