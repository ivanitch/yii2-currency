<?php

return [
    'aliases'    => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'timeZone'   => 'Europe/Moscow',
    'components' => [
        'cache'       => [
            'class'     => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache',
        ],
        'authManager' => [
            'class'           => 'yii\rbac\DbManager',
            'itemTable'       => '{{%auth_items}}',
            'itemChildTable'  => '{{%auth_item_children}}',
            'assignmentTable' => '{{%auth_assignments}}',
            'ruleTable'       => '{{%auth_rules}}',
        ],
        'formatter'   => [
            'class'             => 'yii\i18n\Formatter',
            'decimalSeparator'  => ',',
            'thousandSeparator' => ' ',
            'currencyCode'      => 'EUR',
            'dateFormat'        => 'php: d.m.Y',
            'datetimeFormat'    => 'php: d.m.Y H:i',
        ],
        'db'          => [
            'class'               => 'yii\db\Connection',
            'dsn'                 => 'mysql:host=localhost;port=3306;dbname=app',
            'username'            => 'root',
            'password'            => 'root',
            'charset'             => 'utf8mb4',
            'tablePrefix'         => 'prefix_',
            'enableSchemaCache'   => true,
            'schemaCacheDuration' => 3600 * 24 * 30 * 12,
            'schemaCache'         => 'cache',
            'schemaMap'           => [
                'mysql' => [
                    'class'             => 'yii\db\mysql\Schema',
                    'columnSchemaClass' => [
                        'class'              => 'yii\db\mysql\ColumnSchema',
                        'disableJsonSupport' => true,
                    ]
                ]
            ]
        ],
        'mailer'      => [
            'class'            => 'yii\swiftmailer\Mailer',
            'viewPath'         => '@common/mail',
            'transport'        => [
                'class'    => 'Swift_SmtpTransport',
                'host'     => 'host',
                'username' => 'username',
                'password' => 'password',
                'port'     => '25', // 465
                //'encryption' => 'ssl',
            ],
            'messageConfig'    => [
                'from' => ['admin@site.com' => 'www.site.com']
            ],
            'useFileTransport' => false,
        ],
    ]
];