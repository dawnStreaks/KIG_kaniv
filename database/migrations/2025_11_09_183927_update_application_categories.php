<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('category');
        });
        
        Schema::table('applications', function (Blueprint $table) {
            $table->enum('category', ['medical_support', 'financial_support', 'iqama_visa_residency', 'ticket'])->after('mobile_number');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('category');
        });
        
        Schema::table('applications', function (Blueprint $table) {
            $table->enum('category', ['health', 'finance'])->after('mobile_number');
        });
    }
};