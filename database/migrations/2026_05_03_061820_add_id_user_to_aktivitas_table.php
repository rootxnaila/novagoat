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
        Schema::table('aktivitas', function (Blueprint $table) {
            Schema::table('log_berat', function (Blueprint $table) {
        //nullable  biar data dummy lama nggak error
        $table->unsignedBigInteger('id_user')->nullable()->after('id_kambing');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('set null');
    });

    Schema::table('jadwal_medis', function (Blueprint $table) {
        $table->unsignedBigInteger('id_user')->nullable()->after('id_kambing');
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('set null');
    });
        });
    }
    
    public function down(): void
    {
        Schema::table('log_berat', function (Blueprint $table) {
        $table->dropForeign(['id_user']);
        $table->dropColumn('id_user');
    });
    Schema::table('jadwal_medis', function (Blueprint $table) {
        $table->dropForeign(['id_user']);
        $table->dropColumn('id_user');
    });
    }
};
