<?php

namespace api\controllers;

use api\core\entities\User\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
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

        return $behaviors;
    }

    /**
     * @return User
     */
    public function actionIndex(): User
    {
        return $this->findModel();
    }

    public function verbs(): array
    {
        return [
            'index' => ['get']
        ];
    }

    /**
     * @return User
     */
    private function findModel(): User
    {
        return User::findOne(\Yii::$app->user->id);
    }
}
