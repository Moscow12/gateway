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
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('tbl_groupmembers')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('tbl_groups')->onDelete('cascade');
            $table->foreignId('penalty_category_id')->constrained('penaltcategories')->onDelete('cascade');
            $table->string('status'); // e.g., 'active', 'inactive', 'closed', 'pending', 'paid'
            $table->string('description')->nullable(); // Additional information about the penalty
            $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
