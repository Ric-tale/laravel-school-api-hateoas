<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    // Admin user
    User::create([
        'type' => 'admin',
        'username' => 'admin',
        'password' => Hash::make('admin123'),
    ]);

    // Guru users - 10 guru
    $guruUsers = [
        ['username' => 'budi.santoso', 'password' => Hash::make('guru123')],
        ['username' => 'siti.nurhaliza', 'password' => Hash::make('guru123')],
        ['username' => 'ahmad.dahlan', 'password' => Hash::make('guru123')],
        ['username' => 'dewi.kartika', 'password' => Hash::make('guru123')],
        ['username' => 'eko.prasetyo', 'password' => Hash::make('guru123')],
        ['username' => 'fitri.handayani', 'password' => Hash::make('guru123')],
        ['username' => 'gunawan.wijaya', 'password' => Hash::make('guru123')],
        ['username' => 'hendra.kusuma', 'password' => Hash::make('guru123')],
        ['username' => 'indah.permata', 'password' => Hash::make('guru123')],
        ['username' => 'joko.susilo', 'password' => Hash::make('guru123')],
    ];

    foreach ($guruUsers as $user) {
        User::create([
            'type' => 'guru',
            'username' => $user['username'],
            'password' => $user['password'],
        ]);
    }
}
}
