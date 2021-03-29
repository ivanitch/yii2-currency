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
    ],
];