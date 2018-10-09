<?php

namespace console\controllers;


use core\entities\User;
use core\repositories\UserRepository;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class RbacController
 * @package console\controllers
 *
 * @property UserRepository $repository
 */
class RbacController extends Controller
{
    private $repository;

    public function __construct(string $id, $module, UserRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
    }

    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Create roles
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';

        $user = $auth->createRole('user');
        $user->description = 'Пользователь';

        $test = $auth->createRole('test');
        $test->description = 'Пользователь с ограничениями';

        $coupon = $auth->createRole('coupon');
        $coupon->description = 'Пользователь с частью ограничений';

        // save roles to DB
        $auth->add($admin);
        $auth->add($user);
        $auth->add($test);
        $auth->add($coupon);

        // Create permissions
        $adminPermission = $auth->createPermission('adminPermission');
        $adminPermission->description = 'Доступ к панели администратора';

        $userPermission = $auth->createPermission('userPermission');
        $userPermission->description = 'Доступ к платным функциям сайта';

        $testPermission = $auth->createPermission('testPermission');
        $testPermission->description = 'Тестовый период(5 дней)';

        $couponPermission = $auth->createPermission('couponPermission');
        $couponPermission->description = 'Тестовый период по купону(10 дней)';

        // save permissions to DB
        $auth->add($adminPermission);
        $auth->add($userPermission);
        $auth->add($testPermission);
        $auth->add($couponPermission);

        // add inheritance
        $auth->addChild($test, $testPermission);
        $auth->addChild($coupon, $couponPermission);
        $auth->addChild($user, $userPermission);

        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPermission);

        // create admin
        try {
            $exist = $this->repository->getById(1);
            $auth->assign($admin, $exist->id);

            $this->stdout('Admin is created.' . "\n", Console::FG_GREEN);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            $this->stdout($e->getMessage() . "\n", Console::FG_RED);
        }

        // create test user(not admin)
        try {
            $exist = $this->repository->getById(2);
            $auth->assign($user, $exist->id);

            $this->stdout('Test user is created.' . "\n", Console::FG_GREEN);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            $this->stdout($e->getMessage() . "\n", Console::FG_RED);
        }
    }


}