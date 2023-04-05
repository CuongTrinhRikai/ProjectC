<?php

namespace Database\Seeders;

use App\Model\System\Notification;
use Illuminate\Database\Seeder;

class AddCompanyIdToNotification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = Notification::query();
        $notifications->update(['company_id' => 1]);
    }
}
