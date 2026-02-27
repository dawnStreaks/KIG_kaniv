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
        Schema::create('opening_balance', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 3)->default(0);
            $table->integer('year');
            $table->unsignedBigInteger('mekhala_id')->nullable();
            $table->timestamps();
            
            $table->unique(['year', 'mekhala_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opening_balance');
    }
};
