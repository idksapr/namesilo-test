<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use App\Domains\Repositories\TldRepository;
use App\Domains\Repositories\DomainRepository;
use yii\di\Instance;

return [
    'singletons' => [
        EntityManager::class => function () {
            $conn = [
                'driver' => 'pdo_sqlite',
                'path' => dirname(__DIR__) . '/db.sqlite',
            ];

            $config = Setup::createAnnotationMetadataConfiguration([dirname(__DIR__) . '/src'], true, null, null, false);
            return EntityManager::create($conn, $config);
        }
    ],
    'definitions' => [
        TldRepository::class => [
            ['class' => TldRepository::class],
            [Instance::of(EntityManager::class)],
        ],
        DomainRepository::class => [
            ['class' => DomainRepository::class],
            [Instance::of(EntityManager::class)],
        ],
    ],
];
