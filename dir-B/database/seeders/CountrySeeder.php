<?php
namespace Database\Seeders;

use App\Model\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = getCountries();
        Country::truncate();
        Country::insert($countries);
    }
}
