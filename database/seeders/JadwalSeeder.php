<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;

class JadwalSeeder extends Seeder
{

public function run()
{
    $jadwalList = [
        // Senin
        ['kelas_id' => 1, 'mapel_id' => 1, 'guru_id' => 1, 'hari' => 'senin', 'jam_pelajaran' => '07:00 - 08:30'],
        ['kelas_id' => 1, 'mapel_id' => 2, 'guru_id' => 2, 'hari' => 'senin', 'jam_pelajaran' => '08:30 - 10:00'],
        ['kelas_id' => 2, 'mapel_id' => 1, 'guru_id' => 1, 'hari' => 'senin', 'jam_pelajaran' => '10:00 - 11:30'],
        
        // Selasa
        ['kelas_id' => 1, 'mapel_id' => 3, 'guru_id' => 3, 'hari' => 'selasa', 'jam_pelajaran' => '07:00 - 08:30'],
        ['kelas_id' => 2, 'mapel_id' => 2, 'guru_id' => 2, 'hari' => 'selasa', 'jam_pelajaran' => '08:30 - 10:00'],
        ['kelas_id' => 3, 'mapel_id' => 5, 'guru_id' => 5, 'hari' => 'selasa', 'jam_pelajaran' => '10:00 - 11:30'],
        
        // Rabu
        ['kelas_id' => 4, 'mapel_id' => 4, 'guru_id' => 4, 'hari' => 'rabu', 'jam_pelajaran' => '07:00 - 08:30'],
        ['kelas_id' => 5, 'mapel_id' => 1, 'guru_id' => 1, 'hari' => 'rabu', 'jam_pelajaran' => '08:30 - 10:00'],
        ['kelas_id' => 6, 'mapel_id' => 5, 'guru_id' => 5, 'hari' => 'rabu', 'jam_pelajaran' => '10:00 - 11:30'],
        
        // Kamis
        ['kelas_id' => 7, 'mapel_id' => 6, 'guru_id' => 6, 'hari' => 'kamis', 'jam_pelajaran' => '07:00 - 08:30'],
        ['kelas_id' => 8, 'mapel_id' => 2, 'guru_id' => 2, 'hari' => 'kamis', 'jam_pelajaran' => '08:30 - 10:00'],
        ['kelas_id' => 9, 'mapel_id' => 7, 'guru_id' => 7, 'hari' => 'kamis', 'jam_pelajaran' => '10:00 - 11:30'],
        
        // Jumat
        ['kelas_id' => 10, 'mapel_id' => 8, 'guru_id' => 8, 'hari' => 'jumat', 'jam_pelajaran' => '07:00 - 08:30'],
        ['kelas_id' => 1, 'mapel_id' => 4, 'guru_id' => 4, 'hari' => 'jumat', 'jam_pelajaran' => '08:30 - 10:00'],
        
        // Sabtu
        ['kelas_id' => 2, 'mapel_id' => 9, 'guru_id' => 9, 'hari' => 'sabtu', 'jam_pelajaran' => '07:00 - 08:30'],
        ['kelas_id' => 3, 'mapel_id' => 10, 'guru_id' => 10, 'hari' => 'sabtu', 'jam_pelajaran' => '08:30 - 10:00'],
    ];

    foreach ($jadwalList as $jadwal) {
        Jadwal::create($jadwal);
    }
}
}
