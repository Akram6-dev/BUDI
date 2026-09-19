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
            'status' => 'instansi',
            'instansi' => 'Dinas Komunikasi & Informatika Kab. Subang',
            'asal_sekolah' => null,
            'ulasan' => 'senang',
            'foto' => 'foto/sample1.png',
            'tanda_tangan' => 'tanda_tangan/sample1.png'
        ]);

        Tamu::create([
            'nama' => 'Siti Nurhaliza',
            'status' => 'instansi',
            'instansi' => 'PT Telkom Indonesia (Witel Subang)',
            'asal_sekolah' => null,
            'ulasan' => 'senang',
            'foto' => 'foto/sample2.png',
            'tanda_tangan' => ''
        ]);

        Tamu::create([
            'nama' => 'Andi Wijaya',
            'status' => 'sekolah',
            'instansi' => null,
            'asal_sekolah' => 'SMKN 1 Subang',
            'ulasan' => 'senang',
            'foto' => 'foto/sample3.png',
            'tanda_tangan' => 'tanda_tangan/sample2.png'
        ]);

        Tamu::create([
            'nama' => 'Dina Hartati',
            'status' => 'sekolah',
            'instansi' => null,
            'asal_sekolah' => 'SMKN 2 Subang',
            'ulasan' => 'biasa',
            'foto' => 'foto/sample4.png',
            'tanda_tangan' => ''
        ]);
    }
}
