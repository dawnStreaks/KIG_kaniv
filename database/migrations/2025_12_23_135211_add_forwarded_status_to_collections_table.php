<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->enum('collection_status', ['payable', 'received', 'forwarded'])->default('payable')->change();
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->enum('collection_status', ['payable', 'received'])->default('payable')->change();
        });
    }
};