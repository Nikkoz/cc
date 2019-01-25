<?php
namespace core\repositories;

use core\entities\User;
use yii\db\DataReader;

class UserRepository
{
    public function getById(int $id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByEmail(string $email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function existsByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function getByPasswordResetToken(string $token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            echo '<pre>'.print_r($user->errors,1).'</pre>';die;
            throw new \RuntimeException('Saving error.');
        }
    }

    private function getBy(array $conditions): User
    {
        if(!$user = User::find()->andWhere($conditions)->limit(1)->one()) {
            throw new \DomainException('User is not found');
        }

        return $user;
    }

    public function findByUserNameOrEmail(string $value): User
    {
        return $this->getBy(['or', ['email' => $value], ['username' => $value]]);
    }

    public function remove(User $user): void
    {
        if(!$user->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function getOAuth(int $id): array
    {
        $connection = \Yii::$app->getDb();

        if (!$result = $connection->createCommand('SELECT client_id, client_secret FROM oauth_clients WHERE user_id=:id', [':id' => $id])->queryOne()) {
            throw new \DomainException('User does not have access.');
        }

        return $result;
    }

    public function setOAuth(int $id, string $login, string $password): void
    {
        $connection = \Yii::$app->getDb();

        $connection->createCommand('INSERT INTO oauth_clients (client_id, client_secret, redirect_uri, grant_types, user_id)
                                         VALUES (:client_id, :client_secret, :redirect_uri, :grant_types, :user_id)',
            [':client_id' => $login, 'client_secret' => $password, 'redirect_uri' => 'http://fake.com', 'grant_types' => 'client_credentials authorization_code password implicit', 'user_id' => $id])->execute();
    }
    
    /*public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }*/
}