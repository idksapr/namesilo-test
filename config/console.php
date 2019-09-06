<?php

return [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'en-US',
    'components' => [
        'db' => require __DIR__ . '/test_db.php',
        'request' => [
            'scriptFile' => dirname(__DIR__) . '/web/index-test.php',
        ],
    ],
    'container' => require __DIR__ . '/container.php',
];
