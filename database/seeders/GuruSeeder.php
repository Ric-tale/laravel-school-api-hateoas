<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    $gurus = [
        [
            'user_id' => 2,
            'nip' => '198501012010011001',
            'nama' => 'Budi Santoso, S.Pd',
            'tempat_lahir' => 'Jakarta',
            'tgl_lahir' => '1985-01-01',
            'gender' => 'laki-laki',
            'phone_number' => '081234567890',
            'email' => 'budi.santoso@sekolah.com',
            'alamat' => 'Jl. Pendidikan No. 10, Jakarta',
            'pendidikan' => 'S1 Pendidikan Matematika'
        ],
        [
            'user_id' => 3,
            'nip' => '198702152011012001',
            'nama' => 'Siti Nurhaliza, S.Pd',
            'tempat_lahir' => 'Bandung',
            'tgl_lahir' => '1987-02-15',
            'gender' => 'perempuan',
            'phone_number' => '081234567891',
            'email' => 'siti.nurhaliza@sekolah.com',
            'alamat' => 'Jl. Guru No. 5, Bandung',
            'pendidikan' => 'S1 Pendidikan Fisika'
        ],
        [
            'user_id' => 4,
            'nip' => '199003202012011002',
            'nama' => 'Ahmad Dahlan, S.Pd',
            'tempat_lahir' => 'Surabaya',
            'tgl_lahir' => '1990-03-20',
            'gender' => 'laki-laki',
            'phone_number' => '081234567892',
            'email' => 'ahmad.dahlan@sekolah.com',
            'alamat' => 'Jl. Pahlawan No. 15, Surabaya',
            'pendidikan' => 'S1 Pendidikan Biologi'
        ],
        [
            'user_id' => 5,
            'nip' => '198903102013012001',
            'nama' => 'Dewi Kartika, S.Pd',
            'tempat_lahir' => 'Yogyakarta',
            'tgl_lahir' => '1989-03-10',
            'gender' => 'perempuan',
            'phone_number' => '081234567893',
            'email' => 'dewi.kartika@sekolah.com',
            'alamat' => 'Jl. Malioboro No. 25, Yogyakarta',
            'pendidikan' => 'S1 Pendidikan Kimia'
        ],
        [
            'user_id' => 6,
            'nip' => '199105252014011001',
            'nama' => 'Eko Prasetyo, S.Pd',
            'tempat_lahir' => 'Semarang',
            'tgl_lahir' => '1991-05-25',
            'gender' => 'laki-laki',
            'phone_number' => '081234567894',
            'email' => 'eko.prasetyo@sekolah.com',
            'alamat' => 'Jl. Pemuda No. 30, Semarang',
            'pendidikan' => 'S1 Pendidikan Bahasa Inggris'
        ],
        [
            'user_id' => 7,
            'nip' => '198806152015012001',
            'nama' => 'Fitri Handayani, S.Pd',
            'tempat_lahir' => 'Malang',
            'tgl_lahir' => '1988-06-15',
            'gender' => 'perempuan',
            'phone_number' => '081234567895',
            'email' => 'fitri.handayani@sekolah.com',
            'alamat' => 'Jl. Ijen No. 12, Malang',
            'pendidikan' => 'S1 Pendidikan Bahasa Indonesia'
        ],
        [
            'user_id' => 8,
            'nip' => '199207302016011001',
            'nama' => 'Gunawan Wijaya, S.Pd',
            'tempat_lahir' => 'Solo',
            'tgl_lahir' => '1992-07-30',
            'gender' => 'laki-laki',
            'phone_number' => '081234567896',
            'email' => 'gunawan.wijaya@sekolah.com',
            'alamat' => 'Jl. Slamet Riyadi No. 45, Solo',
            'pendidikan' => 'S1 Pendidikan Sejarah'
        ],
        [
            'user_id' => 9,
            'nip' => '199012122017011002',
            'nama' => 'Hendra Kusuma, S.Pd',
            'tempat_lahir' => 'Medan',
            'tgl_lahir' => '1990-12-12',
            'gender' => 'laki-laki',
            'phone_number' => '081234567897',
            'email' => 'hendra.kusuma@sekolah.com',
            'alamat' => 'Jl. Gatot Subroto No. 88, Medan',
            'pendidikan' => 'S1 Pendidikan Geografi'
        ],
        [
            'user_id' => 10,
            'nip' => '198709052018012001',
            'nama' => 'Indah Permata, S.Pd',
            'tempat_lahir' => 'Palembang',
            'tgl_lahir' => '1987-09-05',
            'gender' => 'perempuan',
            'phone_number' => '081234567898',
            'email' => 'indah.permata@sekolah.com',
            'alamat' => 'Jl. Sudirman No. 67, Palembang',
            'pendidikan' => 'S1 Pendidikan Ekonomi'
        ],
        [
            'user_id' => 11,
            'nip' => '199304182019011001',
            'nama' => 'Joko Susilo, S.Pd',
            'tempat_lahir' => 'Makassar',
            'tgl_lahir' => '1993-04-18',
            'gender' => 'laki-laki',
            'phone_number' => '081234567899',
            'email' => 'joko.susilo@sekolah.com',
            'alamat' => 'Jl. Pettarani No. 99, Makassar',
            'pendidikan' => 'S1 Pendidikan Seni Budaya'
        ],
    ];

    foreach ($gurus as $guru) {
        Guru::create($guru);
    }
}
}
