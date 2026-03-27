<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Tour;
use App\Models\Truck;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Company $company;
    protected Truck $truck;
    protected Driver $driver;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->company = Company::factory()->create(['admin_user_id' => $this->user->id]);
        $this->user->update(['company_id' => $this->company->id]);
        $this->truck = Truck::factory()->create(['company_id' => $this->company->id, 'cost_per_km' => 0.75]);
        $this->driver = Driver::factory()->create(['company_id' => $this->company->id]);
    }

    public function test_authenticated_user_can_view_tours_index()
    {
        $response = $this->actingAs($this->user)->get(route('tours.index'));
        $response->assertStatus(200);
        $response->assertViewIs('tours.index');
    }

    public function test_authenticated_user_can_create_tour()
    {
        $tourData = [
            'truck_id' => $this->truck->id,
            'driver_id' => $this->driver->id,
            'start_location' => 'Skopje',
            'end_location' => 'Thessaloniki',
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDay()->toDateTimeString(),
            'total_km' => 400,
            'cost_per_km' => 0.80,
            'status' => 'planned',
        ];

        $response = $this->actingAs($this->user)->post(route('tours.store'), $tourData);

        $this->assertDatabaseHas('tours', [
            'truck_id' => $this->truck->id,
            'driver_id' => $this->driver->id,
            'total_km' => 400,
            'cost_per_km' => 0.80,
        ]);

        $response->assertRedirect();
    }

    public function test_tour_auto_calculates_total_cost_with_override()
    {
        $tour = Tour::factory()->create([
            'company_id' => $this->company->id,
            'truck_id' => $this->truck->id,
            'total_km' => 100,
            'cost_per_km' => 0.80, // Override truck's 0.75
        ]);

        // Should calculate as 100 * 0.80 = 80.00
        $this->assertEquals(80.00, (float) $tour->total_cost);
    }

    public function test_tour_auto_calculates_total_cost_with_truck_default()
    {
        $tour = Tour::factory()->create([
            'company_id' => $this->company->id,
            'truck_id' => $this->truck->id,
            'total_km' => 100,
            'cost_per_km' => null, // Use truck's default
        ]);

        // Should calculate as 100 * 0.75 (truck default) = 75.00
        $this->assertEquals(75.00, (float) $tour->total_cost);
    }

    public function test_tour_auto_calculates_total_cost_with_system_default()
    {
        $truckNoDefault = Truck::factory()->create([
            'company_id' => $this->company->id,
            'cost_per_km' => null,
        ]);

        $tour = Tour::factory()->create([
            'company_id' => $this->company->id,
            'truck_id' => $truckNoDefault->id,
            'total_km' => 100,
            'cost_per_km' => null,
        ]);

        // Should calculate as 100 * 0.50 (system default) = 50.00
        $this->assertEquals(50.00, (float) $tour->total_cost);
    }

    public function test_authenticated_user_can_edit_tour()
    {
        $tour = Tour::factory()->create([
            'company_id' => $this->company->id,
            'truck_id' => $this->truck->id,
        ]);

        $response = $this->actingAs($this->user)->put(
            route('tours.update', $tour),
            [
                'truck_id' => $this->truck->id,
                'driver_id' => $this->driver->id,
                'start_location' => 'Sofia',
                'end_location' => 'Athens',
                'start_date' => now()->toDateTimeString(),
                'end_date' => now()->addDay()->toDateTimeString(),
                'total_km' => 500,
                'cost_per_km' => 0.85,
                'status' => 'completed',
            ]
        );

        $tour->refresh();
        $this->assertEquals(500, $tour->total_km);
        $this->assertEquals(0.85, (float) $tour->cost_per_km);
    }

    public function test_authenticated_user_can_delete_tour()
    {
        $tour = Tour::factory()->create(['company_id' => $this->company->id]);

        $response = $this->actingAs($this->user)->delete(route('tours.destroy', $tour));

        $this->assertSoftDeleted('tours', ['id' => $tour->id]);
    }

    public function test_tour_total_cost_recalculates_on_update()
    {
        $tour = Tour::factory()->create([
            'company_id' => $this->company->id,
            'truck_id' => $this->truck->id,
            'total_km' => 100,
            'cost_per_km' => 0.50,
        ]);

        $this->assertEquals(50.00, (float) $tour->total_cost);

        // Update the cost_per_km
        $tour->update(['cost_per_km' => 0.80]);

        // Should recalculate as 100 * 0.80 = 80.00
        $this->assertEquals(80.00, (float) $tour->total_cost);
    }
}
