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
        Schema::create('log_berat', function (Blueprint $table) {
            $table->id('id_log');
            
            $table->unsignedBigInteger('id_kambing');
            $table->foreign('id_kambing')->references('id_kambing')->on('kambing')->onDelete('cascade');
            
            $table->decimal('berat_sekarang', 5, 2);
            $table->date('tanggal_timbang');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_berat');
    }
};
