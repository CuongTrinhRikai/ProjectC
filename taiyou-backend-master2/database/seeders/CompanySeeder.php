<?php
namespace Database\Seeders;

use App\Model\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(
            [
                'id' => 1,
                'name' => 'Osaka',
                'email' => 'kintai-mail@birumane.com',
            ]);
        Company::create(
            [
                'id' => 2,
                'name' => 'Tokyo',
                'email' => 'kintaitokyo-mail@birumane.com',
            ]);
        Company::create(
            [
                'id' => 3,
                'name' => 'Link',
                'email' => 'kintai-mail@birumane.com',
            ]);
    }
}
