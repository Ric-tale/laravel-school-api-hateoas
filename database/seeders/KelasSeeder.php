<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{

public function run()
{
    $kelasList = [
        ['kode_kelas' => 'X-IPA-1', 'nama_kelas' => 'Kelas 10 IPA 1'],
        ['kode_kelas' => 'X-IPA-2', 'nama_kelas' => 'Kelas 10 IPA 2'],
        ['kode_kelas' => 'X-IPS-1', 'nama_kelas' => 'Kelas 10 IPS 1'],
        ['kode_kelas' => 'XI-IPA-1', 'nama_kelas' => 'Kelas 11 IPA 1'],
        ['kode_kelas' => 'XI-IPA-2', 'nama_kelas' => 'Kelas 11 IPA 2'],
        ['kode_kelas' => 'XI-IPS-1', 'nama_kelas' => 'Kelas 11 IPS 1'],
        ['kode_kelas' => 'XII-IPA-1', 'nama_kelas' => 'Kelas 12 IPA 1'],
        ['kode_kelas' => 'XII-IPA-2', 'nama_kelas' => 'Kelas 12 IPA 2'],
        ['kode_kelas' => 'XII-IPS-1', 'nama_kelas' => 'Kelas 12 IPS 1'],
        ['kode_kelas' => 'XII-IPS-2', 'nama_kelas' => 'Kelas 12 IPS 2'],
    ];

    foreach ($kelasList as $kelas) {
        Kelas::create($kelas);
    }
}
}
