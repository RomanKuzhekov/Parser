<?php

return [
    'url' => 'https://av.ru/',
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'parser',
        'charset' => 'UTF8'
    ],
    'countPars' => 10,
    'root_dir' => $_SERVER['DOCUMENT_ROOT'] . "/"
];