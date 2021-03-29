<?php
/** @var array $params */
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [
        '' => 'site/index',
        'POST auth' => 'site/login',
        'GET profile' => 'profile/index',

        'currencies/page=<page:\d+>' => 'currency/currencies',
        'currencies' => 'currency/currencies',
        'currencies/<id:\d+>' => 'currency/currency',

//        [
//            'pluralize' => true, // Во множественное число
//            'class' => 'yii\rest\UrlRule',
//            'controller' => 'product'//можно массив контроллеров
//        ],
    ],
];