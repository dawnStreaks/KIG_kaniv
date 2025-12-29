<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE collections MODIFY COLUMN collection_status ENUM('payable', 'received', 'forwarded', 'center_received') NOT NULL DEFAULT 'payable'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE collections MODIFY COLUMN collection_status ENUM('payable', 'received', 'forwarded') NOT NULL DEFAULT 'payable'");
    }
};