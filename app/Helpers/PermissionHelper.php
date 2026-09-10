<?php

namespace App\Helpers;

use Spatie\Permission\Models\Permission;

class PermissionHelper
{
    /**
     * Get grouped permissions for UI display.
     */
    public static function getPermissionGroups(): array
    {
        return [
            'Sales & CRM' => [
                'Customers' => [
                    'icon' => 'bi-people',
                    'permissions' => [
                        'view_customers' => 'View Customers',
                        'create_customers' => 'Create Customer',
                        'update_customers' => 'Edit Customer',
                        'delete_customers' => 'Delete Customer',
                    ],
                ],
                'Site Surveys' => [
                    'icon' => 'bi-map',
                    'permissions' => [
                        'view_site_surveys' => 'View Site Surveys',
                        'create_site_surveys' => 'Create Survey',
                        'update_site_surveys' => 'Edit Survey',
                        'delete_site_surveys' => 'Delete Survey',
                    ],
                ],
                'Quotations' => [
                    'icon' => 'bi-file-earmark-ruled',
                    'permissions' => [
                        'view_quotations' => 'View Quotations',
                        'create_quotations' => 'Create Quotation',
                        'update_quotations' => 'Edit Quotation',
                        'delete_quotations' => 'Delete Quotation',
                        'print_quotations' => 'Print / PDF',
                    ],
                ],
                'Enquiries' => [
                    'icon' => 'bi-chat-left-quote',
                    'permissions' => [
                        'view_enquiries' => 'View Enquiries',
                        'create_enquiries' => 'Create Enquiry',
                        'update_enquiries' => 'Edit Enquiry',
                        'delete_enquiries' => 'Delete Enquiry',
                    ],
                ],
            ],
            'Operations & Field Work' => [
                'Job Assignments' => [
                    'icon' => 'bi-tools',
                    'permissions' => [
                        'view_job_assignments' => 'View Job Assignments',
                        'create_job_assignments' => 'Create Assignment',
                        'update_job_assignments' => 'Edit Assignment',
                        'delete_job_assignments' => 'Delete Assignment',
                    ],
                ],
                'Job Status Tracking' => [
                    'icon' => 'bi-geo-alt',
                    'permissions' => [
                        'view_job_status_tracking' => 'View Tracking',
                        'create_job_status_tracking' => 'Update Status',
                        'update_job_status_tracking' => 'Edit Tracking',
                        'delete_job_status_tracking' => 'Delete Tracking',
                    ],
                ],
                'Service Requests' => [
                    'icon' => 'bi-clipboard2-check',
                    'permissions' => [
                        'view_service_requests' => 'View Requests',
                        'create_service_requests' => 'Create Request',
                        'update_service_requests' => 'Edit Request',
                        'delete_service_requests' => 'Delete Request',
                    ],
                ],
                'Technicians' => [
                    'icon' => 'bi-person-badge',
                    'permissions' => [
                        'view_technicians' => 'View Technicians',
                        'create_technicians' => 'Create Technician',
                        'update_technicians' => 'Edit Technician',
                        'delete_technicians' => 'Delete Technician',
                    ],
                ],
            ],
            'Billing & Finance' => [
                'Invoices & Payments' => [
                    'icon' => 'bi-receipt',
                    'permissions' => [
                        'view_invoices' => 'View Invoices & Payments',
                        'create_invoices' => 'Create Invoice',
                        'update_invoices' => 'Edit Invoice',
                        'delete_invoices' => 'Delete Invoice',
                    ],
                ],
            ],
            'Masters & Catalog' => [
                'Products' => [
                    'icon' => 'bi-box-seam',
                    'permissions' => [
                        'view_products' => 'View Products',
                        'create_products' => 'Create Product',
                        'update_products' => 'Edit Product',
                        'delete_products' => 'Delete Product',
                    ],
                ],
                'Services' => [
                    'icon' => 'bi-wrench-adjustable',
                    'permissions' => [
                        'view_services' => 'View Services',
                        'create_services' => 'Create Service',
                        'update_services' => 'Edit Service',
                        'delete_services' => 'Delete Service',
                    ],
                ],
            ],
            'Staff & Administration' => [
                'Employees' => [
                    'icon' => 'bi-person-workspace',
                    'permissions' => [
                        'view_employees' => 'View Employees',
                        'create_employees' => 'Create Employee',
                        'update_employees' => 'Edit Employee',
                        'delete_employees' => 'Delete Employee',
                    ],
                ],
                'Employee Attendance' => [
                    'icon' => 'bi-calendar-check',
                    'permissions' => [
                        'view_employee_attendances' => 'View Attendance',
                        'create_employee_attendances' => 'Mark Attendance',
                        'update_employee_attendances' => 'Edit Attendance',
                        'delete_employee_attendances' => 'Delete Attendance',
                    ],
                ],
                'Users' => [
                    'icon' => 'bi-person-gear',
                    'permissions' => [
                        'view_users' => 'View Users',
                        'create_users' => 'Create User',
                        'update_users' => 'Edit User',
                        'delete_users' => 'Delete User',
                    ],
                ],
            ],
            'Core & Analytics' => [
                'Dashboard' => [
                    'icon' => 'bi-speedometer2',
                    'permissions' => [
                        'view_dashboard' => 'View Dashboard Overview',
                    ],
                ],
                'Reports' => [
                    'icon' => 'bi-bar-chart-line',
                    'permissions' => [
                        'view_reports' => 'View Analytical Reports',
                    ],
                ],
            ],
        ];
    }
}
