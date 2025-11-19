<?php

namespace Database\Seeders;

use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            // 7A
            ['nama' => 'Andi', 'kelas' => '7A', 'mapel' => 'Matematika', 'nilai' => 80],
            ['nama' => 'Andi', 'kelas' => '7A', 'mapel' => 'Bahasa',     'nilai' => 70],

            ['nama' => 'Budi', 'kelas' => '7A', 'mapel' => 'Matematika', 'nilai' => 60],
            ['nama' => 'Budi', 'kelas' => '7A', 'mapel' => 'Bahasa',     'nilai' => 75],

            // 7B
            ['nama' => 'Citra', 'kelas' => '7B', 'mapel' => 'Matematika', 'nilai' => 90],
            ['nama' => 'Citra', 'kelas' => '7B', 'mapel' => 'Bahasa',     'nilai' => 85],
        ];

        foreach ($data as $row) {
            // buat atau ambil siswa
            $siswa = Siswa::firstOrCreate([
                'nama'  => $row['nama'],
                'kelas' => $row['kelas'],
            ]);

            // insert nilai
            Nilai::create([
                'siswa_id' => $siswa->id,
                'mapel'    => $row['mapel'],
                'nilai'    => $row['nilai'],
            ]);
        }
    }
}
