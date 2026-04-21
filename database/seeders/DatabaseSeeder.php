<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // Insert sample kambing
        \App\Models\Kambing::firstOrCreate(
            ['id_kambing' => 1],
            [
                'nama' => 'Kambing Super Pak Tarno',
                'jenis' => 'Boerka',
                'berat_awal' => 25.0,
                'status_kondisi' => 'Sehat',
                'gambar' => 'https://trubus.id/wp-content/uploads/2022/09/Enam-Keunggulan-Kambing-Boerka-696x516.jpg'
            ]
        );

        // Insert sample log_berat
        $logBeratData = [
            ['id_kambing' => 1, 'berat_sekarang' => 25.50, 'tanggal_timbang' => '2026-04-15'],
            ['id_kambing' => 1, 'berat_sekarang' => 25.80, 'tanggal_timbang' => '2026-04-16'],
            ['id_kambing' => 1, 'berat_sekarang' => 26.20, 'tanggal_timbang' => '2026-04-17'],
            ['id_kambing' => 1, 'berat_sekarang' => 26.10, 'tanggal_timbang' => '2026-04-18'],
            ['id_kambing' => 1, 'berat_sekarang' => 26.50, 'tanggal_timbang' => '2026-04-19'],
        ];

        foreach ($logBeratData as $logBerat) {
            \App\Models\LogBerat::firstOrCreate(
                ['id_kambing' => $logBerat['id_kambing'], 'tanggal_timbang' => $logBerat['tanggal_timbang']],
                ['berat_sekarang' => $logBerat['berat_sekarang']]
            );
        }
    }
}
