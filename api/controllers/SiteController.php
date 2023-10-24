<?php

namespace api\controllers;

use api\forms\LoginForm;
use core\entities\User\Token;
use Yii;
use yii\rest\Controller;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return 'api';
    }

    public function actionLogin(): Token|LoginForm
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
