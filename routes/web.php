<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CategoryController;

Auth::routes();

Route::redirect('/', '/login');

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/charts', [HomeController::class, 'charts'])->name('charts');
Route::get('/iconmenu', [HomeController::class, 'iconmenu'])->name('iconmenu');

Route::get('/forms', [HomeController::class, 'forms'])->name('forms');
Route::post('/forms/store', [HomeController::class, 'store'])->name('forms.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/items', [HomeController::class, 'adminItems'])->name('admin.items');
    Route::get('/forms/{item}/edit', [HomeController::class, 'edit'])->name('forms.edit');
    Route::put('/forms/{item}', [HomeController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{item}', [HomeController::class, 'destroy'])->name('forms.destroy');
});

Route::prefix('/employees')->name('employees.')->group(function() {
    Route::get('/home', [EmployeesController::class, 'index'])->name('home');
    Route::post('/store', [EmployeesController::class, 'store'])->name('store');
    Route::get('/{id}', [EmployeesController::class, 'show'])->name('show');
});

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

Route::get('/forms/{id}/edit',  [HomeController::class, 'edit'])->name('forms.edit');
Route::put('/forms/{id}',       [HomeController::class, 'update'])->name('forms.update');
Route::delete('/forms/{id}',    [HomeController::class, 'destroy'])->name('forms.destroy');