<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $Ketua_LPM = Role::create(['name' => 'Ketua LPM']);
        $Ketua_Program_Studi = Role::create(['name' => 'Ketua Program Studi']);
        $Mahasiswa = Role::create(['name' => 'Mahasiswa']);
        $Alumni = Role::create(['name' => 'Alumni']);
        $Dosen = Role::create(['name' => 'Dosen']);
        $UPPS = Role::create(['name' => 'UPPS']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'view-user',
            'create-role',
            'edit-role',
            'delete-role',
            'view-permission',
            'create-permission',
            'edit-permission',
            'delete-permission',
            'view-lembaga-akreditasi',
            'create-lembaga-akreditasi',
            'edit-lembaga-akreditasi',
            'delete-lembaga-akreditasi',
            'view-tahun-periode',
            'create-tahun-periode',
            'edit-tahun-periode',
            'delete-tahun-periode',
            'view-fakultas-prodi',
            'create-fakultas-prodi',
            'edit-fakultas-prodi',
            'delete-fakultas-prodi',
            'view-standar-nasional',
            'create-standar-nasional',
            'edit-standar-nasional',
            'delete-standar-nasional',
            'view-pengaturan-periode',
            'create-pengaturan-periode',
            'edit-pengaturan-periode',
            'delete-pengaturan-periode',
            'view-target-nilai-mutu',
            'create-target-nilai-mutu',
            'edit-target-nilai-mutu',
            'delete-target-nilai-mutu',
            'view-evaluasi-diri',
            'view-daftar-nilai-mutu',
            'create-daftar-nilai-mutu',
            'edit-daftar-nilai-mutu',
            'delete-daftar-nilai-mutu',
            'view-manajemen-auditor',
            'create-manajemen-auditor',
            'edit-manajemen-auditor',
            'delete-manajemen-auditor',
            'view-kategori-dokumen',
            'create-kategori-dokumen',
            'edit-kategori-dokumen',
            'delete-kategori-dokumen',
            'view-manajemen-dokumen',
            'create-manajemen-dokumen',
            'edit-manajemen-dokumen',
            'delete-manajemen-dokumen',
            'view-rekap-desk-evaluasi',
            'view-daftar-temuan',
            'view-daftar-standar-mutu',
            'create-daftar-standar-mutu',
            'edit-daftar-standar-mutu',
            'delete-daftar-standar-mutu',
        ]);

        $Ketua_LPM->givePermissionTo([
            'view-user',
        ]);

        $Ketua_Program_Studi->givePermissionTo([
            'view-user',
        ]);

        $Mahasiswa->givePermissionTo([
            'view-user',
        ]);

        $Alumni->givePermissionTo([
            'view-user',
        ]);

        $Dosen->givePermissionTo([
            'view-user',
        ]);

        $UPPS->givePermissionTo([
            'view-user',
        ]);
    }
}
