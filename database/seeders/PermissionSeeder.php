<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view-role',
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'view-user',
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
         ];
          // Looping and Inserting Array's Permissions into Permission Table
          foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}
