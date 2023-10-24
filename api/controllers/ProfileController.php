<?php

namespace api\controllers;

use core\entities\User\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\rest\Controller;

/**
 * Class ProfileController
 * @package api\controllers
 */
class ProfileController extends Controller
{

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
              HttpBasicAuth::class,
              HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['admin']
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'index' => ['get'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return User
     */
    public function actionIndex(): User
    {
        return $this->findModel();
    }

    /**
     * @return User
     */
    private function findModel(): User
    {
        return User::findOne(Yii::$app->user->id);
    }
}
