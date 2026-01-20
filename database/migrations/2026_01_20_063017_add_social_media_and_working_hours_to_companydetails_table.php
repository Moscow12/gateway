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
        Schema::table('companydetails', function (Blueprint $table) {
            // Social Media Links (all nullable)
            $table->string('facebook')->nullable()->after('logo');
            $table->string('twitter')->nullable()->after('facebook');
            $table->string('instagram')->nullable()->after('twitter');
            $table->string('linkedin')->nullable()->after('instagram');
            $table->string('youtube')->nullable()->after('linkedin');
            $table->string('tiktok')->nullable()->after('youtube');
            $table->string('github')->nullable()->after('tiktok');

            // Working Hours (nullable)
            $table->string('working_hours_weekdays')->nullable()->after('github');
            $table->string('working_hours_saturday')->nullable()->after('working_hours_weekdays');
            $table->string('working_hours_sunday')->nullable()->after('working_hours_saturday');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companydetails', function (Blueprint $table) {
            $table->dropColumn([
                'facebook',
                'twitter',
                'instagram',
                'linkedin',
                'youtube',
                'tiktok',
                'github',
                'working_hours_weekdays',
                'working_hours_saturday',
                'working_hours_sunday',
            ]);
        });
    }
};
