<?php

return [
    'id' => 'basic-tests',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'App\\Controllers',
    'language' => 'en-US',
    'components' => [
        'db' => require __DIR__ . '/test_db.php',
        'request' => [
            'cookieValidationKey' => 'key',
            'enableCsrfValidation' => false,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
        ],
    ],
    'container' => require __DIR__ . '/container.php',
];
