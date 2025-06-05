<?php

use App\Http\Controllers\Auditor\DeskEvaluationController as AuditorDeskEvaluationController;
use App\Http\Controllers\Auditor\RekapDaftarTemuanController as AuditorRekapDaftarTemuanController;
use App\Http\Controllers\Auditor\VisitasiController as AuditorVisitasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DaftarNilaiMutuController;
use App\Http\Controllers\DaftarStandarController;
use App\Http\Controllers\DaftarStandarMutuController;
use App\Http\Controllers\DaftarSubStandarController;
use App\Http\Controllers\DaftarTemuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EvaluasiDiriController;
use App\Http\Controllers\FakultasProdiController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\KategoriDokumenController;
use App\Http\Controllers\LembagaAkreditasiController;
use App\Http\Controllers\ManajemenAuditorController;
use App\Http\Controllers\ManajemenDokumenController;
use App\Http\Controllers\PengaturanPeriodeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\Prodi\BuktiPendukungController as ProdiBuktiPendukungController;
use App\Http\Controllers\Prodi\DaftarTemuanController as ProdiDaftarTemuanController;
use App\Http\Controllers\Prodi\EvaluasiDiriController as ProdiEvaluasiDiriController;
use App\Http\Controllers\Prodi\EvalusiDiriController;
use App\Http\Controllers\Prodi\ProdiController;
use App\Http\Controllers\Prodi\StandarMutuController as ProdiStandarMutuController;
use App\Http\Controllers\Prodi\SubStandarController as ProdiSubStandarController;
use App\Http\Controllers\Prodi\RencanaTindakLanjutController as ProdiRencanaTindakLanjutController;
use App\Http\Controllers\RekapDeskEvaluasiController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StandarNasionalController;
use App\Http\Controllers\TahunPeriodeController;
use App\Http\Controllers\TargetNilaiMutuController;
use App\Http\Controllers\UserController;
use App\Http\Requests\StandarNasionalRequest;
use App\Models\DaftarNilaiMutu;
use App\Models\DaftarStandar;
use App\Models\DaftarStandarMutu;
use App\Models\DaftarTemuan;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user-edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user-update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user-delete', [UserController::class, 'destroy'])->name('user.delete');

    // Permissoes
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index');
    Route::post('/permission-store', [PermissionController::class, 'store'])->name('permission.store');
    Route::get('/permission-edit', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::put('/permission-update/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('/permission-delete', [PermissionController::class, 'destroy'])->name('permission.delete');

    // Permissoes
    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::post('/role-store', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role-edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role-update/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role-delete', [RoleController::class, 'destroy'])->name('role.delete');

    // Tahun Periode
    Route::get('/tahun-periodes', [TahunPeriodeController::class, 'index'])->name('tahun-periode.index');
    Route::post('/tahun-periode-store', [TahunPeriodeController::class, 'store'])->name('tahun-periode.store');
    Route::get('/tahun-periode-edit', [TahunPeriodeController::class, 'edit'])->name('tahun-periode.edit');
    Route::put('/tahun-periode-update/{id}', [TahunPeriodeController::class, 'update'])->name('tahun-periode.update');
    Route::delete('/tahun-periode-delete', [TahunPeriodeController::class, 'destroy'])->name('tahun-periode.delete');

    // Tahun Periode
    Route::get('/fakultas-prodis', [FakultasProdiController::class, 'index'])->name('fakultas-prodi.index');
    Route::post('/fakultas-prodi-store', [FakultasProdiController::class, 'store'])->name('fakultas-prodi.store');
    Route::get('/fakultas-prodi-edit', [FakultasProdiController::class, 'edit'])->name('fakultas-prodi.edit');
    Route::put('/fakultas-prodi-update/{id}', [FakultasProdiController::class, 'update'])->name('fakultas-prodi.update');
    Route::delete('/fakultas-prodi-delete', [FakultasProdiController::class, 'destroy'])->name('fakultas-prodi.delete');

    // Tahun Periode
    Route::get('/lembaga-akreditasis', [LembagaAkreditasiController::class, 'index'])->name('lembaga-akreditasi.index');
    Route::post('/lembaga-akreditasi-store', [LembagaAkreditasiController::class, 'store'])->name('lembaga-akreditasi.store');
    Route::get('/lembaga-akreditasi-edit', [LembagaAkreditasiController::class, 'edit'])->name('lembaga-akreditasi.edit');
    Route::put('/lembaga-akreditasi-update/{id}', [LembagaAkreditasiController::class, 'update'])->name('lembaga-akreditasi.update');
    Route::delete('/lembaga-akreditasi-delete', [LembagaAkreditasiController::class, 'destroy'])->name('lembaga-akreditasi.delete');

    // Tahun Periode
    Route::get('/standar-nasionals', [StandarNasionalController::class, 'index'])->name('standar-nasional.index');
    Route::post('/standar-nasional-store', [StandarNasionalController::class, 'store'])->name('standar-nasional.store');
    Route::get('/standar-nasional-edit', [StandarNasionalController::class, 'edit'])->name('standar-nasional.edit');
    Route::put('/standar-nasional-update/{id}', [StandarNasionalController::class, 'update'])->name('standar-nasional.update');
    Route::delete('/standar-nasional-delete', [StandarNasionalController::class, 'destroy'])->name('standar-nasional.delete');

    // Pengaturan Periode
    Route::get('/pengaturan-periodes', [PengaturanPeriodeController::class, 'index'])->name('pengaturan-periode.index');
    Route::post('/pengaturan-periode-store', [PengaturanPeriodeController::class, 'store'])->name('pengaturan-periode.store');
    Route::get('/pengaturan-periode-edit', [PengaturanPeriodeController::class, 'edit'])->name('pengaturan-periode.edit');
    Route::put('/pengaturan-periode-update/{id}', [PengaturanPeriodeController::class, 'update'])->name('pengaturan-periode.update');
    Route::delete('/pengaturan-periode-delete', [PengaturanPeriodeController::class, 'destroy'])->name('pengaturan-periode.delete');

    // Target Nilai Mutu
    Route::get('/target-nilai-mutus', [TargetNilaiMutuController::class, 'index'])->name('target-nilai-mutu.index');
    Route::post('/target-nilai-mutu-store', [TargetNilaiMutuController::class, 'store'])->name('target-nilai-mutu.store');
    Route::get('/target-nilai-mutu-edit', [TargetNilaiMutuController::class, 'edit'])->name('target-nilai-mutu.edit');
    Route::put('/target-nilai-mutu-update/{id}', [TargetNilaiMutuController::class, 'update'])->name('target-nilai-mutu.update');
    Route::delete('/target-nilai-mutu-delete', [TargetNilaiMutuController::class, 'destroy'])->name('target-nilai-mutu.delete');

    // Evaluasi Diri
    Route::get('/evaluasi-diris', [EvaluasiDiriController::class, 'index'])->name('evaluasi-diri.index');
    Route::post('/evaluasi-diri-store', [EvaluasiDiriController::class, 'store'])->name('evaluasi-diri.store');
    Route::get('/evaluasi-diri-edit', [EvaluasiDiriController::class, 'edit'])->name('evaluasi-diri.edit');
    Route::put('/evaluasi-diri-update/{id}', [EvaluasiDiriController::class, 'update'])->name('evaluasi-diri.update');
    Route::delete('/evaluasi-diri-delete', [EvaluasiDiriController::class, 'destroy'])->name('evaluasi-diri.delete');

    // Daftar Nilai Mutu
    Route::get('/daftar-nilai-mutus', [DaftarNilaiMutuController::class, 'index'])->name('daftar-nilai-mutu.index');
    Route::post('/daftar-nilai-mutu-store', [DaftarNilaiMutuController::class, 'store'])->name('daftar-nilai-mutu.store');
    Route::get('/daftar-nilai-mutu-edit', [DaftarNilaiMutuController::class, 'edit'])->name('daftar-nilai-mutu.edit');
    Route::put('/daftar-nilai-mutu-update/{id}', [DaftarNilaiMutuController::class, 'update'])->name('daftar-nilai-mutu.update');
    Route::delete('/daftar-nilai-mutu-delete', [DaftarNilaiMutuController::class, 'destroy'])->name('daftar-nilai-mutu.delete');

    // Daftar Standar Mutu
    Route::get('/daftar-standar-mutus', [DaftarStandarMutuController::class, 'index'])->name('daftar-standar-mutu.index');
    Route::post('/daftar-standar-mutu-store', [DaftarStandarMutuController::class, 'store'])->name('daftar-standar-mutu.store');
    Route::get('/daftar-standar-mutu-edit', [DaftarStandarMutuController::class, 'edit'])->name('daftar-standar-mutu.edit');
    Route::put('/daftar-standar-mutu-update/{id}', [DaftarStandarMutuController::class, 'update'])->name('daftar-standar-mutu.update');
    Route::delete('/daftar-standar-mutu-delete', [DaftarStandarMutuController::class, 'destroy'])->name('daftar-standar-mutu.delete');

    // Daftar Standar Mutu
    Route::get('/manajemen-auditors', [ManajemenAuditorController::class, 'index'])->name('manajemen-auditor.index');
    Route::post('/manajemen-auditor-store', [ManajemenAuditorController::class, 'store'])->name('manajemen-auditor.store');
    Route::get('/manajemen-auditor-edit', [ManajemenAuditorController::class, 'edit'])->name('manajemen-auditor.edit');
    Route::put('/manajemen-auditor-update/{id}', [ManajemenAuditorController::class, 'update'])->name('manajemen-auditor.update');
    Route::delete('/manajemen-auditor-delete', [ManajemenAuditorController::class, 'destroy'])->name('manajemen-auditor.delete');

    // Rekap Desk Evaluasi
    Route::get('/rekap-desk-evaluasis', [RekapDeskEvaluasiController::class, 'index'])->name('rekap-desk-evaluasi.index');
    
    // Daftar Standar Mutu
    // Route::get('/daftar-standar-mutus', [DaftarStandarMutuController::class, 'index'])->name('daftar-standar-mutu.index');
    // Route::post('/daftar-standar-mutu-store', [DaftarStandarMutuController::class, 'store'])->name('daftar-standar-mutu.store');
    // Route::get('/daftar-standar-mutu-edit', [DaftarStandarMutuController::class, 'edit'])->name('daftar-standar-mutu.edit');
    // Route::put('/daftar-standar-mutu-update/{id}', [DaftarStandarMutuController::class, 'update'])->name('daftar-standar-mutu.update');
    // Route::delete('/daftar-standar-mutu-delete', [DaftarStandarMutuController::class, 'destroy'])->name('daftar-standar-mutu.delete');
    
    // Dftar Temuan
    Route::get('/daftar-temuans', [DaftarTemuanController::class, 'index'])->name('daftar-temuan.index');

     // Kategori Dokumen
     Route::get('/kategori-dokumens', [KategoriDokumenController::class, 'index'])->name('kategori-dokumen.index');
     Route::post('/kategori-dokumen-store', [KategoriDokumenController::class, 'store'])->name('kategori-dokumen.store');
     Route::get('/kategori-dokumen-edit', [KategoriDokumenController::class, 'edit'])->name('kategori-dokumen.edit');
     Route::put('/kategori-dokumen-update/{id}', [KategoriDokumenController::class, 'update'])->name('kategori-dokumen.update');
     Route::delete('/kategori-dokumen-delete', [KategoriDokumenController::class, 'destroy'])->name('kategori-dokumen.delete');

     // Manajemen Dokumen
     Route::get('/manajemen-dokumens', [ManajemenDokumenController::class, 'index'])->name('manajemen-dokumen.index');
     Route::post('/manajemen-dokumen-store', [ManajemenDokumenController::class, 'store'])->name('manajemen-dokumen.store');
     Route::get('/manajemen-dokumen-edit', [ManajemenDokumenController::class, 'edit'])->name('manajemen-dokumen.edit');
     Route::put('/manajemen-dokumen-update/{id}', [ManajemenDokumenController::class, 'update'])->name('manajemen-dokumen.update');
     Route::delete('/manajemen-dokumen-delete', [ManajemenDokumenController::class, 'destroy'])->name('manajemen-dokumen.delete');
    
     // Daftar Standar
     Route::post('/daftar-standar-store', [DaftarStandarController::class, 'store'])->name('daftar-standar.store');
     Route::get('/daftar-standar-edit', [DaftarStandarController::class, 'edit'])->name('daftar-standar.edit');
     Route::put('/daftar-standar-update/{id}', [DaftarStandarController::class, 'update'])->name('daftar-standar.update');
     Route::delete('/daftar-standar-delete', [DaftarStandarController::class, 'destroy'])->name('daftar-standar.delete');
     
     // Daftar sub Standar
     Route::post('/daftar-sub-standar-store', [DaftarSubStandarController::class, 'store'])->name('daftar-sub-standar.store');
     Route::get('/daftar-sub-standar-edit', [DaftarSubStandarController::class, 'edit'])->name('daftar-sub-standar.edit');
     Route::put('/daftar-sub-standar-update/{id}', [DaftarSubStandarController::class, 'update'])->name('daftar-sub-standar.update');
     Route::delete('/daftar-sub-standar-delete', [DaftarSubStandarController::class, 'destroy'])->name('daftar-sub-standar.delete');
   
     // Point sub Standar
     Route::post('/poin-store', [PoinController::class, 'store'])->name('poin.store');
     Route::get('/poin-edit', [PoinController::class, 'edit'])->name('poin.edit');
     Route::put('/poin-update/{id}', [PoinController::class, 'update'])->name('poin.update');
     Route::delete('/poin-delete', [PoinController::class, 'destroy'])->name('poin.delete');
   
     // Indikator
     Route::post('/indikator-store', [IndikatorController::class, 'store'])->name('indikator.store');
     Route::get('/indikator-edit', [IndikatorController::class, 'edit'])->name('indikator.edit');
     Route::put('/indikator-update/{id}', [IndikatorController::class, 'update'])->name('indikator.update');

    // Prodi / Unit
    Route::group(['prefix' => 'prodi'], function () { 
        Route::get('evaluasi-diri', [ProdiEvaluasiDiriController::class, 'index'])->name('prodi.evalusi-diri.index');
        Route::get('standar-mutu/{fakultas}', [ProdiStandarMutuController::class, 'index'])->name('prodi.standar-mutu.index');
        Route::get('substandar/{fakultas}/poin/{id}', [ProdiSubStandarController::class, 'index'])->name('prodi.substandar.index');
        // bukti pendukung 
        Route::get('/bukti-pendukungs', [ProdiBuktiPendukungController::class, 'index'])->name('prodi.bukti-pendukung.index');
        Route::post('/bukti-pendukung-store', [ProdiBuktiPendukungController::class, 'store'])->name('prodi.bukti-pendukung.store');
        // daftar temuan
        Route::get('/daftar-temuan', [ProdiDaftarTemuanController::class, 'index'])->name('prodi.daftar-temuan.index');
        Route::post('/daftar-temuan-store', [ProdiDaftarTemuanController::class, 'store'])->name('prodi.daftar-temuan.store');
        // rekap desk evaluasi
        Route::get('/rekap-desk-evaluasis',  [ProdiEvaluasiDiriController::class, 'index'])->name('prodi.rekap-desk-evaluasi.index');
        // Rencana Tindak Lanjut
        Route::post('/rencana-tindak-lanjuts', [ProdirencanaTindakLanjutController::class, 'store'])->name('prodi.rencana-tindak-lanjut.store');

    } );


    Route::group(['prefix' => 'auditor'], function () {
        // desk evaluation
        Route::get('desk-evaluations', [AuditorDeskEvaluationController::class, 'index'])->name('auditor.desk-evaluations.index'); 
        // Rekap daftar Temuan
        Route::get('rekap-daftar-temuans', [AuditorRekapDaftarTemuanController::class, 'index'])->name('auditor.rekap-daftar-temuan.index');
        // Visitasi
        Route::get('visitasis', [AuditorVisitasiController::class, 'index'])->name('auditor.visitasi.index');
    });
    // logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});
