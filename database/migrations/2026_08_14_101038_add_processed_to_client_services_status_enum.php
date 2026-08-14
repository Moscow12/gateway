<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE client_services MODIFY COLUMN status ENUM('active', 'inactive', 'license_expired', 'pending', 'suspended', 'processed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE client_services MODIFY COLUMN status ENUM('active', 'inactive', 'license_expired', 'pending', 'suspended') NOT NULL DEFAULT 'pending'");
    }
};
