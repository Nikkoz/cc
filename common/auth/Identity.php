<?php

namespace common\auth;

use filsh\yii2\oauth2server\Module;
use core\readModels\UserReadRepository;
use OAuth2\Storage\UserCredentialsInterface;
use core\entities\User;
use Yii;
use yii\web\IdentityInterface;

/**
 * Class Identity
 * @package common\auth
 *
 * @property User $user
 *
 * @property string $fullName
 */
class Identity implements IdentityInterface, UserCredentialsInterface
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function findIdentity($id)
    {
        $user = self::getRepository()->findActiveById($id);
        return $user ? new self($user) : null;
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return Identity|null|IdentityInterface
     * @throws \yii\base\InvalidConfigException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = self::getOauth()->getServer()->getResourceController()->getToken();
        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getUsername(): string
    {
        return $this->user->username;
    }

    public function getFullName(): string
    {
        return $this->user->name;
    }

    /*public function getPhoto(): ?string
    {
        if(!$this->user->photo) {
            return null;
        }

        $repository = new PicturesRepository();
        $photo = $repository->get($this->user->photo);

        return $photo->getPicture('users');
    }*/

    public function getRole(): ?string
    {
        $roles = \Yii::$app->authManager->getRolesByUser($this->user->id);
        return $roles ? reset($roles)->description : null;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    public function checkUserCredentials($username, $password): bool
    {
        if (!$user = self::getRepository()->findActiveByUsername($username)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($username): array
    {
        $user = self::getRepository()->findActiveByUsername($username);
        return ['user_id' => $user->id];
    }

    private static function getRepository(): UserReadRepository
    {
        return Yii::$container->get(UserReadRepository::class);
    }

    private static function getOauth(): Module
    {
        return Yii::$app->getModule('oauth2');
    }
}