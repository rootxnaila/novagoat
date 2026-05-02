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
        Schema::create('kambing', function (Blueprint $table) {
            $table->id('id_kambing'); 
            $table->string('nama');
            $table->string('jenis');
            $table->float('berat_awal');
            
            $table->string('status_kondisi'); 
            
            $table->string('gambar')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kambing');
    }
};
