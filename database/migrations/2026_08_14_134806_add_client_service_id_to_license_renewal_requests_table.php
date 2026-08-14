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
        Schema::table('license_renewal_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('client_service_id')->nullable()->after('invoice_id');
            $table->foreign('client_service_id')->references('id')->on('client_services')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('license_renewal_requests', function (Blueprint $table) {
            $table->dropForeign(['client_service_id']);
            $table->dropColumn('client_service_id');
        });
    }
};
