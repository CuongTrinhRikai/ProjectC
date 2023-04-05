<?php
namespace Database\Seeders;

use App\Model\FrontendUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FrontendUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FrontendUser::truncate();
        FrontendUser::create([
            'name' => 'pramesh',
            'username' => 'pramesh',
            'email' => 'FrontendUser+2@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
