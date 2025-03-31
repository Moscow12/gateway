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
        Schema::create('jobapplications', function (Blueprint $table) {
            $table->id();
            $table->string('ApplicantName');
            $table->string('ApplicantEmail');
            $table->string('phone');
            $table->string('Gender');
            $table->string('MaritalStatus');
            $table->string('Nida');
            $table->string('dob');
            $table->string('Location');
            $table->string('fourFourCert')->nullable();
            $table->string('internshipCert')->nullable();
            $table->string('birthCert')->nullable();            
            $table->string('sixCertificate')->nullable();
            $table->string('mctCertificate')->nullable();
            $table->string('license')->nullable();
            $table->string('CariculumVitae')->nullable();
            $table->string('collageCert')->nullable(); 
            $table->integer('added_by')->nullable();
            $table->string('applicationLetter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobapplications');
    }
};
