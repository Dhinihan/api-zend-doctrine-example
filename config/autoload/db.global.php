<?php
return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOPgSql\Driver::class,
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '5432',
                    'user'     => 'postgres',
                    'password' => '',
                    'dbname'   => 'api_teste',
                ],
            ],
        ],
    ],
];
