<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_pakets_table.php
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->decimal('nominal', 15, 2); // nominal harga
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pakets');
    }

};
