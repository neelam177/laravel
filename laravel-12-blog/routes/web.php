<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/home', function () {
//     return view('home');
// });
// Route::view('/home', 'home');
Route::redirect('/home', '/');

Route::get('/about/{name}', function ($name) {
    // echo $name;
    // return view('about');
    return view('about', ['name' => $name]);
});

Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');

Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');

Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');

