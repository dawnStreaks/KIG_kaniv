<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['unit_id']);
            $table->dropForeign(['area_id']);
            $table->dropColumn(['unit_id', 'area_id']);
        });
    }
};