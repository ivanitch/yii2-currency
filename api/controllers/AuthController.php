<?php

namespace api\controllers;

use api\forms\LoginForm;
use core\entities\User\Token;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['?']
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class'   => VerbFilter::class,
            'actions' => [
                'auth' => ['post'],
            ],
        ];

        return $behaviors;
    }

    public function actionAuth(): Token|LoginForm
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');
        if ($token = $model->auth()) return $token;

        return $model;
    }
}
