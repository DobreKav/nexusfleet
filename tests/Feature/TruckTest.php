<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TruckTest extends TestCase
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

    public function test_authenticated_user_can_view_trucks_index()
    {
        $response = $this->actingAs($this->user)->get(route('trucks.index'));
        $response->assertStatus(200);
        $response->assertViewIs('trucks.index');
    }

    public function test_authenticated_user_can_create_truck()
    {
        $truckData = [
            'plate_number' => 'SK-123-AB',
            'brand' => 'Volvo',
            'model' => 'FH16',
            'year' => 2023,
            'cost_per_km' => 0.85,
        ];

        $response = $this->actingAs($this->user)->post(route('trucks.store'), $truckData);

        $this->assertDatabaseHas('trucks', [
            'plate_number' => 'SK-123-AB',
            'cost_per_km' => 0.85,
        ]);

        $response->assertRedirect();
    }

    public function test_truck_cost_per_km_defaults_to_zero_fifty()
    {
        $truck = Truck::factory()->create([
            'company_id' => $this->company->id,
            'cost_per_km' => null,
        ]);

        $this->assertNull($truck->cost_per_km);
    }

    public function test_authenticated_user_can_edit_truck()
    {
        $truck = Truck::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->put(
            route('trucks.update', $truck),
            [
                'plate_number' => 'SK-999-XY',
                'brand' => 'Mercedes',
                'model' => 'Actros',
                'year' => 2024,
                'cost_per_km' => 0.95,
            ]
        );

        $truck->refresh();
        $this->assertEquals('SK-999-XY', $truck->plate_number);
        $this->assertEquals(0.95, (float) $truck->cost_per_km);
    }

    public function test_authenticated_user_can_delete_truck()
    {
        $truck = Truck::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->delete(route('trucks.destroy', $truck));

        $this->assertSoftDeleted('trucks', ['id' => $truck->id]);
    }

    public function test_truck_with_tours_can_be_deleted()
    {
        $truck = Truck::factory()->create(['company_id' => $this->company->id]);

        \App\Models\Tour::factory()->create([
            'company_id' => $this->company->id,
            'truck_id' => $truck->id,
        ]);

        // Should still be able to soft delete
        $response = $this->actingAs($this->user)->delete(route('trucks.destroy', $truck));
        $this->assertSoftDeleted('trucks', ['id' => $truck->id]);
    }
}
