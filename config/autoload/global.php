<?php

return [
    'image_upload_dir' => '/var/www/html/chat-web-app/',

    'db' => [
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=chat-web-app;host=localhost',
        'username' => '',
        'password' => ''
    ],
    'service_manager' => [
        'factories' => [
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        ],
    ],
];