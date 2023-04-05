<?php
namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Config;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Admin Tokyo',
                'email' => 'tokyo_admin@birumane.com',
                'username' => 'adminTokyo',
                'password' => Hash::make('Superadmin123@'),
                'password_resetted' => 1,
                'role_id' => 1,
                'company_id' => 2
            ]);
        User::create(
            [
                'name' => 'Admin Link',
                'email' => ' link_admin@birumane.com',
                'username' => 'adminLink',
                'password' => Hash::make('Superadmin123@'),
                'password_resetted' => 1,
                'role_id' => 1,
                'company_id' => 3
            ]);
    }
}
