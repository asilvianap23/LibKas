<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Menambahkan foreign key untuk user_id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Menambahkan foreign key untuk event_id
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            
            // Kolom lainnya
            $table->string('nama');
            $table->string('wa');
            $table->decimal('amount', 10, 2);
            $table->string('bukti')->nullable();
            $table->boolean('verif')->default(false);   // Menyatakan disetujui
            $table->boolean('reject')->default(false);  // Menyatakan ditolak
            $table->timestamps();
        });
    }

    public function down()
    {
        // Drop tabel payments jika rollback dilakukan
        Schema::dropIfExists('payments');
    }
}
