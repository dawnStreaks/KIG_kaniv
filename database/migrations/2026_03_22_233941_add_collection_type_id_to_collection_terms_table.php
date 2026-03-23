<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collection_terms', function (Blueprint $table) {
            $table->foreignId('collection_type_id')->nullable()->after('is_active')->constrained('collection_types')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('collection_terms', function (Blueprint $table) {
            $table->dropForeign(['collection_type_id']);
            $table->dropColumn('collection_type_id');
        });
    }
};
