<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {// Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // bagian roles
        $superAdminRole = Role::findOrCreate('super_admin', 'web');
        $adminKlasisRole = Role::findOrCreate('admin_klasis', 'web');
        $adminJemaatRole = Role::findOrCreate('admin_jemaat', 'web');
        $adminBendaharaJemaatRole = Role::findOrCreate('admin_bendahara_jemaat', 'web');

        // bagian permissions
        $manageJemaatsPermission = Permission::findOrCreate('manage jemaats');
        $createJemaatsPermission = Permission::findOrCreate('create jemaats');
        $editJemaatsPermission = Permission::findOrCreate('edit jemaats');
        $deleteJemaatsPermission = Permission::findOrCreate('delete jemaats');


        $viewAnggotaJemaatPermission = Permission::findOrCreate('view anggota jemaat');
        $createAnggotaJemaatPermission = Permission::findOrCreate('create anggota jemaat');
        $editAnggotaJemaatPermission = Permission::findOrCreate('edit anggota jemaat');
        $deleteAnggotaJemaatPermission = Permission::findOrCreate('delete anggota jemaat');

        $viewBaptisansPermission = Permission::findOrCreate('view baptisans');
        $createBaptisansPermission = Permission::findOrCreate('create baptisans');
        $editBaptisansPermission = Permission::findOrCreate('edit baptisans');
        $deleteBaptisansPermission = Permission::findOrCreate('delete baptisans');


        $viewSidisPermission = Permission::findOrCreate('view sidis');
        $createSidisPermission = Permission::findOrCreate('create sidis');
        $editSidisPermission = Permission::findOrCreate('edit sidis');
        $deleteSidisPermission = Permission::findOrCreate('delete sidis');

        $viewNikahsPermission = Permission::findOrCreate('view nikahs');
        $createNikahsPermission = Permission::findOrCreate('create nikahs');
        $editNikahsPermission = Permission::findOrCreate('edit nikahs');
        $deleteNikahsPermission = Permission::findOrCreate('delete nikahs');

        $manageKeuanganPermission = Permission::findOrCreate('manage keuangan');
        $viewKeuanganPermission = Permission::findOrCreate('view keuangan');
        $createKeuanganPermission = Permission::findOrCreate('create keuangan');
        $editKeuanganPermission = Permission::findOrCreate('edit keuangan');
        $deleteKeuanganPermission = Permission::findOrCreate('delete keuangan');

        $manageSuratsPermission = Permission::findOrCreate('manage surats');
        $createSuratsPermission = Permission::findOrCreate('create surats');
        $editSuratsPermission = Permission::findOrCreate('edit surats');
        $deleteSuratsPermission = Permission::findOrCreate('delete surats');

        $managePengurusesPermission = Permission::findOrCreate('manage penguruses');
        $createPengurusesPermission = Permission::findOrCreate('create penguruses');
        $editPengurusesPermission = Permission::findOrCreate('edit penguruses');
        $deletePengurusesPermission = Permission::findOrCreate('delete penguruses');

        $generateLaporanPermission = Permission::findOrCreate('generate laporan');

        // Memberikan izin ke roles
        $superAdminRole->givePermissionTo(Permission::all()); // Super admin memiliki semua izin

        $adminKlasisRole->givePermissionTo([
            $viewAnggotaJemaatPermission,
            $viewBaptisansPermission,
            $viewNikahsPermission,
            $viewSidisPermission,
            $manageKeuanganPermission


        ]);
        $adminJemaatRole->givePermissionTo([
            $viewAnggotaJemaatPermission,
            $createAnggotaJemaatPermission,
            $editAnggotaJemaatPermission,
            $deleteAnggotaJemaatPermission,
            $viewBaptisansPermission,
            $createBaptisansPermission,
            $editBaptisansPermission,
            $deleteBaptisansPermission,
            $viewNikahsPermission,
            $createNikahsPermission,
            $editNikahsPermission,
            $deleteNikahsPermission,
            $viewSidisPermission,
            $createSidisPermission,
            $editSidisPermission,
            $deleteSidisPermission,
        ]);

        // Anda bisa menyesuaikan izin untuk admin_bendahara_jemaat sesuai kebutuhan
        $adminBendaharaJemaatRole->givePermissionTo([
            $manageKeuanganPermission,
            $viewKeuanganPermission,
            $createKeuanganPermission,
            $editKeuanganPermission,
            $deleteKeuanganPermission,
            // ... izin lainnya yang relevan ...
        ]);
    }
}
