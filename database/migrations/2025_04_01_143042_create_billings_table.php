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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->interger('Meter_ID')->foreign('Meter_ID')->references('id')->on('customermeters');
            $table->date('readingdate');
            $table->string('readingvalue');
            $table->string('lastreadingvalue');
            $table->string('unitsused');
            $table->string('attachmentphoto');
            $table->string('status');
            $table->string('TotalAmount');
            $table->interger('created_by')->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
