<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historical_applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('passport_no')->nullable();
            $table->string('civil_id')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('category')->nullable();
            $table->string('application_type')->nullable();
            $table->string('area_name')->nullable();
            $table->string('unit_name')->nullable();
            $table->string('status')->nullable();
            $table->decimal('approved_amount', 10, 3)->nullable();
            $table->date('applied_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historical_applications');
    }
};
