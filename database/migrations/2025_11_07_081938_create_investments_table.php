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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->date('investment_date');
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->decimal('income_generated', 15, 2)->default(0);
            $table->enum('status', ['invested', 'capital_returned'])->default('invested');
            $table->decimal('returned_amount', 15, 2)->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
