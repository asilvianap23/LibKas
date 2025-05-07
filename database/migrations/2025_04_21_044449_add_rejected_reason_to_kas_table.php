<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->text('rejected_reason')->nullable()->after('rejected_at');
        });
    }
    
    public function down()
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('rejected_reason');
        });
    }    
};
