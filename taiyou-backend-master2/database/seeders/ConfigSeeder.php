<?php

namespace Database\Seeders;

use App\Model\Company;
use App\Model\Config;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directory = public_path() . '/uploads/config';
        if (is_dir($directory) != true) {
            \File::makeDirectory($directory, $mode = 0755, true);
        }
        \File::copy(public_path('images/logo.png'), public_path('uploads/config/cms_logo.png'));
        $data = [
            [
                'label' => 'cms logo',
                'type' => 'file',
                'value' => 'cms_logo.png',
            ],
            [
                'label' => 'cms title',
                'type' => 'text',
                'value' => 'TAIYOU',

            ],
            [
                'label' => 'cms theme color',
                'type' => 'text',
                'value' => '#292961',

            ]
        ];
        $companies = Company::all()->pluck('id')->toArray();
        foreach ($companies as $company) {
            if ($company != 1){
                foreach ($data as $value){
                    $value['company_id'] = $company;
                    Config::create($value);
                }
            }
        }
    }
}
