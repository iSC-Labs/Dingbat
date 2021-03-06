<?php

return [

    // EDIT START

    'name' => 'Dingbat',

    'database' => [
        'host'     => '127.0.0.1',
        'username' => 'root',
        'password' => 'bitnami',
        'name'     => 'dingbat',
    ],

    'language' => 'en', // or 'de'

    // EDIT END

    'assets' => [
        'scripts' => [
            'vendor/custom.modernizr',
            'vendor/jquery-1.9.1.min',
            'vendor/foundation.min',
            'vendor/json2.min',
            'vendor/underscore.min',
            'vendor/backbone.min',
            'vendor/backbone.layoutmanager.min',
            'vendor/jquery.keycut.min',
            'Model/task',
            'Model/card',
            'Collection/tasks',
            'Collection/cards',
            'Collection/list',
            'View/card',
            'View/navigation',
            'View/form',
            'View/task',
            'View/list',
            'View/footer',
            'View/sidebar',
            'router',
            'View/app',
            'dingbat'
        ],
    ],

    'debugging' => false,
];
