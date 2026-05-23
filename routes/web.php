<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;

Auth::routes();

Route::redirect('/', '/login');

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/charts', [HomeController::class, 'charts'])->name('charts');
Route::get('/iconmenu', [HomeController::class, 'iconmenu'])->name('iconmenu');
Route::get('/browse', [HomeController::class, 'browse'])->name('browse');
Route::get('/browse/{item}', [HomeController::class, 'show'])->name('items.show');
Route::post('/browse/{item}/claim', [HomeController::class, 'submitClaim'])->name('items.claim');

Route::get('/forms', [HomeController::class, 'forms'])->name('forms');
Route::post('/forms/store', [HomeController::class, 'store'])->name('forms.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/forms/{item}/edit', [HomeController::class, 'edit'])->name('forms.edit');
    Route::put('/forms/{item}', [HomeController::class, 'update'])->name('forms.update');
    Route::delete('/forms/{item}', [HomeController::class, 'destroy'])->name('forms.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/items', [AdminController::class, 'items'])->name('items');
    Route::patch('/items/{id}/status', [AdminController::class, 'updateItemStatus'])->name('items.status');
    Route::delete('/items/{id}', [AdminController::class, 'destroyItem'])->name('items.destroy');

    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.role');
    Route::post('/users/{id}/delete', [AdminController::class, 'destroyUser'])->name('users.delete');

    Route::get('/claims', [AdminController::class, 'claims'])->name('claims');
    Route::post('/claims/{claim}/approve', [AdminController::class, 'approveClaim'])->name('claims.approve');
    Route::post('/claims/{claim}/reject', [AdminController::class, 'rejectClaim'])->name('claims.reject');

    Route::get('/verification', [AdminController::class, 'verification'])->name('verification');
    Route::post('/verification/{id}/approve', [AdminController::class, 'approveUser'])->name('verification.approve');
    Route::post('/verification/{id}/reject', [AdminController::class, 'rejectUser'])->name('verification.reject');

    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/activity', [AdminController::class, 'activity'])->name('activity');
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