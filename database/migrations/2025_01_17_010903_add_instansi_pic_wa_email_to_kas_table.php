<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->string('instansi')->nullable(); 
            $table->string('pic')->nullable()->after('instansi');
            $table->string('wa')->nullable()->after('pic');
            $table->string('email')->nullable()->after('wa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn(['instansi', 'pic', 'wa', 'email']);
        });
    }
};
