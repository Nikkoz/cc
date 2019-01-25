<?php
namespace core\services\auth;

use core\entities\User;
use core\forms\auth\LoginForm;
use core\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUserNameOrEmail($form->username);
        if(!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }

        return $user;
    }

    public function getAccesses(User $user): array
    {
        return $this->users->getOAuth($user->id);
    }

    public function setAccesses(User $user): array
    {
        $this->users->setOAuth($user->id, "{$user->username}client", "{$user->username}pass");

        return [
            'login' => "{$user->username}client",
            'password' => "{$user->username}pass",
        ];
    }
}