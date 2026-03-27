<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverFactory extends Factory
{
    protected $model = Driver::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'license_number' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{6}'),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}
