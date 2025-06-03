<?php

namespace core\services\User;

use core\repositories\UserRepository;

readonly class UserService
{
    public function __construct(
        private UserRepository $repository,
        private RoleManager    $roles
    )
    {
    }

    /**
     * @param int $id
     * @param string $role
     * @return void
     */
    public function assignRole(int $id, string $role): void
    {
        $user = $this->repository->get($id);
        $this->roles->assign($user->id, $role);
    }
}
