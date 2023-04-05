<?php
$getMethod = 'get';
$postMethod = 'post';
$putMethod = 'put';
$deleteMethod = 'delete';

$homeBaseUrl = '/home';
$userBaseUrl = '/users';
$roleBaseUrl = '/roles';
$loginLogsBaseUrl = '/login-logs';
$activityLogsBaseUrl = '/activity-logs';
//$languagesBaseUrl = '/languages';
//$translationBaseUrl = '/translations';
$emailTemplateBaseUrl = '/email-templates';
$configBaseUrl = '/configs';
$categoriesBaseUrl = '/categories';
$profileBaseUrl = '/profile';
$mailtestBaseUrl = '/mail-test';
$contractorBaseUrl = '/contractors';
$mansionBaseUrl = '/mansions';
$guideBaseUrl = '/guides';
$buildingAdminBaseUrl = '/building';
$manualBaseUrl = '/manuals';
$infoDisplayBaseUrl = '/info-display';
$notificationBaseUrl = '/notifications';


return [
    // routes entered in this array are accessible by any user no matter what role is given
    'permissionGrantedbyDefaultRoutes' => [
        [
            "url" => $homeBaseUrl,
            "method" => $getMethod
        ],
        [
            "url" => '/logout',
            "method" => $getMethod
        ],
        [
            "url" => '/languages/set-language/*',
            "method" => $getMethod
        ],
        [
            "url" => '/miscellaneous/scrap',
            "method" => $getMethod
        ],
        [
            "url" => $profileBaseUrl,
            "method" => $getMethod
        ],
        [
            "url" => $profileBaseUrl . '/*',
            "method" => $putMethod
        ],
        [
            "url" => '/change-password',
            "method" => $getMethod
        ],
        [
            "url" => '/manuals-check-unique',
            "method" => $postMethod
        ],
        [
            "url" => '/remove-s3-file',
            "method" => $postMethod
        ],
        [
            "url" => '/upload-video-signed-url',
            "method" => $postMethod
        ],
        [
            "url" => $userBaseUrl . '/*/show',
            "method" => $getMethod

        ],

        [
            "url" => $contractorBaseUrl . '/*/show',
            "method" => $getMethod
        ],
        [
            "url" => $mansionBaseUrl . '/*/show',
            "method" => $getMethod
        ],
        [
            "url" => $buildingAdminBaseUrl . '/*/show',
            "method" => $getMethod
        ],
        [
            "url" => $manualBaseUrl . '/*/show',
            "method" => $getMethod
        ],
        [
            "url" => $guideBaseUrl . '/*/show',
            "method" => $getMethod
        ],
        [
            "url" => $infoDisplayBaseUrl . '/*/show',
            "method" => $getMethod
        ],
        [
            "url" => $notificationBaseUrl . '/*/show',
            "method" => $getMethod
        ],

    ],

    // All the routes are accessible by super user by default
    // routes entered in this array are not accessible by super user
    "permissionDeniedToSuperUserRoutes" => [],

    'modules' => [
        // [
        //   'name' => 'Dashboard',
        //   'icon' => "<i class='fa fa-home'></i>",
        //   'hasSubmodules' => false,
        //   'route' => $homeBaseUrl
        // ],
        [
            "name" => 'User Management',
            "icon" => "<i class='fa fa-user'></i>",
            "hasSubmodules" => true,
            "submodules" => [
                [
                    "name" => 'Users',
                    "icon" => "<i class='fa fa-users'></i>",
                    "hasSubmodules" => false,
                    "route" => $userBaseUrl,
                    "permissions" => [
                        [
                            "name" => 'View Users',
                            "route" => [
                                "url" => $userBaseUrl,
                                "method" => $getMethod
                            ]
                        ],
                        [
                            "name" => 'Create Users',
                            "route" => [
                                [
                                    "url" => $userBaseUrl . '/create',
                                    "method" => $getMethod
                                ],
                                [
                                    "url" => $userBaseUrl,
                                    "method" => $postMethod
                                ],
                            ]
                        ],
                        [
                            "name" => 'Edit Users',
                            "route" => [
                                [
                                    "url" => $userBaseUrl . '/*/edit',
                                    "method" => $getMethod
                                ],
                                [
                                    "url" => $userBaseUrl . '/*',
                                    "method" => $putMethod
                                ],
                            ]
                        ],
                        [
                            "name" => 'Delete Users',
                            "route" => [
                                "url" => $userBaseUrl . '/*',
                                "method" => $deleteMethod
                            ],
                        ],
                        [
                            "name" => 'Reset Password',
                            "route" => [
                                "url" => $userBaseUrl . '/reset-password/*',
                                "method" => $postMethod
                            ],
                        ],
                    ]
                ],
                // [
                //   "name" => 'Roles',
                //   "icon" => "<i class='fa fa-tags'></i>",
                //   "hasSubmodules" => false,
                //   "route" => '/roles',
                //   "permissions" => [
                //     [
                //       "name" => 'View Roles',
                //       "route" => [
                //         "url" => $roleBaseUrl,
                //         "method" => $getMethod
                //       ]
                //     ],
                //     [
                //       "name" => 'Create Roles',
                //       "route" => [
                //         [
                //           "url" => $roleBaseUrl . '/create',
                //           "method" => $getMethod
                //         ],
                //         [
                //           "url" => $roleBaseUrl,
                //           "method" =>  $postMethod
                //         ],
                //       ]
                //     ],
                //     [
                //       "name" => 'Edit Roles',
                //       "route" => [
                //         [
                //           "url" =>  $roleBaseUrl . '/*/edit',
                //           "method" => $getMethod
                //         ],
                //         [
                //           "url" => $roleBaseUrl . '/*',
                //           "method" => $putMethod
                //         ],
                //       ]
                //     ],
                //     [
                //       "name" => 'Delete Roles',
                //       "route" => [
                //         "url" => $roleBaseUrl . '/*',
                //         "method" => $deleteMethod
                //       ],
                //     ]
                //   ]
                // ],
            ]
        ],
        [
            "name" => 'Log Management',
            "icon" => "<i class='fa fa-history'></i>",
            "hasSubmodules" => true,
            "submodules" => [
                [
                    "name" => 'Login Logs',
                    "icon" => "<i class='fas fa-sign-in-alt'></i>",
                    "hasSubmodules" => false,
                    "route" => $loginLogsBaseUrl,
                    "permissions" => [
                        [
                            "name" => 'View Login logs',
                            "route" => [
                                "url" => $loginLogsBaseUrl,
                                "method" => $getMethod
                            ]
                        ],
                    ]
                ],
                [
                    "name" => 'Activity logs',
                    "icon" => "<i class='fas fa-chart-line'></i>",
                    "hasSubmodules" => false,
                    "route" => $activityLogsBaseUrl,
                    "permissions" => [
                        [
                            "name" => 'View Activity logs',
                            "route" => [
                                "url" => $activityLogsBaseUrl,
                                "method" => $getMethod
                            ]
                        ],
                    ]
                ],
            ]
        ],
//    [
//      "name" => 'Language Management',
//      "hasSubmodules" => true,
//      "icon" => "<i class='fa fa-language' aria-hidden='true'></i>",
//      "submodules" => [
//        [
//          "name" => 'Languages',
//          "icon" => "<i class='fa fa-language' aria-hidden='true'></i>",
//          "hasSubmodules" => false,
//          "route" => $languagesBaseUrl,
//          "permissions" => [
//            [
//              "name" => 'View Languages',
//              "route" => [
//                "url" => $languagesBaseUrl,
//                "method" => $getMethod
//              ]
//            ],
//            [
//              "name" => 'Create Languages',
//              "route" => [
//                [
//                  "url" => $languagesBaseUrl . '/create',
//                  "method" => $getMethod
//                ],
//                [
//                  "url" => $languagesBaseUrl,
//                  "method" => $postMethod
//                ],
//              ]
//            ],
//            [
//              "name" => 'Delete Languages',
//              "route" =>  [
//                "url" => $languagesBaseUrl . '/*',
//                "method" => $deleteMethod
//              ],
//            ]
//          ]
//        ],
//        [
//          "name" => 'Translations',
//          "icon" => "<i class='fa fa-globe' aria-hidden='true'></i>",
//          "hasSubmodules" => false,
//          "route" => $translationBaseUrl,
//          "permissions" => [
//            [
//              "name" => 'View Translations',
//              "route" => [
//                "url" => $translationBaseUrl,
//                "method" => $getMethod
//              ]
//            ],
//            [
//              "name" => 'Create Translations',
//              "route" =>  [
//                "url" => $translationBaseUrl,
//                "method" => $postMethod
//              ]
//            ],
//            [
//              "name" => 'Edit Translations',
//              "route" => [
//                "url" => $translationBaseUrl . '/*',
//                "method" => $putMethod
//              ]
//            ],
//            [
//              "name" => 'Delete Translations',
//              "route" => [
//                "url" => $translationBaseUrl . '/*',
//                "method" => $deleteMethod
//              ]
//            ],
//            [
//              "name" => 'Download Sample',
//              "route" =>  [
//                "url" => $translationBaseUrl . '/download-sample',
//                "method" => $getMethod
//              ],
//            ],
//            [
//              "name" => 'Download Excel',
//              "route" =>  [
//                "url" => $translationBaseUrl . '/download/*',
//                "method" => $getMethod
//              ],
//            ],
//            [
//              "name" => 'Upload Excel',
//              "route" =>  [
//                "url" => $translationBaseUrl . '/upload/*',
//                "method" => $postMethod
//              ],
//            ]
//          ]
//        ]
//
//      ]
//    ],
        [
            "name" => 'System configs',
            "icon" => "<i class='fa fa-cogs' aria-hidden='true'></i>",
            "hasSubmodules" => true,
            "submodules" => [
                [
                    "name" => 'Email Templates',
                    "icon" => "<i class='fa fa-envelope' aria-hidden='true'></i>",
                    "route" => $emailTemplateBaseUrl,
                    "hasSubmodules" => false,
                    "permissions" => [
                        [
                            "name" => 'View Email Templates',
                            "route" => [
                                "url" => $emailTemplateBaseUrl,
                                "method" => $getMethod
                            ]
                        ],
                        [
                            "name" => 'Edit Email Templates',
                            "route" => [
                                [
                                    "url" => $emailTemplateBaseUrl . '/*/edit',
                                    "method" => $getMethod
                                ],
                                [
                                    "url" => $emailTemplateBaseUrl . '/*',
                                    "method" => $putMethod
                                ]
                            ]
                        ],
                        [
                            "name" => 'Delete Email Templates',
                            "route" => [
                                "url" => $emailTemplateBaseUrl . '/*',
                                "method" => $deleteMethod
                            ]
                        ],
                    ]
                ],
                [
                    "name" => 'Configs',
                    "icon" => '<i class="fa fa-cog" aria-hidden="true"></i>',
                    "route" => $configBaseUrl,
                    "hasSubmodules" => false,
                    "permissions" => [
                        [
                            "name" => 'View Configs',
                            "route" => [
                                "url" => $configBaseUrl,
                                "method" => $getMethod
                            ]
                        ],
                        [
                            "name" => 'Create Config',
                            "route" => [
                                "url" => $configBaseUrl,
                                "method" => $postMethod
                            ]
                        ],
                        [
                            "name" => 'Edit Config',
                            "route" => [
                                "url" => $configBaseUrl . '/*',
                                "method" => $putMethod
                            ]
                        ],
                        [
                            "name" => 'Delete Config',
                            "route" => [
                                "url" => $configBaseUrl . '/*',
                                "method" => $deleteMethod
                            ]
                        ]
                    ]
                ]
            ]
        ],

        // [
        //   'name' => 'Category Management',
        //   'icon' => "<i class='fa fa-list'></i>",
        //   'hasSubmodules' => false,
        //   'route' => $categoriesBaseUrl,
        //   "permissions" => [
        //     [
        //       "name" => 'View Category',
        //       "route" => [
        //         "url" => $categoriesBaseUrl,
        //         "method" => $getMethod
        //       ]
        //     ],
        //     [
        //       "name" => 'Create Category',
        //       "route" => [
        //         [
        //           "url" => $categoriesBaseUrl . '/create',
        //           "method" => $getMethod
        //         ],
        //         [
        //           "url" => $categoriesBaseUrl,
        //           "method" => $postMethod
        //         ],
        //       ]
        //     ],
        //     [
        //       "name" => 'Edit Category',
        //       "route" => [
        //         [
        //           "url" => $categoriesBaseUrl . '/*/edit',
        //           "method" => $getMethod
        //         ],
        //         [
        //           "url" => $categoriesBaseUrl . '/*',
        //           "method" => $putMethod
        //         ]
        //       ]
        //     ],
        //     [
        //       "name" => 'Delete Category',
        //       "route" => [
        //         "url" => $categoriesBaseUrl . '/*',
        //         "method" => $deleteMethod
        //       ]
        //     ]
        //   ]
        // ],
        // [
        //   'name' => 'Mail Test',
        //   'icon' => "<i class='fa fa-envelope-o'></i>",
        //   'hasSubmodules' => false,
        //   'route' => $mailtestBaseUrl. '/create',
        //   "permissions" => [
        //     [
        //       "name" => 'Create Mail',
        //       "route" => [
        //         "url" => $mailtestBaseUrl . '/create',
        //         "method" => $getMethod
        //       ],
        //       [
        //         "url" => $mailtestBaseUrl,
        //         "method" => $postMethod
        //       ],
        //     ]
        //   ]
        // ],

        [
            'name' => 'Building Admin Management',
            'icon' => "<i class='fa fa-user'></i>",
            'hasSubmodules' => false,
            'route' => $buildingAdminBaseUrl,
            "permissions" => [
                [
                    "name" => 'View Building Admin',
                    "route" => [
                        "url" => $buildingAdminBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Create Building Admin',
                    "route" => [
                        [
                            "url" => $buildingAdminBaseUrl . '/create',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $buildingAdminBaseUrl,
                            "method" => $postMethod
                        ],

                    ]
                ],
                [
                    "name" => 'Edit Building Admin',
                    "route" => [
                        [
                            "url" => $buildingAdminBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $buildingAdminBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete Building Admin',
                    "route" => [
                        "url" => $buildingAdminBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],
        [
            'name' => 'Contractor Management',
            'icon' => "<i class='fa fa-file-contract'></i>",
            'hasSubmodules' => false,
            'route' => $contractorBaseUrl,
            "permissions" => [
                [
                    "name" => 'View Contractor',
                    "route" => [
                        "url" => $contractorBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Create Contractor',
                    "route" => [
                        [
                            "url" => $contractorBaseUrl . '/create',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $contractorBaseUrl,
                            "method" => $postMethod
                        ],

                    ]
                ],
                [
                    "name" => 'Edit Contractor',
                    "route" => [
                        [
                            "url" => $contractorBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $contractorBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete Contractor',
                    "route" => [
                        "url" => $contractorBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],
        [
            'name' => 'Mansion Management',
            'icon' => "<i class='fa fa-building'></i>",
            'hasSubmodules' => false,
            'route' => $mansionBaseUrl,
            "permissions" => [
                [
                    "name" => 'View Mansion',
                    "route" => [
                        "url" => $mansionBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Create Mansion',
                    "route" => [
                        [
                            "url" => $mansionBaseUrl . '/create',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $mansionBaseUrl,
                            "method" => $postMethod
                        ],

                    ]
                ],
                [
                    "name" => 'Edit Mansion',
                    "route" => [
                        [
                            "url" => $mansionBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $mansionBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete Mansion',
                    "route" => [
                        "url" => $mansionBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],
        [
            'name' => 'Guide Management',
            'icon' => "<i class='fa fa-glide'></i>",
            'hasSubmodules' => false,
            'route' => $guideBaseUrl,
            "permissions" => [
                [
                    "name" => 'View guide',
                    "route" => [
                        "url" => $guideBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Create guide',
                    "route" => [
                        [
                            "url" => $guideBaseUrl . '/create',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $guideBaseUrl,
                            "method" => $postMethod
                        ],

                    ]
                ],
                [
                    "name" => 'Edit guide',
                    "route" => [
                        [
                            "url" => $guideBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $guideBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete guide',
                    "route" => [
                        "url" => $guideBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],
        [
            'name' => 'Manual Management',
            'icon' => '<i class="fa fa-hdd-o" aria-hidden="true"></i>',
            'hasSubmodules' => false,
            'route' => $manualBaseUrl,
            "permissions" => [
                [
                    "name" => 'View manual',
                    "route" => [
                        "url" => $manualBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Create manual',
                    "route" => [
                        [
                            "url" => $manualBaseUrl . '/create',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $manualBaseUrl,
                            "method" => $postMethod
                        ],

                    ]
                ],
                [
                    "name" => 'Edit manual',
                    "route" => [
                        [
                            "url" => $manualBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $manualBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete manual',
                    "route" => [
                        "url" => $manualBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],

        [
            'name' => 'Information Display Management',
            'icon' => "<i class='fa fa-info'></i>",
            'hasSubmodules' => false,
            'route' => $infoDisplayBaseUrl,
            "permissions" => [
                [
                    "name" => 'View Information Display Management',
                    "route" => [
                        "url" => $infoDisplayBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Download Information Display Management',
                    "route" => [
                        "url" => $infoDisplayBaseUrl . '/download',
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Edit Information Display Management',
                    "route" => [
                        [
                            "url" => $infoDisplayBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $infoDisplayBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete Information Display Management',
                    "route" => [
                        "url" => $infoDisplayBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],
        [
            'name' => 'Notification Management',
            'icon' => "<i class='fa fa-bell'></i>",
            'hasSubmodules' => false,
            'route' => $notificationBaseUrl,
            "permissions" => [
                [
                    "name" => 'View Notification',
                    "route" => [
                        "url" => $notificationBaseUrl,
                        "method" => $getMethod
                    ]
                ],
                [
                    "name" => 'Create Notification',
                    "route" => [
                        [
                            "url" => $notificationBaseUrl . '/create',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $notificationBaseUrl,
                            "method" => $postMethod
                        ],

                    ]
                ],
                [
                    "name" => 'Edit Notification',
                    "route" => [
                        [
                            "url" => $notificationBaseUrl . '/*/edit',
                            "method" => $getMethod
                        ],
                        [
                            "url" => $notificationBaseUrl . '/*',
                            "method" => $putMethod
                        ]
                    ]
                ],
                [
                    "name" => 'Delete Notification',
                    "route" => [
                        "url" => $notificationBaseUrl . '/*',
                        "method" => $deleteMethod
                    ]
                ]
            ]
        ],
    ]
];
