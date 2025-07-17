<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create Permissions
        $permissions = [
            'dashboard',
            // Siswa permissions
            'view_own_profile',
            'edit_own_profile',
            'view_own_konseling',
            'create_konseling_request',
            
            // Guru BK permissions
            'view_all_siswa',
            'manage_konseling',
            'create_konseling_session',
            'view_konseling_reports',
            'manage_siswa_data',
            
            // Admin permissions
            'manage_users',
            'manage_roles',
            'view_all_data',
            'system_settings',
            'manage_guru_bk',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Roles
        $siswaRole = Role::create(['name' => 'Siswa']);
        $guruBKRole = Role::create(['name' => 'Guru Bk']);
        $adminRole = Role::create(['name' => 'Admin']);

        // Assign Permissions to Roles
        $siswaRole->givePermissionTo([
            'dashboard',
            'view_own_profile',
            'edit_own_profile',
            'view_own_konseling',
            'create_konseling_request'
        ]);

        $guruBKRole->givePermissionTo([
            'dashboard',
            'view_all_siswa',
            'manage_konseling',
            'create_konseling_session',
            'view_konseling_reports',
            'manage_siswa_data'
        ]);

        $adminRole->givePermissionTo(Permission::all());

        // Create Default Users
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'nip' => 'ADM001',
            'is_active' => true
        ]);
        $admin->assignRole('Admin');

        $guruBK = User::create([
            'name' => 'Guru BK',
            'email' => 'gurubk@sekolah.com',
            'username' => 'gurubk',
            'password' => Hash::make('password123'),
            'nip' => 'GBK001',
            'jabatan' => 'staff',
            'alamat' => 'ciparay 2',
            'nomor_handphone' => '0820202020',
            'is_active' => true
        ]);
        $guruBK->assignRole('Guru Bk');

        $siswa = User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@sekolah.com',
            'username' => 'siswa001',
            'password' => Hash::make('password123'),
            'nis' => 'SIS001',
            'kelas' => '12 IPA 1',
            'jurusan' => 'perbankan',
            'alamat' => 'ciparay',
            'nomor_handphone' => '0821212121',
            'is_active' => true
        ]);
        $siswa->assignRole('Siswa');
    }
}
