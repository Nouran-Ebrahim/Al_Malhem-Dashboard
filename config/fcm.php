<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAZEJqZvY:APA91bF82qsjAU7JT0o13lffHWsgI2PkAu92MGPxSpuXqcsI1pGDuRofOufE4MxdsiwojkkKN4bX_cuOGGJ3w54Yws4q5SLwKX69bf9Bo9gZkenUh-W7rooZeOeGMOJWQgzTbWTiJhL7'),
        'sender_id' => env('FCM_SENDER_ID', '430610999030'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'server_topic_url' => 'https://iid.googleapis.com/iid/v1/',
        'timeout' => 30.0, // in second
    ],
];
