<?php
return [
    // 'database' => [
    //     'name' => 'DATABASE_NAME',
    //     'username' => 'DATABASE_USERNAME',
    //     'password' => 'DATABASE_PASSWORD',
    //     'connection' => 'DATABASE_CONNECTION',
    //     'options' => [
    //         'CONNECTION_OPTIONS'
    //     ],
    // ],

    // example
    'database' => [
        'name' => 'test',
        'username' => 'root',
        'password' => '',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ],
    ],
];
