<?php

namespace Database\Seeders;

use App\Models\Tamu;
use Illuminate\Database\Seeder;

class TamuSeeder extends Seeder
{
    public function run(): void
    {
        Tamu::create([
            'nama' => 'Budi Santoso',
            'status' => 'guru',
            'kelas' => null,
            'foto' => 'foto/sample1.png',
            'tanda_tangan' => 'tanda_tangan/sample1.png'
        ]);

        Tamu::create([
            'nama' => 'Siti Nurhaliza',
            'status' => 'guru',
            'kelas' => null,
            'foto' => 'foto/sample2.png',
            'tanda_tangan' => ''
        ]);

        Tamu::create([
            'nama' => 'Andi Wijaya',
            'status' => 'siswa',
            'kelas' => 'X PPLG 1',
            'foto' => 'foto/sample3.png',
            'tanda_tangan' => 'tanda_tangan/sample2.png'
        ]);

        Tamu::create([
            'nama' => 'Dina Hartati',
            'status' => 'siswa',
            'kelas' => 'X TJKT 2',
            'foto' => 'foto/sample4.png',
            'tanda_tangan' => ''
        ]);
    }
}
