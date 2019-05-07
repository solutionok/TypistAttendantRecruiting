<?php


return [

    /*
    |--------------------------------------------------------------------------
    | Messenger Default User Model
    |--------------------------------------------------------------------------
    |
    | This option defines the default User model.
    |
    */

    'user' => [
        'model' => 'App\User'
    ],

    /*
    |--------------------------------------------------------------------------
    | Messenger Pusher Keys
    |--------------------------------------------------------------------------
    |
    | This option defines pusher keys.
    |
    */

    'pusher' => [
        'app_id'     => 'asdf',
        'app_key'    => 'asdf',
        'app_secret' => 'asdf',
        'options' => [
            'cluster'   => 'asdf',
            'encrypted' => true
        ]
    ],
];
