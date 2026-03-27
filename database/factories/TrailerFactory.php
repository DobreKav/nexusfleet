<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Trailer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrailerFactory extends Factory
{
    protected $model = Trailer::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'license_plate' => $this->faker->unique()->regexify('[A-Z]{2}-[0-9]{3}-[A-Z]{2}'),
            'type' => $this->faker->randomElement(['Flatbed', 'Refrigerated', 'Tanker', 'Box', 'Container']),
            'capacity_tons' => $this->faker->numberBetween(10, 30),
        ];
    }
}
