<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{

public function run()
{
    $mapelList = [
        ['kode_mapel' => 'MAT01', 'nama_mapel' => 'Matematika'],
        ['kode_mapel' => 'FIS01', 'nama_mapel' => 'Fisika'],
        ['kode_mapel' => 'BIO01', 'nama_mapel' => 'Biologi'],
        ['kode_mapel' => 'KIM01', 'nama_mapel' => 'Kimia'],
        ['kode_mapel' => 'ING01', 'nama_mapel' => 'Bahasa Inggris'],
        ['kode_mapel' => 'IND01', 'nama_mapel' => 'Bahasa Indonesia'],
        ['kode_mapel' => 'SEJ01', 'nama_mapel' => 'Sejarah'],
        ['kode_mapel' => 'GEO01', 'nama_mapel' => 'Geografi'],
        ['kode_mapel' => 'EKO01', 'nama_mapel' => 'Ekonomi'],
        ['kode_mapel' => 'SEN01', 'nama_mapel' => 'Seni Budaya'],
    ];

    foreach ($mapelList as $mapel) {
        Mapel::create($mapel);
    }
}
}
