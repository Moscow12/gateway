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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->text('why_us');
            $table->text('what_we_do');
            $table->text('what_we_offer');
            $table->text('our_mission');
            $table->text('our_goals');
            $table->text('our_values');
            $table->text('safari_package');
            $table->text('selling_package');
            $table->longText('bookingprocess');
            $table->text('photo');
             $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
