<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
    $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
    $table->integer('period_month');
    $table->integer('period_year');
    $table->decimal('amount', 12, 2);
    $table->date('due_date');
    $table->enum('status', ['unpaid', 'pending', 'paid'])->default('unpaid');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
