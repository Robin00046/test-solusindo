<?php

namespace App\Imports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\ToModel;

class NilaiImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Jika baris kosong, skip
        if (!isset($row[1]) || $row[1] === null) {
            return null;
        }

        // Jika row pertama adalah header Excel, skip
        if (strtolower($row[1]) === 'nama') {
            return null;
        }

        $data = [
            'no'    => $row[0] ?? null,
            'nama'  => $row[1] ?? null,
            'kelas' => $row[2] ?? null,
            'mapel' => $row[3] ?? null,
            'nilai' => isset($row[4]) ? (int) $row[4] : null,
        ];

        $insert = [
            'siswa_id' => Nilai::getOrCreateSiswaId($data['nama'], $data['kelas']),
            'mapel'    => $data['mapel'],
            'nilai'    => $data['nilai'],
        ];

        $nilai = Nilai::updateOrCreate(
            [
                'siswa_id' => $insert['siswa_id'], // kondisi
                'mapel'    => $insert['mapel']     // kondisi
            ],
            [
                'nilai'     => $insert['nilai'],   // data untuk update
            ]
        );

        return $nilai;
    }
}
