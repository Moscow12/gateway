<?php

use App\Models\Clients;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (!Schema::hasColumn('clients', 'secretkey')) {
                $table->string('secretkey', 64)->nullable()->unique()->after('clientcode');
            }
        });

        Clients::whereNull('secretkey')->cursor()->each(function (Clients $client) {
            $client->update(['secretkey' => Str::random(40)]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            if (Schema::hasColumn('clients', 'secretkey')) {
                $table->dropColumn('secretkey');
            }
        });
    }
};
