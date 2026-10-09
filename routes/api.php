<?php

use App\Http\Controllers\Api\EmployeeLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/locations/sync', [EmployeeLocationController::class, 'store'])->name('api.employee.location.store');
});
