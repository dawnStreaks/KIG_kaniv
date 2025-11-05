<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('term')->nullable()->after('collection_date');
            $table->string('type')->nullable()->after('term');
            $table->integer('year')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn(['term', 'type', 'year']);
        });
    }
};