<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(),
            'type' => $this->faker->randomElement(['outbound', 'inbound']),
            'tour_id' => null,
            'client_or_supplier_name' => $this->faker->company(),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'issue_date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'status' => 'pending',
            'notes' => $this->faker->sentence(),
        ];
    }
}
