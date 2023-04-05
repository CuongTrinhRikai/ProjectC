<?php

namespace Database\Seeders;


use App\Model\System\Manual;
use Illuminate\Database\Seeder;

class AddCompanyIdToManual extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manual = Manual::query();
        $manual->update(['company_id' => 1]);
    }
}
