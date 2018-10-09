<?php

namespace core\forms\manage;


use core\entities\User;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class UsersForm
 * @package core\forms\manage
 *
 * @property string $username
 * @property string $name
 * @property string $email
 * @property string $role
 * @property int $status
 * @property string $password
 * @property string $password_confirm
 *
 * @property array $statusList
 * @property array $roles
 *
 * @property User $_user
 */
class UsersForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $role;
    public $status;
    public $password;
    public $password_confirm;

    private $_user;

    public function __construct(User $user = null, array $config = [])
    {
        if($user) {
            $this->username = $user->username;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->status = $user->status;
            $this->role = $user->role;

            $this->_user = $user;
        }

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['username', 'status', 'email', 'role'], 'required'],
            [['username', 'name', 'email', 'role'], 'string', 'max' => 255],
            ['status', 'integer'],
            [
                'username',
                'unique',
                'targetClass' => User::class,
                'filter' => $this->_user ? ['<>', 'id', $this->_user->id] : null,
                'message' => \Yii::t('app', 'This username has already been taken.')
            ],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'filter' => $this->_user ? ['<>', 'id', $this->_user->id] : null,
                'message' => \Yii::t('app', 'This email address has already been taken.')
            ],
            ['status', 'default', 'value' => User::STATUS_ACTIVE],
            ['password', 'string', 'min' => 6, 'max' => 15],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function getStatusList(): array
    {
        return [
            User::STATUS_ACTIVE => \Yii::t('app', 'Active'),
            User::STATUS_DELETED => \Yii::t('app', 'Inactive'),
        ];
    }

    public function getRoles(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }
}