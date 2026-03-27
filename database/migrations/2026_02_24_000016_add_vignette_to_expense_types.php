<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('driver_expenses', function (Blueprint $table) {
            // Modify the enum type column to include 'vignette'
            $table->enum('type', ['fuel', 'toll', 'vignette', 'maintenance', 'other'])->change();
        });
    }

    public function down(): void
    {
        Schema::table('driver_expenses', function (Blueprint $table) {
            // Revert to old enum values
            $table->enum('type', ['fuel', 'toll', 'maintenance', 'other'])->change();
        });
    }
};
