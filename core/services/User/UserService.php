<?php

namespace core\services\User;

use core\entities\User\User;
use core\forms\User\UserCreateForm;
use core\forms\User\UserEditForm;
use core\repositories\UserRepository;
use core\services\TransactionManager;
use core\services\User\RoleManager;

class UserService
{
    private $repository;
    private $roles;
    private $transaction;

    public function __construct(UserRepository $repository, RoleManager $roles, TransactionManager $transaction)
    {
        $this->repository = $repository;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
    }

    public function remove($id): void
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }

    public function assignRole($id, $role): void
    {
        $user = $this->repository->get($id);
        $this->roles->assign($user->id, $role);
    }
}