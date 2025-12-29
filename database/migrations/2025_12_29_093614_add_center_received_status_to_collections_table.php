<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, update any invalid enum values to valid ones
        DB::statement("UPDATE collections SET collection_status = 'received' WHERE collection_status NOT IN ('payable', 'received', 'forwarded')");
        
        // Then modify the enum to include center_received
        DB::statement("ALTER TABLE collections MODIFY COLUMN collection_status ENUM('payable', 'received', 'forwarded', 'center_received') NOT NULL DEFAULT 'payable'");
    }

    public function down(): void
    {
        // Update any center_received back to forwarded before removing the enum value
        DB::statement("UPDATE collections SET collection_status = 'forwarded' WHERE collection_status = 'center_received'");
        
        DB::statement("ALTER TABLE collections MODIFY COLUMN collection_status ENUM('payable', 'received', 'forwarded') NOT NULL DEFAULT 'payable'");
    }
};