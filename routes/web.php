<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\LoginController::class, 'register']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function() {
        return view('dashboard');
    })->name('dashboard');
    
    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User management
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        
        // Area management
        Route::get('/areas', [AdminController::class, 'areas'])->name('areas.index');
        Route::get('/areas/create', [AdminController::class, 'createArea'])->name('areas.create');
        Route::post('/areas', [AdminController::class, 'storeArea'])->name('areas.store');
        Route::get('/areas/{area}/edit', [AdminController::class, 'editArea'])->name('areas.edit');
        Route::put('/areas/{area}', [AdminController::class, 'updateArea'])->name('areas.update');
        
        // Mekhala management
        Route::get('/mekhalas', [AdminController::class, 'mekhalas'])->name('mekhalas.index');
        Route::get('/mekhalas/create', [AdminController::class, 'createMekhala'])->name('mekhalas.create');
        Route::post('/mekhalas', [AdminController::class, 'storeMekhala'])->name('mekhalas.store');
        Route::get('/mekhalas/{mekhala}/edit', [AdminController::class, 'editMekhala'])->name('mekhalas.edit');
        Route::put('/mekhalas/{mekhala}', [AdminController::class, 'updateMekhala'])->name('mekhalas.update');
        
        // Unit management
        Route::get('/units', [AdminController::class, 'units'])->name('units.index');
        Route::get('/units/create', [AdminController::class, 'createUnit'])->name('units.create');
        Route::post('/units', [AdminController::class, 'storeUnit'])->name('units.store');
        Route::get('/units/{unit}/edit', [AdminController::class, 'editUnit'])->name('units.edit');
        Route::put('/units/{unit}', [AdminController::class, 'updateUnit'])->name('units.update');
    });
    
    // Application routes
    Route::resource('applications', ApplicationController::class);
    Route::get('/applications/{application}/download', [ApplicationController::class, 'download'])->name('applications.download');
    Route::post('/applications/validate-field', [ApplicationController::class, 'validateField'])->name('applications.validate-field');
    Route::get('/applications-review', [ApplicationController::class, 'review'])->name('applications.review')->middleware('mekhala');
    Route::post('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve')->middleware('mekhala');
    Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject')->middleware('mekhala');
    
    // Collection routes
    Route::resource('collections', CollectionController::class);
    Route::get('/unit-collections', [CollectionController::class, 'unitCollections'])->name('collections.units')->middleware('mekhala');
    Route::get('/area-collections', [CollectionController::class, 'areaCollections'])->name('collections.area')->middleware('mekhala');
    
    // Expense routes
    Route::resource('expenses', ExpenseController::class)->middleware('mekhala');
    
    // Report routes
    Route::middleware('mekhala')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/financial-statement', [ReportController::class, 'financialStatement'])->name('financial');
        Route::get('/collection', [ReportController::class, 'collectionReport'])->name('collection');
        Route::get('/application-payment', [ReportController::class, 'applicationPaymentReport'])->name('application-payment');
        Route::get('/export-financial', [ReportController::class, 'exportFinancialStatement'])->name('export-financial');
    });
});


