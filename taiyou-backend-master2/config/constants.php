<?php
return [
    "URL" => env('APP_URL'),
    "APP_DOMAIN" => env('APP_DOMAIN'),
    "APP_PROTOCOL" => env('APP_PROTOCOL', 'https'),
    "PREFIX" => env('PREFIX', 'system'),
    "TWOFA" => env('TWOFA', 1),
    "META" =>  ['meta' => [
        "copyright" => "Copyright 2020 E.K. Solutions Pvt. Ltd.",
        "site" => env('APP_URL'),
        "emails" => ["taiyou@ekbana.info", "ekbana@info.com"],
        "api" => [
            "version" => 1
        ]
    ]],
    "FROM_MAIL" => env('MAIL_FROM_ADDRESS', 'info@ekbana.net'),
    "FROM_NAME" => env('MAIL_FROM_NAME', 'TAIYOU'),
    'DEFAULT_LOCALE' => env('DEFAULT_LOCALE', 'en'),
    'ADMIN_DEFAULT_EMAIL' => env('ADMIN_DEFAULT_EMAIL','admin@mailinator.com'),
    'FCM_ALL_USERS' => env('FCM_ALL_USERS','https://us-central1-develop-birumane.cloudfunctions.net/sendPushNotificationToAllUsers'),
    'FCM_TO_USERS' => env('FCM_TO_USERS','https://us-central1-develop-birumane.cloudfunctions.net/sendPushNotificationToUsers'),
    'PAGINATION' =>25,
    'VERSION_APP' => '1.0.8'
];
