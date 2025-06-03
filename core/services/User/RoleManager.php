<?php

namespace core\services\User;

use yii\rbac\ManagerInterface;

class RoleManager
{
    public function __construct(private ManagerInterface $manager)
    {
    }

    public function assign($userId, $name): void
    {
        if (!$role = $this->manager->getRole($name)) {
            throw new \DomainException('Role "' . $name . '" does not exist.');
        }
        $this->manager->revokeAll($userId);
        $this->manager->assign($role, $userId);
    }
}