<?php

use common\bootstrap\SetUp;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id'                  => 'app-console',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => [
        'log',
        SetUp::class
    ],
    'controllerNamespace' => 'console\controllers',
    'aliases'             => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap'       => [
        'fixture' => [
            'class'     => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        'migrate' => [
            'class'          => 'fishvision\migrate\controllers\MigrateController',
            'autoDiscover'   => true,
            'migrationPaths' => [
                '@vendor/yiisoft/yii2/rbac/migrations',
            ],
        ],
    ],
    'components'          => [
        'log' => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ]
    ],
    'params'              => $params,
];