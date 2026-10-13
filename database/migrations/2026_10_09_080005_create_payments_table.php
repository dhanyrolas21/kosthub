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
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
    $table->string('proof_image');
    $table->timestamp('paid_at')->nullable();
    $table->timestamp('verified_at')->nullable();
    $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
    $table->text('notes')->nullable();
    $table->timestamps();
}); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
