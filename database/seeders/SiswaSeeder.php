<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Siswa;

class SiswaSeeder extends Seeder
{

public function run()
{
    $siswaList = [
        [
            'nis' => '2023001',
            'nama' => 'Andi Prakoso',
            'gender' => 'laki-laki',
            'tempat_lahir' => 'Jakarta',
            'tgl_lahir' => '2007-05-15',
            'email' => 'andi.prakoso@student.com',
            'nama_ortu' => 'Bapak Prakoso',
            'alamat' => 'Jl. Merdeka No. 20, Jakarta',
            'phone_number' => '081298765432',
            'kelas_id' => 1
        ],
        [
            'nis' => '2023002',
            'nama' => 'Dewi Lestari',
            'gender' => 'perempuan',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => '2007-08-20',
            'email' => 'dewi.lestari@student.com',
            'nama_ortu' => 'Ibu Lestari',
            'alamat' => 'Jl. Sudirman No. 15, Bandung',
            'phone_number' => '081298765433',
            'kelas_id' => 1
        ],
        [
            'nis' => '2023003',
            'nama' => 'Rizki Ramadhan',
            'gender' => 'laki-laki',
            'tempat_lahir' => 'Surabaya',
            'tgl_lahir' => '2007-11-10',
            'email' => 'rizki.ramadhan@student.com',
            'nama_ortu' => 'Bapak Ramadhan',
            'alamat' => 'Jl. Ahmad Yani No. 8, Surabaya',
            'phone_number' => '081298765434',
            'kelas_id' => 2
        ],
        [
            'nis' => '2023004',
            'nama' => 'Sari Wahyuni',
            'gender' => 'perempuan',
            'tempat_lahir' => 'Yogyakarta',
            'tgl_lahir' => '2007-03-25',
            'email' => 'sari.wahyuni@student.com',
            'nama_ortu' => 'Ibu Wahyuni',
            'alamat' => 'Jl. Malioboro No. 100, Yogyakarta',
            'phone_number' => '081298765435',
            'kelas_id' => 3
        ],
        [
            'nis' => '2023005',
            'nama' => 'Fajar Nugraha',
            'gender' => 'laki-laki',
            'tempat_lahir' => 'Semarang',
            'tgl_lahir' => '2007-06-18',
            'email' => 'fajar.nugraha@student.com',
            'nama_ortu' => 'Bapak Nugraha',
            'alamat' => 'Jl. Pemuda No. 45, Semarang',
            'phone_number' => '081298765436',
            'kelas_id' => 4
        ],
        [
            'nis' => '2023006',
            'nama' => 'Gita Permatasari',
            'gender' => 'perempuan',
            'tempat_lahir' => 'Malang',
            'tgl_lahir' => '2007-09-22',
            'email' => 'gita.permatasari@student.com',
            'nama_ortu' => 'Ibu Permatasari',
            'alamat' => 'Jl. Ijen No. 77, Malang',
            'phone_number' => '081298765437',
            'kelas_id' => 5
        ],
        [
            'nis' => '2023007',
            'nama' => 'Haris Setiawan',
            'gender' => 'laki-laki',
            'tempat_lahir' => 'Solo',
            'tgl_lahir' => '2007-12-05',
            'email' => 'haris.setiawan@student.com',
            'nama_ortu' => 'Bapak Setiawan',
            'alamat' => 'Jl. Slamet Riyadi No. 33, Solo',
            'phone_number' => '081298765438',
            'kelas_id' => 6
        ],
        [
            'nis' => '2023008',
            'nama' => 'Intan Maharani',
            'gender' => 'perempuan',
            'tempat_lahir' => 'Medan',
            'tgl_lahir' => '2007-02-14',
            'email' => 'intan.maharani@student.com',
            'nama_ortu' => 'Ibu Maharani',
            'alamat' => 'Jl. Gatot Subroto No. 56, Medan',
            'phone_number' => '081298765439',
            'kelas_id' => 7
        ],
        [
            'nis' => '2023009',
            'nama' => 'Jefri Saputra',
            'gender' => 'laki-laki',
            'tempat_lahir' => 'Palembang',
            'tgl_lahir' => '2007-07-30',
            'email' => 'jefri.saputra@student.com',
            'nama_ortu' => 'Bapak Saputra',
            'alamat' => 'Jl. Sudirman No. 88, Palembang',
            'phone_number' => '081298765440',
            'kelas_id' => 8
        ],
        [
            'nis' => '2023010',
            'nama' => 'Kartika Sari',
            'gender' => 'perempuan',
            'tempat_lahir' => 'Makassar',
            'tgl_lahir' => '2007-10-08',
            'email' => 'kartika.sari@student.com',
            'nama_ortu' => 'Ibu Sari',
            'alamat' => 'Jl. Pettarani No. 22, Makassar',
            'phone_number' => '081298765441',
            'kelas_id' => 9
        ],
    ];

    foreach ($siswaList as $siswa) {
        Siswa::create($siswa);
    }
}
}
