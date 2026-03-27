<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DriverTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create(['admin_user_id' => $this->user->id]);
        $this->user->update(['company_id' => $this->company->id]);
    }

    public function test_authenticated_user_can_view_drivers_index()
    {
        $response = $this->actingAs($this->user)->get(route('drivers.index'));
        $response->assertStatus(200);
        $response->assertViewIs('drivers.index');
    }

    public function test_authenticated_user_can_create_driver()
    {
        $driverData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'license_number' => 'LIC-123456',
            'phone' => '+389-70-123456',
            'email' => 'john@example.com',
            'username' => 'johndoe',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->actingAs($this->user)->post(route('drivers.store'), $driverData);

        $this->assertDatabaseHas('drivers', [
            'first_name' => 'John',
            'license_number' => 'LIC-123456',
        ]);

        $response->assertRedirect();
    }

    public function test_authenticated_user_can_edit_driver()
    {
        $driver = Driver::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->put(
            route('drivers.update', $driver),
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'license_number' => 'LIC-999999',
                'phone' => '+389-70-999999',
            ]
        );

        $driver->refresh();
        $this->assertEquals('Jane', $driver->first_name);
        $this->assertEquals('Smith', $driver->last_name);
    }

    public function test_authenticated_user_can_delete_driver()
    {
        $driver = Driver::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->delete(route('drivers.destroy', $driver));

        $this->assertSoftDeleted('drivers', ['id' => $driver->id]);
    }

    public function test_driver_validation_requires_email()
    {
        $driverData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'license_number' => 'LIC-123456',
            'phone' => '+389-70-123456',
            // Missing email
        ];

        $response = $this->actingAs($this->user)->post(route('drivers.store'), $driverData);

        $response->assertSessionHasErrors('username');
    }
}
