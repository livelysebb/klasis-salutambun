<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Dapatkan role yang dibutuhkan
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $adminKlasisRole = Role::where('name', 'admin_klasis')->first();
        $adminJemaatRole = Role::where('name', 'admin_jemaat')->first();
        $adminBendaharaJemaatRole = Role::where('name', 'admin_bendahara_jemaat')->first();

        // Buat user dan langsung assign role
        User::factory()->create([
            'role' => 'super_admin'
        ])->assignRole($superAdminRole);

        User::factory()->create([
            'role' => 'admin_klasis'
        ])->assignRole($adminKlasisRole);

        User::factory()->create([
            'role' => 'admin_jemaat'
        ])->assignRole($adminJemaatRole);

        User::factory()->create([
            'role' => 'admin_bendahara_jemaat'
        ])->assignRole($adminBendaharaJemaatRole);
    }
}
