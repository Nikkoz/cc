<?php

namespace core\services\manage;


use core\entities\User;
use core\forms\manage\UsersForm;
use core\repositories\UserRepository;

/**
 * Class UsersService
 * @package core\services\manage
 *
 * @property UserRepository $repository
 */
class UsersService
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UsersForm $form
     * @return User
     * @throws \Exception
     */
    public function create(UsersForm $form): User
    {
        $user = User::create($form->username, $form->name, $form->email, $form->status);

        $user->setPassword($form->password);
        $user->generateAuthKey();

        $this->repository->save($user);

        $user->setRole($form->role);

        $this->repository->save($user);

        return $user;
    }

    /**
     * @param int $id
     * @param UsersForm $form
     * @throws \Exception
     */
    public function edit(int $id, UsersForm $form): void
    {
        $user = $this->repository->getById($id);

        $user->edit($form->username, $form->name, $form->email, $form->status);

        $user->setPassword($form->password);
        $user->generateAuthKey();

        $user->checkRole($form->role);

        $this->repository->save($user);
    }

    public function remove(int $id): void
    {
        $user = $this->repository->getById($id);
        $user->revokeRoles();
        $this->repository->remove($user);
    }
}