<?php

namespace api\controllers;

use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return 'PHP_VERSION: ' . PHP_VERSION;
    }
}
