<?php

namespace Database\Seeders;

use App\Model\Role;
use DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $superUser = Role::where('id', 1)->first();
        if (!isset($superUser)) {
            Role::create([
                'id' => 1,
                'name' => 'superuser'
            ]);
        }
        $DefaultUser = Role::where('id', 2)->first();
        if (!isset($DefaultUser)) {
            Role::create([
                'id' => 2,
                'name' => 'defaultuser',
                'permissions' => json_decode('[
                    {
                        "url": "/users",
                        "method": "get"
                    },
                    {
                        "url": "/building",
                        "method": "get"
                    },
                    {
                        "url": "/contractors",
                        "method": "get"
                    },
                    {
                        "url": "/mansions",
                        "method": "get"
                    },
                    {
                        "url": "/guides",
                        "method": "get"
                    },
                    {
                    "url": "/manuals",
                    "method": "get"
                    },
                    {
                        "url": "/manuals/create",
                        "method": "get"
                    },
                    {
                        "url": "/manuals",
                        "method": "post"
                    },
                    {
                        "url": "/manuals/*/edit",
                        "method": "get"
                    },
                    {
                        "url": "/update-manual-status/*",
                        "method": "get"
                    },
                    {
                        "url": "/manuals/*",
                        "method": "put"
                    },
                    {
                        "url": "/manuals/*",
                        "method": "delete"
                    },
                    {
                        "url": "/notifications",
                        "method": "get"
                    },
                    {
                        "url": "/info-display",
                        "method": "get"
                    },
                    {
                        "url": "/info-display/download",
                        "method": "get"
                    }, {
                        "url": "/info-display/*/edit",
                        "method": "get"
                    },
                     {
                        "url": "/info-display/*",
                        "method": "put"
                    },
                    {
                        "url": "/info-display/*",
                        "method": "delete"
                    }

                ]')
            ]);
        }
        $BrowseUser = Role::where('id', 3)->first();
        if (!isset($BrowseUser)) {
            Role::create([
                'id' => 3,
                'name' => 'browseuser',
                'permissions' => json_decode('[
                {
                    "url": "/users",
                    "method": "get"
                },
                {
                    "url": "/building",
                    "method": "get"
                },
                {
                    "url": "/contractors",
                    "method": "get"
                },
                {
                    "url": "/mansions",
                    "method": "get"
                },
                {
                    "url": "/guides",
                    "method": "get"
                },
                {
                    "url": "/manuals",
                    "method": "get"
                },
                {
                    "url": "/notifications",
                    "method": "get"
                },
                {
                    "url": "/info-display",
                    "method": "get"
                }


                ]')
            ]);
        }
    }
}
