<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->decimal('cost_per_km', 8, 2)->nullable()->default(0.50)->after('service_interval_km')->comment('Cost in EUR per kilometer');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->decimal('total_cost', 12, 2)->nullable()->after('total_km')->comment('Calculated cost: total_km * truck.cost_per_km');
        });
    }

    public function down(): void
    {
        Schema::table('trucks', function (Blueprint $table) {
            $table->dropColumn('cost_per_km');
        });

        Schema::table('tours', function (Blueprint $table) {
            $table->dropColumn('total_cost');
        });
    }
};
