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
        Schema::create('tbl_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('district_id');
            $table->string('ward');
            $table->string('village');
            $table->string('rep_phone');
            $table->string('rep_email');
            $table->string('rep_name'); // Name of the group representative
            $table->string('group_type')->nullable(); // e.g., 'Savings', 'Investment', 'Social', etc.
            $table->string('group_status')->default('active'); // e.g., 'active', 'inactive', 'closed'
            $table->text('description')->nullable(); // Additional information about the group
            $table->string('group_icon')->nullable(); // Icon or image representing the group
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_groups');
    }
};
