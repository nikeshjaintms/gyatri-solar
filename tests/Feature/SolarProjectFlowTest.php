<?php

namespace Tests\Feature;

use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolarProjectFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_project_quotation_payment_and_service_request_flow(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'Admin']));

        $this->post(route('customers.store'), [
            'name' => 'Test Solar Customer',
            'phone' => '9876543210',
            'customer_type' => 'Commercial',
            'status' => 'Active',
        ])->assertSessionHasNoErrors();
        $customer = Customer::firstOrFail();

        $this->post(route('projects.store'), [
            'project_name' => 'Rooftop Installation',
            'customer_id' => $customer->id,
            'solar_capacity' => 10,
            'installation_address' => 'Ahmedabad, Gujarat',
            'status' => 'Completed',
            'completion_date' => '2026-10-06',
        ])->assertSessionHasNoErrors();

        $project = Project::firstOrFail();
        $this->assertSame('Commercial', $project->customer_type);
        $this->assertSame($customer->id, $project->customer->id);

        $product = Product::create([
            'product_code' => 'TEST0001',
            'name' => 'Solar Panel',
            'category' => 'Solar Panel',
            'unit' => 'Piece',
            'selling_price' => 100,
        ]);

        $this->post(route('quotations.store'), [
            'quotation_number' => 'QT-TEST-0001',
            'customer_id' => $customer->id,
            'project_id' => $project->id,
            'quotation_date' => '2026-10-06',
            'valid_until' => '2026-11-06',
            'status' => 'Accepted',
            'items' => [[
                'product_id' => $product->id,
                'quantity' => 2,
                'unit_price' => 100,
                'discount_percentage' => 0,
                'tax_percentage' => 18,
            ]],
        ])->assertSessionHasNoErrors();

        $quotation = Quotation::firstOrFail();
        $this->assertSame($project->id, $quotation->project_id);
        $this->assertSame(236.0, (float) $quotation->grand_total);

        $this->post(route('payments.store'), [
            'customer_id' => $customer->id,
            'project_id' => $project->id,
            'payment_date' => '2026-10-06',
            'amount' => 100,
            'payment_mode' => 'NEFT',
            'reference_number' => 'TEST-REF-001',
        ])->assertSessionHasNoErrors();

        $payment = Payment::firstOrFail();
        $this->assertSame($project->id, $payment->project_id);
        $this->assertSame($customer->id, $payment->customer_id);

        $service = Service::create([
            'service_name' => 'Maintenance Visit',
            'service_code' => 'TEST-MAINT',
            'status' => 'Active',
        ]);

        $this->post(route('service-requests.store'), [
            'customer_id' => $customer->id,
            'project_id' => $project->id,
            'service_id' => $service->id,
            'request_date' => '2026-10-06',
            'priority' => 'Medium',
            'status' => 'Pending',
            'description' => 'Routine system inspection',
        ])->assertSessionHasNoErrors();

        $serviceRequest = ServiceRequest::firstOrFail();
        $this->assertSame($project->id, $serviceRequest->project_id);
        $this->assertSame($customer->id, $serviceRequest->customer_id);
        $this->assertMatchesRegularExpression('/^SRV-\d{6}-\d{5}$/', $serviceRequest->service_number);
    }

    public function test_admin_can_update_company_settings(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'Admin']));

        $this->get(route('settings.edit'))->assertOk();
        $this->put(route('settings.update'), [
            'company_name' => 'Gayatri Solar Energy',
            'phone' => '9876543210',
            'email' => 'office@example.com',
            'gst_number' => '24ABCDE1234F1Z5',
            'address' => 'Ahmedabad, Gujarat',
        ])->assertRedirect(route('settings.edit'));

        $this->assertDatabaseHas('company_settings', [
            'company_name' => 'Gayatri Solar Energy',
            'email' => 'office@example.com',
        ]);
        $this->assertSame('Ahmedabad, Gujarat', CompanySetting::firstOrFail()->address);
    }

    public function test_all_customer_types_supported_and_details_api_works(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'Admin']));

        foreach (Customer::TYPES as $type) {
            $response = $this->post(route('customers.store'), [
                'name' => "Customer {$type}",
                'phone' => '9' . str_pad((string) rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
                'customer_type' => $type,
                'status' => 'Active',
                'city' => 'Surat',
                'address' => "Address of {$type}",
            ]);
            $response->assertSessionHasNoErrors();
        }

        $commercialCust = Customer::where('customer_type', 'Commercial')->firstOrFail();
        $this->assertSame('Commercial', $commercialCust->customer_type);

        $detailsResponse = $this->getJson("/admin/customers/{$commercialCust->id}/details");
        $detailsResponse->assertOk()
            ->assertJson([
                'id' => $commercialCust->id,
                'name' => $commercialCust->name,
                'customer_type' => 'Commercial',
            ]);
    }
}