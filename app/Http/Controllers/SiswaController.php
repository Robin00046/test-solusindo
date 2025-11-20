<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Siswa;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // pake inertia
        $kelasFilter = $request->query('kelas');
        $siswaFilter = $request->query('siswa');
        return Inertia::render('Siswa/Index', [
            'siswas' => Siswa::when($kelasFilter, function ($query, $kelasFilter) {
                $query->where('kelas', 'like', '%' . $kelasFilter . '%');
            })->when($siswaFilter, function ($query, $siswaFilter) {
                $query->where('nama', 'like', '%' . $siswaFilter . '%');
            })
                ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Siswa/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
        ],[
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.max' => 'Kelas maksimal 10 karakter.',
        ]);

        Siswa::create($validated);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return Inertia::render('Siswa/Show', [
            'siswa' => $siswa,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        return Inertia::render('Siswa/Edit', [
            'siswa' => $siswa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
        ],[
            'nama.required' => 'Nama wajib diisi.',
            'nama.max' => 'Nama maksimal 100 karakter.',
            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.max' => 'Kelas maksimal 10 karakter.',
        ]);

        $siswa->update($validated);

        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        // delete siswa
        // cek apakah ada di nilai terlebih dahulu
        if ($siswa->nilais()->count() > 0) {
            // jika ada, jangan dihapus dan kembalikan dengan pesan error
            return redirect()->route('siswas.index')->with('error', 'Siswa tidak dapat dihapus karena memiliki data nilai.');
        }
        $siswa->delete();
        return redirect()->route('siswas.index')->with('success', 'Siswa berhasil dihapus.');
    }
}
