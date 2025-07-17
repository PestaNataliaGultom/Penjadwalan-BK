<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Lib\Roler;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $s_admin = User::create([
                "name" => "ego oktafanda",
                'email' => 'super_admin@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
            Roler::UserRole($s_admin, ["api", "super-admin"]);

            $admin = User::create([
                "name" => "admin",
                'email' => 'admin@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
            Roler::UserRole($admin, ["api", "admin"]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}