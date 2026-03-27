<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\DriverExpense;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

class DriverExpenseFactory extends Factory
{
    protected $model = DriverExpense::class;

    public function definition()
    {
        return [
            'driver_id' => Driver::factory(),
            'tour_id' => Tour::factory(),
            'type' => $this->faker->randomElement(['fuel', 'toll', 'maintenance', 'other']),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'description' => $this->faker->sentence(),
            'odometer_reading' => $this->faker->numberBetween(1000, 500000),
            'expense_date' => $this->faker->dateTime(),
        ];
    }
}
