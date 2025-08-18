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
        Schema::create('penaltcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the penalty category
            $table->string('description')->nullable(); // Description of the penalty category
            $table->foreignId('group_id')->constrained('tbl_groups')->onDelete('cascade');
           $table->foreignId('added_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penaltcategories');
    }
};
