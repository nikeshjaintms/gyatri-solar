<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\EmployeeLocation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class EmployeeLocationTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function createEmployeeUser(string $name = 'John Doe', string $role = 'Employee'): array
    {
        $user = User::factory()->create([
            'name' => $name,
            'role' => $role,
            'status' => 'Active',
        ]);

        $employee = Employee::create([
            'user_id' => $user->id,
            'employee_id' => 'EMP-' . rand(1000, 9999),
            'department' => 'Field Operations',
            'designation' => 'Solar Technician',
            'joining_date' => '2026-01-01',
            'salary' => 25000,
        ]);

        return [$user, $employee];
    }

    public function test_authenticated_employee_can_submit_own_gps_location(): void
    {
        [$user, $employee] = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $payload = [
            'latitude' => 23.022505,
            'longitude' => 72.571362,
            'accuracy' => 12.5,
            'speed' => 15.2,
            'battery_level' => 85,
            'tracked_at' => '2026-10-09 10:30:00',
            'device_id' => 'Android-TestDevice-01',
            'sync_id' => 'sync-test-001',
        ];

        $response = $this->postJson(route('api.employee.location.store'), $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'employee_id' => $employee->id,
                    'latitude' => 23.022505,
                    'longitude' => 72.571362,
                    'accuracy' => 12.5,
                    'battery_level' => 85,
                    'sync_id' => 'sync-test-001',
                ],
            ]);

        $this->assertDatabaseHas('employee_locations', [
            'employee_id' => $employee->id,
            'sync_id' => 'sync-test-001',
            'battery_level' => 85,
        ]);
    }

    public function test_server_derives_employee_identity_and_ignores_spoofed_employee_id(): void
    {
        [$userA, $employeeA] = $this->createEmployeeUser('Employee A');
        [$userB, $employeeB] = $this->createEmployeeUser('Employee B');

        Sanctum::actingAs($userA);

        $payload = [
            'employee_id' => $employeeB->id,
            'latitude' => 23.0300,
            'longitude' => 72.5800,
            'sync_id' => 'sync-spoof-test',
        ];

        $response = $this->postJson(route('api.employee.location.store'), $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('employee_locations', [
            'employee_id' => $employeeA->id,
            'sync_id' => 'sync-spoof-test',
        ]);

        $this->assertDatabaseMissing('employee_locations', [
            'employee_id' => $employeeB->id,
            'sync_id' => 'sync-spoof-test',
        ]);
    }

    public function test_user_without_linked_employee_profile_cannot_submit_location(): void
    {
        $user = User::factory()->create([
            'name' => 'Standalone User',
            'role' => 'Employee',
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson(route('api.employee.location.store'), [
            'latitude' => 23.0225,
            'longitude' => 72.5713,
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_duplicate_submission_with_same_sync_id_is_idempotent(): void
    {
        [$user, $employee] = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $payload = [
            'latitude' => 23.0225,
            'longitude' => 72.5713,
            'sync_id' => 'sync-unique-idempotent-001',
        ];

        $res1 = $this->postJson(route('api.employee.location.store'), $payload);
        $res1->assertStatus(201);

        $res2 = $this->postJson(route('api.employee.location.store'), $payload);
        $res2->assertStatus(201);

        $this->assertSame(1, EmployeeLocation::where('sync_id', 'sync-unique-idempotent-001')->count());
    }

    public function test_batch_offline_location_synchronization(): void
    {
        [$user, $employee] = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $batchPayload = [
            'locations' => [
                [
                    'latitude' => 23.0200,
                    'longitude' => 72.5700,
                    'accuracy' => 10,
                    'speed' => 5.5,
                    'battery_level' => 90,
                    'tracked_at' => '2026-10-09 08:00:00',
                    'sync_id' => 'batch-pt-1',
                ],
                [
                    'latitude' => 23.0250,
                    'longitude' => 72.5750,
                    'accuracy' => 12,
                    'speed' => 18.0,
                    'battery_level' => 88,
                    'tracked_at' => '2026-10-09 08:05:00',
                    'sync_id' => 'batch-pt-2',
                ],
                [
                    'latitude' => 23.0300,
                    'longitude' => 72.5800,
                    'accuracy' => 8,
                    'speed' => 22.5,
                    'battery_level' => 85,
                    'tracked_at' => '2026-10-09 08:10:00',
                    'sync_id' => 'batch-pt-3',
                ],
            ],
        ];

        $response = $this->postJson(route('api.employee.location.store'), $batchPayload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'saved_count' => 3,
                    'duplicate_count' => 0,
                    'employee_id' => $employee->id,
                ],
            ]);

        $this->assertSame(3, EmployeeLocation::where('employee_id', $employee->id)->count());
    }

    public function test_validation_rejects_invalid_coordinates_and_battery_levels(): void
    {
        [$user, $employee] = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $resLat = $this->postJson(route('api.employee.location.store'), [
            'latitude' => 105.0,
            'longitude' => 72.57,
        ]);
        $resLat->assertStatus(422)->assertJsonValidationErrors(['latitude']);

        $resLon = $this->postJson(route('api.employee.location.store'), [
            'latitude' => 23.0,
            'longitude' => 195.0,
        ]);
        $resLon->assertStatus(422)->assertJsonValidationErrors(['longitude']);

        $resBat = $this->postJson(route('api.employee.location.store'), [
            'latitude' => 23.0,
            'longitude' => 72.0,
            'battery_level' => 150,
        ]);
        $resBat->assertStatus(422)->assertJsonValidationErrors(['battery_level']);
    }

    public function test_unauthenticated_request_is_rejected(): void
    {
        $response = $this->postJson(route('api.employee.location.store'), [
            'latitude' => 23.0225,
            'longitude' => 72.5713,
        ]);

        $response->assertStatus(401);
    }

    public function test_admin_can_view_employee_location_history_and_metrics(): void
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        [$user, $employee] = $this->createEmployeeUser('Technician Bob');

        $date = '2026-10-09';

        EmployeeLocation::create([
            'employee_id' => $employee->id,
            'latitude' => 23.0200,
            'longitude' => 72.5700,
            'tracked_at' => "{$date} 09:00:00",
            'accuracy' => 10,
            'speed' => 12.0,
            'battery_level' => 95,
        ]);

        EmployeeLocation::create([
            'employee_id' => $employee->id,
            'latitude' => 23.0500,
            'longitude' => 72.6000,
            'tracked_at' => "{$date} 09:30:00",
            'accuracy' => 15,
            'speed' => 25.0,
            'battery_level' => 90,
        ]);

        $this->actingAs($admin);

        $viewResponse = $this->get(route('employee-locations.index', [
            'employee_id' => $employee->id,
            'date' => $date,
        ]));
        $viewResponse->assertOk()
            ->assertSee('Technician Bob')
            ->assertSee('Live GPS Tracking');

        $ajaxResponse = $this->getJson(route('employee-locations.data', [
            'employee_id' => $employee->id,
            'date' => $date,
        ]));

        $ajaxResponse->assertOk()
            ->assertJson([
                'success' => true,
                'metrics' => [
                    'total_points' => 2,
                    'latest_battery' => 90,
                ],
            ]);
    }

    public function test_user_with_explicit_permission_can_access_tracking(): void
    {
        Permission::firstOrCreate(['name' => 'view_employee_locations', 'guard_name' => 'web']);

        $manager = User::factory()->create(['role' => 'Manager']);
        $manager->givePermissionTo('view_employee_locations');

        [$user, $employee] = $this->createEmployeeUser('Technician Bob');

        $this->actingAs($manager);

        $viewResponse = $this->get(route('employee-locations.index', [
            'employee_id' => $employee->id,
        ]));
        $viewResponse->assertOk();

        $ajaxResponse = $this->getJson(route('employee-locations.data', [
            'employee_id' => $employee->id,
        ]));
        $ajaxResponse->assertOk()->assertJson(['success' => true]);
    }

    public function test_user_without_permission_is_denied_access_to_admin_tracking(): void
    {
        $regularUser = User::factory()->create(['role' => 'Employee']);
        [$user, $employee] = $this->createEmployeeUser('Technician Bob');

        $this->actingAs($regularUser);

        $viewResponse = $this->get(route('employee-locations.index', [
            'employee_id' => $employee->id,
        ]));
        $viewResponse->assertRedirect(route('dashboard'));

        $ajaxResponse = $this->getJson(route('employee-locations.data', [
            'employee_id' => $employee->id,
        ]));
        $ajaxResponse->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_post_api_locations_sync_endpoint_directly(): void
    {
        [$user, $employee] = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $payload = [
            'latitude' => 23.022505,
            'longitude' => 72.571362,
            'accuracy' => 10.0,
            'sync_id' => 'sync-direct-endpoint-test',
        ];

        $response = $this->postJson('/api/locations/sync', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'employee_id' => $employee->id,
                    'latitude' => 23.022505,
                    'longitude' => 72.571362,
                    'sync_id' => 'sync-direct-endpoint-test',
                ],
            ]);
    }

    public function test_no_get_api_route_for_locations_sync(): void
    {
        [$user, $employee] = $this->createEmployeeUser();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/locations/sync');
        $response->assertStatus(405);
    }
}
