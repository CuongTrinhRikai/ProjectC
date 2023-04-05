<?php

namespace Database\Seeders;

use App\Model\Config;
use App\Model\EmailTemplate;
use App\Model\System\BuildingAdmin;
use App\Model\System\CheckInCheckOut;
use App\Model\System\Contractor;
use App\User;
use Illuminate\Database\Seeder;

class UpdateDatabaseCustomer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = CheckInCheckOut::all();
        foreach ($data as $value) {
            $buildingAdmin = BuildingAdmin::find($value->building_admin_id);
            $businessCategory = Business($buildingAdmin->business_category);
            CheckInCheckOut::where('id', $value->id)->update(['business_category' => $businessCategory]);
        }
        $buildingAdmins = BuildingAdmin::all();
        foreach ($buildingAdmins as $buildingAdmin) {
            $category = '["' . $buildingAdmin->business_category . '"]';
            BuildingAdmin::where('id', $buildingAdmin->id)->update(['business_category' => $category]);
        }

        foreach (User::all() as $item) {
            User::where('id', $item->id)->update(['company_id' => 1]);
        }

        foreach (Contractor::all() as $item) {
            Contractor::where('id', $item->id)->update(['company_id' => 1]);
        }
        foreach (EmailTemplate::all() as $item) {
            EmailTemplate::where('id', $item->id)->update(['company_id' => 1]);
        }
        foreach (Config::all() as $item) {
            Config::where('id', $item->id)->update(['company_id' => 1]);
        }
    }
}
