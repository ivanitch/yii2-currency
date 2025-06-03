<?php

namespace console\controllers;

use core\entities\User\User;
use core\services\User\UserService;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;

/**
 * Interactive console roles manager
 */
class RoleController extends Controller
{
    public function __construct(
        $id,
        $module,
        private readonly UserService $service,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    /**
     * Adds role to user
     */
    public function actionAssign(): void
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $user     = $this->findModel($username);
        $role     = $this->select(
            'Role:',
            ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description')
        );
        $this->service->assignRole($user->id, $role);
        $this->stdout('Done!' . PHP_EOL);
    }

    private function findModel($username): User
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new Exception('User is not found');
        }

        return $model;
    }
}