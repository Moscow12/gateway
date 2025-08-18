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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name');  
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->integer('Region_ID')->foreign('Region_ID')->references('id')->on('regions');
            $table->integer('District_ID')->foreign('District_ID')->references('id')->on('districts');
            $table->integer('ward_id')->foreign('ward_id')->references('id')->on('wards');
            $table->string('street');
            $table->string('zip_code');
            $table->string('country');
            $table->string('notes');
            $table->string('National_Id');
            $table->string('status');
            $table->string('created_by')->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
