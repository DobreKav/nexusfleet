<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Truck;
use Illuminate\Database\Eloquent\Factories\Factory;

class TruckFactory extends Factory
{
    protected $model = Truck::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'plate_number' => $this->faker->unique()->regexify('[A-Z]{2}-[0-9]{3}-[A-Z]{2}'),
            'brand' => $this->faker->randomElement(['Volvo', 'Mercedes', 'Scania', 'MAN', 'Iveco']),
            'model' => $this->faker->word(),
            'year' => $this->faker->numberBetween(2015, 2024),
            'total_km' => $this->faker->numberBetween(1000, 500000),
            'current_odometer' => $this->faker->numberBetween(1000, 500000),
            'service_interval_km' => 50000,
            'last_service_date' => $this->faker->dateTime(),
            'status' => 'active',
            'cost_per_km' => $this->faker->randomFloat(2, 0.40, 1.50),
        ];
    }
}
