<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UpdateDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UpdateDatabaseCustomer::class);
        $this->call(CompanySeeder::class);
        $this->call(EmailTemplateSeeder::class);
        $this->call(ConfigSeeder::class);
        $this->call(UserSeeder::class);
    }
}
