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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('front_page_photo');
            $table->string('name');
            $table->string('passport_no');
            $table->string('civil_id');
            $table->string('mobile_number');
            $table->enum('category', ['health', 'finance']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->decimal('approved_amount', 10, 2)->nullable();
            $table->date('approved_date')->nullable();
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
