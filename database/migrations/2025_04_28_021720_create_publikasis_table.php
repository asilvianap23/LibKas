<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublikasisTable extends Migration
{
    public function up()
    {
        Schema::create('publikasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anggota_id');
            $table->string('judul');
            $table->year('tahun');
            $table->text('keterangan')->nullable();
            $table->longText('naskah')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('publikasis');
    }
}
