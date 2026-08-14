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
        DB::statement("ALTER TABLE license_renewal_requests MODIFY COLUMN status ENUM('pending', 'acknowledged', 'completed', 'rejected', 'approved') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE license_renewal_requests MODIFY COLUMN status ENUM('pending', 'acknowledged', 'completed', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
