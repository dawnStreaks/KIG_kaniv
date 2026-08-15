<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('paid_by_mekhala_id')->nullable()->after('paid_by_area_id');
            $table->foreign('paid_by_mekhala_id')->references('id')->on('mekhalas');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign(['paid_by_mekhala_id']);
            $table->dropColumn('paid_by_mekhala_id');
        });
    }
};
