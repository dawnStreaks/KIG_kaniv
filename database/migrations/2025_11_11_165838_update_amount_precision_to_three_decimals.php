<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->decimal('amount', 15, 3)->change();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->decimal('approved_amount', 15, 3)->nullable()->change();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->decimal('amount', 15, 3)->change();
        });

        Schema::table('investments', function (Blueprint $table) {
            $table->decimal('amount', 15, 3)->change();
            $table->decimal('income_generated', 15, 3)->default(0)->change();
            $table->decimal('returned_amount', 15, 3)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->change();
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->decimal('approved_amount', 15, 2)->nullable()->change();
        });

        Schema::table('expenses', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->change();
        });

        Schema::table('investments', function (Blueprint $table) {
            $table->decimal('amount', 15, 2)->change();
            $table->decimal('income_generated', 15, 2)->default(0)->change();
            $table->decimal('returned_amount', 15, 2)->nullable()->change();
        });
    }
};