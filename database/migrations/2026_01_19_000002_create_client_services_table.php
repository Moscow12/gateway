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
        Schema::create('client_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('service_type_id');
            $table->enum('status', ['active', 'inactive', 'license_expired', 'pending', 'suspended'])->default('pending');
            $table->date('license_start_date')->nullable();
            $table->date('license_end_date')->nullable();
            $table->text('notes')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_renewal_date')->nullable();
            $table->string('contract_reference')->nullable();
            $table->unsignedBigInteger('added_by');

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('service_type_id')->references('id')->on('service_types')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_services');
    }
};
