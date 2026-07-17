<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\TechnicianController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\Admin\JobAssignmentController;
use App\Http\Controllers\Admin\JobStatusTrackingController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\EmployeeAttendanceController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\SiteSurveyController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Employee Routes
    Route::middleware(['employee'])->group(function () {
        Route::get('/employee/attendance', [EmployeeAttendanceController::class, 'create'])->name('employee.attendance');
        Route::post('/employee/attendance/punch-in', [EmployeeAttendanceController::class, 'store'])->name('employee.attendance.punch-in');
        Route::put('/employee/attendance/punch-out/{id}', [EmployeeAttendanceController::class, 'update'])->name('employee.attendance.punch-out');
    });

    // Admin-only Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('customers', CustomerController::class);

        Route::prefix('admin')->group(function () {
            Route::resource('employees', EmployeeController::class);
            Route::post('employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');

            Route::resource('technicians', TechnicianController::class);
            Route::resource('services', ServiceController::class);
            Route::resource('service-requests', ServiceRequestController::class);
            Route::resource('job-assignments', JobAssignmentController::class);
            Route::resource('job-status-tracking', JobStatusTrackingController::class);
            Route::resource('invoices', InvoiceController::class);
            Route::resource('employee-attendances', EmployeeAttendanceController::class);

            // Enquiry Details AJAX Endpoint
            Route::get('enquiries/{id}/details', [EnquiryController::class, 'getDetails'])->name('enquiries.details');
            // Quotation Print Page
            Route::get('quotations/{id}/print', [QuotationController::class, 'print'])->name('quotations.print');

            Route::resource('enquiries', EnquiryController::class);
            Route::resource('quotations', QuotationController::class);
            Route::resource('site-surveys', SiteSurveyController::class);
            Route::resource('users', UserController::class);
            Route::resource('products', ProductController::class);

            // Reports
            Route::get('reports',                  [ReportController::class, 'index'])->name('reports.index');
            Route::get('reports/service-requests', [ReportController::class, 'serviceRequests'])->name('reports.service-requests');
            Route::get('reports/job-assignments',  [ReportController::class, 'jobAssignments'])->name('reports.job-assignments');
            Route::get('reports/invoices',         [ReportController::class, 'invoices'])->name('reports.invoices');
            Route::get('reports/payments',         [ReportController::class, 'payments'])->name('reports.payments');
        });
    });
});

require __DIR__.'/auth.php';