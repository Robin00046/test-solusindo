<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class NilaiExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Nilai::with('siswa')
            ->get()
            ->values() // penting agar index mulai dari 0
            ->map(function ($nilai, $index) {
                return [
                    'no'    => $index + 1, // nomor urut
                    'nama'  => $nilai->siswa->nama,
                    'kelas' => $nilai->siswa->kelas,
                    'mapel' => $nilai->mapel,
                    'nilai' => $nilai->nilai,
                ];
            });
    }

    public function headings(): array
    {
        return ['no', 'nama', 'kelas', 'mapel', 'nilai'];
    }
}
