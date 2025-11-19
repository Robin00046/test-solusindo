<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    // redirect to login
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('siswas', SiswaController::class);
    Route::resource('nilais', NilaiController::class);

    // Import/Export
    Route::post('nilai/import', [NilaiController::class, 'import'])->name('nilai.import');
    Route::get('nilai/export', [NilaiController::class, 'export'])->name('nilai.export');
});
