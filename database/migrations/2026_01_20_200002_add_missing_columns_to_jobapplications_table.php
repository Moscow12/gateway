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
        Schema::table('jobapplications', function (Blueprint $table) {
            if (!Schema::hasColumn('jobapplications', 'vacancyID')) {
                $table->foreignId('vacancyID')->nullable()->after('id')->constrained('advertvacancies')->nullOnDelete();
            }
            if (!Schema::hasColumn('jobapplications', 'status')) {
                $table->string('status')->default('pending')->after('Location'); // pending, reviewed, shortlisted, rejected, hired
            }
            if (!Schema::hasColumn('jobapplications', 'Remarks')) {
                $table->text('Remarks')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobapplications', function (Blueprint $table) {
            if (Schema::hasColumn('jobapplications', 'vacancyID')) {
                $table->dropForeign(['vacancyID']);
                $table->dropColumn('vacancyID');
            }
            if (Schema::hasColumn('jobapplications', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('jobapplications', 'Remarks')) {
                $table->dropColumn('Remarks');
            }
        });
    }
};
