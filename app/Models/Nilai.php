<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    /** @use HasFactory<\Database\Factories\NilaiFactory> */
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'mapel',
        'nilai',
    ];

    public static function getOrCreateSiswaId($nama, $kelas)
    {
        $siswa = \App\Models\Siswa::firstOrCreate(
            ['nama' => $nama, 'kelas' => $kelas], // kondisi pencarian
            ['nama' => $nama, 'kelas' => $kelas]  // data pembuatan kalau tidak ada
        );

        return $siswa->id;
    }


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
