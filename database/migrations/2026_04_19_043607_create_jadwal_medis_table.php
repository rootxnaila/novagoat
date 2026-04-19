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
        Schema::create('jadwal_medis', function (Blueprint $table) {
            $table->id('id_jadwal');
            
            $table->unsignedBigInteger('id_kambing'); 
            $table->foreign('id_kambing')->references('id_kambing')->on('kambing')->onDelete('cascade');
            
            $table->string('jenis_tindakan', 100);
            $table->date('tanggal_rencana');
            $table->enum('status', ['Belum', 'Selesai', 'Terlewat'])->default('Belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_medis');
    }
};
