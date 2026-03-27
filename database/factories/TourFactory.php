<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Tour;
use App\Models\Truck;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourFactory extends Factory
{
    protected $model = Tour::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'truck_id' => Truck::factory(),
            'driver_id' => Driver::factory(),
            'partner_id' => null,
            'start_location' => $this->faker->city(),
            'end_location' => $this->faker->city(),
            'start_date' => now(),
            'end_date' => now()->addDays($this->faker->numberBetween(1, 5)),
            'total_km' => $this->faker->numberBetween(100, 1000),
            'cost_per_km' => null,
            'total_cost' => 0,
            'status' => $this->faker->randomElement(['planned', 'in-progress', 'completed']),
        ];
    }
}
