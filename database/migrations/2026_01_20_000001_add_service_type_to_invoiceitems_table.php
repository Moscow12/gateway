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
        Schema::table('invoiceitems', function (Blueprint $table) {
            // Make product_id nullable to allow service-based items
            $table->unsignedBigInteger('product_id')->nullable()->change();

            // Add service_type_id column
            $table->unsignedBigInteger('service_type_id')->nullable()->after('product_id');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoiceitems', function (Blueprint $table) {
            $table->dropForeign(['service_type_id']);
            $table->dropColumn('service_type_id');
        });
    }
};
