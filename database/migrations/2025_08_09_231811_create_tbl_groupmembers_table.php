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
        Schema::create('tbl_groupmembers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('tbl_groups')->onDelete('cascade');
            $table->string('member_id')->unique(); // Unique identifier for the member is id-group_id
            $table->string('role');
            $table->string('status');
            $table->string('joined_date')->nullable(); // Date when the member joined the group
            $table->string('left_date')->nullable(); // Date when the member left the group
            $table->string('member_name');
            $table->string('member_phone');
            $table->string('member_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_groupmembers');
    }
};
