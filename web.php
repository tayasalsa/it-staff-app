<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\MapelGuruController;
use App\Http\Controllers\NilaiController;


Route::resource('kelas', KelasController::class);
Route::resource('guru', GuruController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('mata-pelajaran', MataPelajaranController::class);
Route::resource('mapel-guru', MapelGuruController::class);
Route::resource('nilai', NilaiController::class);
Route::get('/', function () {
    return view('welcome');
});
