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
        Schema::create('customermeters', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->foreign('customer_id')->references('id')->on('customers');
            $table->string('meter_name');
            $table->string('meter_type')->nullable();
            $table->string('meter_value')->nullable();
            $table->string('meter_unit')->nullable();
            $table->string('meter_number');
            $table->date('dateconnected');
            $table->text('address');
            $table->interger('Region_ID')->foreign('Region_ID')->references('id')->on('regions');
            $table->interger('District_ID')->foreign('District_ID')->references('id')->on('districts');
            $table->interger('ward_id')->foreign('ward_id')->references('id')->on('wards');
            $table->string('street');
            $table->string('emegence_contacts');
            $table->string('longitudinal');
            $table->string('latitude');
            $table->string('created_by')->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customermeters');
    }
};
