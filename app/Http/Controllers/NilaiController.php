<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Exports\NilaiExport;
use App\Imports\NilaiImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreNilaiRequest;
use App\Http\Requests\UpdateNilaiRequest;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $siswaFilter = $request->query('siswa');
        $kelasFilter = $request->query('kelas');
        $mapelFilter = $request->query('mapel');
        // pake inertia 
        return Inertia::render('Nilai/Index', [
            'nilais' => Nilai::with('siswa')->when($siswaFilter, function ($query, $siswaFilter) {
                $query->whereHas('siswa', function ($q) use ($siswaFilter) {
                    $q->where('nama', 'like', '%' . $siswaFilter . '%');
                });
            })->when($kelasFilter, function ($query, $kelasFilter) {
                $query->whereHas('siswa', function ($q) use ($kelasFilter) {
                    $q->where('kelas', 'like', '%' . $kelasFilter . '%');
                });
            })->when($mapelFilter, function ($query, $mapelFilter) {
                $query->where('mapel', 'like', '%' . $mapelFilter . '%');
            })->get(),
            'siswas' => Siswa::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('SiswaController');
        return Inertia::render('Nilai/Create', [
            'siswas' => Siswa::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mapel' => 'required|string|max:50',
            'nilai' => 'required|integer|min:0|max:100',
        ],[
            'siswa_id.required' => 'Siswa wajib diisi.',
            'siswa_id.exists' => 'Siswa tidak ditemukan.',
            'mapel.required' => 'Mata pelajaran wajib diisi.',
            'mapel.max' => 'Mata pelajaran maksimal 50 karakter.',
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.integer' => 'Nilai harus berupa angka.',
            'nilai.min' => 'Nilai minimal 0.',
            'nilai.max' => 'Nilai maksimal 100.',
        ]);

        // cek dulu apakah nilai untuk siswa dan mapel tersebut sudah ada
        // jika sudah ada keluar error dengan pesan sudah ada nilai untuk siswa dan mapel tersebut
        $existingNilai = Nilai::where('siswa_id', $validated['siswa_id'])
            ->where('mapel', $validated['mapel'])
            ->first();

        if ($existingNilai) {
            return redirect()->route('nilais.index')->with('error', 'Sudah ada nilai untuk siswa dan mapel tersebut.');
        }

        Nilai::create($validated);

        return redirect()->route('nilais.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Nilai $nilai)
    {
        return Inertia::render('Nilai/Show', [
            'nilai' => $nilai->load('siswa'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nilai $nilai)
    {
        return Inertia::render('Nilai/Edit', [
            'nilai' => $nilai->load('siswa'),
            'siswas' => Siswa::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nilai $nilai)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'mapel' => 'required|string|max:50',
            'nilai' => 'required|integer|min:0|max:100',
        ],[
            'siswa_id.required' => 'Siswa wajib diisi.',
            'siswa_id.exists' => 'Siswa tidak ditemukan.',
            'mapel.required' => 'Mata pelajaran wajib diisi.',
            'mapel.max' => 'Mata pelajaran maksimal 50 karakter.',
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.integer' => 'Nilai harus berupa angka.',
            'nilai.min' => 'Nilai minimal 0.',
            'nilai.max' => 'Nilai maksimal 100.',
        ]);

        // Cek duplikat kecuali record yg sedang diedit
        $existingNilai = Nilai::where('siswa_id', $validated['siswa_id'])
            ->where('mapel', $validated['mapel'])
            ->where('id', '!=', $nilai->id)
            ->first();

        if ($existingNilai) {
            return redirect()->route('nilais.index')
                ->with('error', 'Sudah ada nilai untuk siswa dan mapel tersebut.');
        }

        $nilai->update($validated);

        return redirect()->route('nilais.index')
            ->with('success', 'Nilai berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nilai $nilai)
    {
        // delete nilai
        $nilai->delete();
        return redirect()->route('nilais.index')->with('success', 'Nilai berhasil dihapus.');
    }

    // import export functions
    public function import(Request $request)
    {
        // import logic here
        $file = $request->file('file');

        // Validate the file
        $request->validate([
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        // Process the file
        Excel::import(new NilaiImport, $file);

        return redirect()->route('nilais.index')->with('success', 'Data nilai berhasil diimpor.');
    }
    public function export()
    {
        // export logic here
        return Excel::download(new NilaiExport, 'nilais.xlsx');
    }
}
