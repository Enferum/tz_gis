<?php

use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TripController::class, 'getDashboard'])->name('dashboard');
Route::get('/searchTips', [TripController::class, 'searchTrips'])->name('trips');

Route::get('/calculation', [TripController::class, 'getCalculation'])->name('calculation');
Route::get('/drivers', [TripController::class, 'getDrivers'])->name('drivers');
Route::get('/calculatedTips', [TripController::class, 'getCalculationTips'])->name('calculated-trips');