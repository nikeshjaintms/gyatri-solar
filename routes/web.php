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
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SettingsController;

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

    // Admin-only & Authorized Employee Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('customers', CustomerController::class)->middleware('module.permission:customers');

        Route::prefix('admin')->group(function () {
            Route::resource('employees', EmployeeController::class)->middleware('module.permission:employees');
            Route::post('employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])
                ->name('employees.toggle-status')
                ->middleware('module.permission:employees');

            Route::resource('technicians', TechnicianController::class)->middleware('module.permission:technicians');
            Route::resource('services', ServiceController::class)->middleware('module.permission:services');
            Route::resource('service-requests', ServiceRequestController::class)->middleware('module.permission:service_requests');
            Route::resource('job-assignments', JobAssignmentController::class)->middleware('module.permission:job_assignments');
            Route::resource('job-status-tracking', JobStatusTrackingController::class)->middleware('module.permission:job_status_tracking');
            Route::resource('invoices', InvoiceController::class)->middleware('module.permission:invoices');
            Route::resource('employee-attendances', EmployeeAttendanceController::class)->middleware('module.permission:employee_attendances');

            // Enquiry Details AJAX Endpoint
            Route::get('enquiries/{id}/details', [EnquiryController::class, 'getDetails'])
                ->name('enquiries.details')
                ->middleware('module.permission:enquiries');

            // Quotation Print Page
            Route::get('quotations/{id}/print', [QuotationController::class, 'print'])
                ->name('quotations.print')
                ->middleware('module.permission:quotations');

            Route::resource('enquiries', EnquiryController::class)->middleware('module.permission:enquiries');
            Route::resource('quotations', QuotationController::class)->middleware('module.permission:quotations');
            Route::resource('site-surveys', SiteSurveyController::class)->middleware('module.permission:site_surveys');
            Route::resource('users', UserController::class)->middleware('module.permission:users');
            Route::resource('products', ProductController::class)->middleware('module.permission:products');
            Route::resource('projects', ProjectController::class)->middleware('module.permission:projects');
            Route::resource('payments', PaymentController::class)->middleware('module.permission:payments');
            Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
            Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

            // Reports
            Route::prefix('reports')->middleware('module.permission:reports')->group(function () {
                Route::get('/',                  [ReportController::class, 'index'])->name('reports.index');
                Route::get('/service-requests', [ReportController::class, 'serviceRequests'])->name('reports.service-requests');
                Route::get('/job-assignments',  [ReportController::class, 'jobAssignments'])->name('reports.job-assignments');
                Route::get('/invoices',         [ReportController::class, 'invoices'])->name('reports.invoices');
                Route::get('/payments',         [ReportController::class, 'payments'])->name('reports.payments');
            });
        });
    });
});

require __DIR__.'/auth.php';