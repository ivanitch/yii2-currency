<?php

namespace common\bootstrap;

use Yii;
use yii\base\BootstrapInterface;
use yii\caching\Cache;
use yii\rbac\ManagerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton(Cache::class, function () use ($app) {
            return $app->cache;
        });

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });
    }
}
