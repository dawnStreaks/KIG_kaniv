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
        Route::delete('/units/{unit}', [AdminController::class, 'destroyUnit'])->name('units.destroy');
        
        // Collection settings
        Route::get('/terms', [AdminController::class, 'terms'])->name('terms.index');
        Route::post('/terms', [AdminController::class, 'storeTerm'])->name('terms.store');
        Route::put('/terms/{id}', [AdminController::class, 'updateTerm'])->name('terms.update');
        Route::delete('/terms/{id}', [AdminController::class, 'destroyTerm'])->name('terms.destroy');
        Route::get('/types', [AdminController::class, 'types'])->name('types.index');
        Route::post('/types', [AdminController::class, 'storeType'])->name('types.store');
        Route::put('/types/{id}', [AdminController::class, 'updateType'])->name('types.update');
        Route::delete('/types/{id}', [AdminController::class, 'destroyType'])->name('types.destroy');
        
        // Application types
        Route::get('/application-types', [AdminController::class, 'applicationTypes'])->name('application-types.index');
        Route::post('/application-types', [AdminController::class, 'storeApplicationType'])->name('application-types.store');
        Route::put('/application-types/{id}', [AdminController::class, 'updateApplicationType'])->name('application-types.update');
        Route::delete('/application-types/{id}', [AdminController::class, 'destroyApplicationType'])->name('application-types.destroy');
        Route::post('/application-types/{id}/toggle-status', [AdminController::class, 'toggleApplicationTypeStatus'])->name('application-types.toggle-status');
        
        // Export routes
        Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('users.export');
        Route::get('/areas/export', [AdminController::class, 'exportAreas'])->name('areas.export');
        Route::get('/mekhalas/export', [AdminController::class, 'exportMekhalas'])->name('mekhalas.export');
        Route::get('/units/export', [AdminController::class, 'exportUnits'])->name('units.export');
    });
    
    // Application routes
    Route::get('/applications/export', [ApplicationController::class, 'export'])->name('applications.export');
    Route::get('/applications/{application}/history', [ApplicationController::class, 'history'])->name('applications.history');
    Route::resource('applications', ApplicationController::class);
    Route::get('/applications/{application}/download', [ApplicationController::class, 'download'])->name('applications.download');
    Route::post('/applications/validate-field', [ApplicationController::class, 'validateField'])->name('applications.validate-field');
    Route::get('/applications-review', [ApplicationController::class, 'review'])->name('applications.review');
    Route::post('/applications/{application}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/applications/{application}/reject', [ApplicationController::class, 'reject'])->name('applications.reject');
    
    // Collection routes
    Route::get('/collections/export', [CollectionController::class, 'export'])->name('collections.export');
    Route::get('/collections/report', [CollectionController::class, 'collectionReport'])->name('collections.report');
    Route::get('/collections/report/drill-down', [CollectionController::class, 'collectionReportDrillDown'])->name('collections.report.drilldown');
    Route::get('/collections/receive', [CollectionController::class, 'receiveCollections'])->name('collections.receive');
    Route::patch('/collections/{collection}/mark-received', [CollectionController::class, 'markAsReceived'])->name('collections.mark-received');
    Route::resource('collections', CollectionController::class);
    Route::get('/unit-collections', [CollectionController::class, 'unitCollections'])->name('collections.units');
    Route::get('/area-collections', [CollectionController::class, 'areaCollections'])->name('collections.area');
    
    // Investment routes
    Route::resource('investments', App\Http\Controllers\InvestmentController::class);
    Route::post('/investments/{investment}/add-income', [App\Http\Controllers\InvestmentController::class, 'addIncome'])->name('investments.add-income');

    Route::post('/investments/{investment}/return-capital', [App\Http\Controllers\InvestmentController::class, 'returnCapital'])->name('investments.return-capital');
    
    // Expense routes
    // Expense routes  
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{expense}', [ExpenseController::class, 'show'])->name('expenses.show');
    Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::get('/expenses/{expense}/bill', [ExpenseController::class, 'viewBill'])->name('expenses.view-bill');
    
    // Report routes
    Route::middleware('mekhala')->prefix('reports')->name('reports.')->group(function () {
        Route::get('/financial-statement', [ReportController::class, 'financialStatement'])->name('financial');
        Route::get('/east-mekhala-financial', [ReportController::class, 'eastMekhalaFinancial'])->name('east-financial');
        Route::get('/west-mekhala-financial', [ReportController::class, 'westMekhalaFinancial'])->name('west-financial');
        Route::get('/combined-financial', [ReportController::class, 'combinedFinancial'])->name('combined-financial');
        Route::get('/collection', [ReportController::class, 'collectionReport'])->name('collection');
        Route::get('/application-payment', [ReportController::class, 'applicationPaymentReport'])->name('application-payment');
        Route::get('/mekhala', [ReportController::class, 'mekhalaReport'])->name('mekhala');
        Route::get('/mekhala/drill-down', [ReportController::class, 'mekhalaReportDrillDown'])->name('mekhala.drilldown');
        Route::get('/collection/mekhala-drill-down', [ReportController::class, 'collectionMekhalaDrillDown'])->name('collection.mekhala-drilldown');
        Route::get('/collection/area-drill-down', [ReportController::class, 'collectionAreaDrillDown'])->name('collection.area-drilldown');
        Route::get('/export-financial', [ReportController::class, 'exportFinancialStatement'])->name('export-financial');
    });
    
    // API routes for dynamic dropdowns
    Route::get('/api/areas/{area}/units', function($areaId) {
        return \App\Models\Unit::where('area_id', $areaId)->get(['id', 'name']);
    });
});

