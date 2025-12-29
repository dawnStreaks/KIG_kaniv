<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, clean up any invalid enum values
        DB::statement("UPDATE collections SET collection_status = 'received' WHERE collection_status NOT IN ('payable', 'received', 'forwarded')");
        
        // Drop the column and recreate it with all enum values
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('collection_status');
        });
        
        Schema::table('collections', function (Blueprint $table) {
            $table->enum('collection_status', ['payable', 'received', 'forwarded', 'center_received'])->default('payable')->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('collection_status');
        });
        
        Schema::table('collections', function (Blueprint $table) {
            $table->enum('collection_status', ['payable', 'received', 'forwarded'])->default('payable')->after('amount');
        });
    }
};