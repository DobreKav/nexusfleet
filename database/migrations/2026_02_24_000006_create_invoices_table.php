<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->enum('type', ['inbound', 'outbound']);
            $table->foreignId('tour_id')->nullable()->constrained('tours')->nullOnDelete();
            $table->string('client_or_supplier_name');
            $table->decimal('amount', 12, 2);
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->enum('status', ['paid', 'pending'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
