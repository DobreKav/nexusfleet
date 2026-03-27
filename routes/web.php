<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\TrailerController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\DriverExpenseController;
use App\Http\Controllers\DistanceCalculatorController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Super Admin Routes
    Route::middleware('super_admin')->group(function () {
        Route::resource('companies', CompanyController::class);
    });

    // Admin Routes (for admins and staff - NOT drivers)
    Route::middleware('admin')->group(function () {
        Route::resource('trucks', TruckController::class);
        Route::resource('trailers', TrailerController::class);
        Route::resource('drivers', DriverController::class);
        Route::resource('tours', TourController::class);
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
        Route::resource('partners', PartnerController::class);
        Route::resource('expenses', DriverExpenseController::class);
        
        // Distance calculation
        Route::post('/calculate-distance', [DistanceCalculatorController::class, 'calculate'])
            ->name('calculate-distance');
    });

    // Driver Routes (for drivers only)
    Route::middleware('driver')->group(function () {
        Route::get('/driver/dashboard', [DriverDashboardController::class, 'index'])->name('driver.dashboard');
        Route::get('/driver/tour/{tour}', [DriverDashboardController::class, 'showTour'])->name('driver.tour.show');
        Route::post('/driver/tour/{tour}/complete', [DriverDashboardController::class, 'completeTour'])->name('driver.tour.complete');
        Route::post('/driver/tour/{tour}/expense', [DriverExpenseController::class, 'storeDriverExpense'])->name('driver.expense.store');
    });
});

require __DIR__ . '/auth.php';
