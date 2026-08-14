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
        Schema::create('client_service_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_service_id');
            $table->decimal('price', 15, 2);
            $table->unsignedInteger('billing_interval_months')->default(1);
            $table->string('contract_attachment')->nullable();

            $table->foreign('client_service_id')->references('id')->on('client_services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_service_subscriptions');
    }
};
