<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'admin_user_id' => User::factory(),
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'tax_number' => $this->faker->unique()->numerify('###########'),
            'username' => $this->faker->unique()->userName(),
            'license_type' => 'trial',
            'status' => 'active',
            'license_expires_at' => now()->addYear(),
        ];
    }
}
