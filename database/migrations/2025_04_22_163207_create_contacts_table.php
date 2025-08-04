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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->text('address');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tweeter')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('youtube')->nullable();
            $table->unsignedBigInteger('added_by')->index(); // Ensure the column exists
            $table->foreign('added_by')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('updated_by')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
