<?php

namespace api\controllers;

use Yii;
use yii\rest\Controller;
use api\core\forms\LoginForm;

class SiteController extends Controller
{
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($token = $model->auth()) return $token;
        return $model;
    }

    protected function verbs(): array
    {
        return [
            'login' => ['post'],
        ];
    }
}
