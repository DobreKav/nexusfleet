<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('tax_number')->unique();
            $table->string('username')->unique();
            $table->enum('license_type', ['trial', 'paid'])->default('trial');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->date('license_expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
