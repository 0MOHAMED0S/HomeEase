<?php

use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Company\CompanyAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
Route::get('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login/store', [AdminAuthController::class, 'store'])->name('admin.login.store');


Route::get('/company/login', [AdminAuthController::class, 'login'])->name('company.login');
Route::post('/company/login/store', [AdminAuthController::class, 'store'])->name('company.login.store');
Route::get('/company/register', [CompanyAuthController::class, 'register'])->name('company.register');
Route::post('/company/register/store', [CompanyAuthController::class, 'rstore'])->name('company.register.store');

});
Route::middleware(['admin'])->group(function () {

});

Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard/users/table', [AdminDashboard::class, 'userstable'])->name('admin.dashboard.users.table');
    Route::get('/admin/dashboard/categories', [AdminDashboard::class, 'categories'])->name('admin.dashboard.categories');
    Route::post('/dashboard/categories/store', [AdminDashboard::class, 'store'])->name('storecategory');
    Route::delete('/dashboard/categories/delete/{id}', [AdminDashboard::class, 'delete'])->name('DeleteCategory');
    Route::put('/dashboard/categories/update/{id}', [AdminDashboard::class, 'updateCategory'])->name('UpdateCategory');
    Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/orders', [AdminDashboard::class, 'orders'])->name('admin.dashboard.orders');
    Route::get('/admin/dashboard/profile', [AdminDashboard::class, 'profile'])->name('admin.dashboard.profile');
    Route::put('/dashboard/profile/update', [AdminDashboard::class, 'updateprofile'])->name('update.admin.profile');
    Route::post('/dashboard/profile/update-password',[AdminDashboard::class, 'updatePassword'])->name('update.admin.password');

    Route::get('/admin/dashboard/companies', [AdminDashboard::class, 'companies'])->name('admin.dashboard.companies');
    Route::put('/dashboard/companies/update/{id}', [AdminDashboard::class, 'updateCompany'])->name('UpdateCompany');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
