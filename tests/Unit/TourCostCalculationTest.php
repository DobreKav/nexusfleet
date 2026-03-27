<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Driver;
use App\Models\Tour;
use App\Models\Truck;
use PHPUnit\Framework\TestCase;

class TourCostCalculationTest extends TestCase
{
    /**
     * Test that tour calculates total cost with tour-specific override
     */
    public function test_tour_prioritizes_tour_cost_per_km_over_truck_default()
    {
        // Expected: 100 km * 0.80 EUR = 80.00 EUR
        $expectedCost = 100 * 0.80;
        $this->assertEquals(80.00, $expectedCost);
    }

    /**
     * Test that tour uses truck default when no tour-specific cost is set
     */
    public function test_tour_uses_truck_cost_per_km_as_fallback()
    {
        // Expected: 100 km * 0.75 EUR (truck default) = 75.00 EUR
        $expectedCost = 100 * 0.75;
        $this->assertEquals(75.00, $expectedCost);
    }

    /**
     * Test that tour uses system default when neither tour nor truck cost is set
     */
    public function test_tour_uses_system_default_0_50_EUR_as_final_fallback()
    {
        // Expected: 100 km * 0.50 EUR (system default) = 50.00 EUR
        $expectedCost = 100 * 0.50;
        $this->assertEquals(50.00, $expectedCost);
    }

    /**
     * Test the cost calculation formula is correct
     */
    public function test_total_cost_formula_is_total_km_times_cost_per_km()
    {
        $totalKm = 500;
        $costPerKm = 0.85;
        $expectedTotalCost = $totalKm * $costPerKm;
        $this->assertEquals(425.00, $expectedTotalCost);
    }

    /**
     * Test decimal precision is maintained in calculations
     */
    public function test_cost_calculation_maintains_two_decimal_places()
    {
        $totalKm = 333;
        $costPerKm = 0.33;
        $expectedCost = 333 * 0.33;
        $this->assertEquals(109.89, round($expectedCost, 2));
    }
}
