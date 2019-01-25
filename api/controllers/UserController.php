<?php

namespace api\controllers;


use core\entities\User;
use core\forms\auth\LoginForm;
use core\forms\manage\UsersForm;
use core\services\auth\AuthService;
use core\services\manage\UsersService;
use yii\base\Security;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 * Class UserController
 * @package api\controllers
 *
 * @property AuthService $service
 * @property UsersService $userService
 */
class UserController extends Controller
{
    private $service;
    private $userService;

    public function __construct(string $id, $module, AuthService $service, UsersService $userService, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->userService = $userService;
    }

    public function verbs(): array
    {
        return [
            'auth' => ['POST'],
            'signin' => ['POST'],
        ];
    }

    /**
     * @return array
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAuth(): array
    {
        $form = new LoginForm();
        $form->load(\Yii::$app->request->getBodyParams(), '');

        if ($form->validate()) {
            try {
                $user = $this->service->auth($form);
                $oauth = $this->service->getAccesses($user);

                return [
                    'id' => $user->id,
                    'name' => $user->username,
                    'email' => $user->email,
                    'login' => $oauth['client_id'],
                    'password' => $oauth['client_secret']
                ];
            } catch (\DomainException $e) {
                throw new BadRequestHttpException($e->getMessage(), null, $e);
            }
        } else {
            return $form->errors;
        }
    }

    /**
     * @return array
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSignin()
    {
        $params = \Yii::$app->request->getBodyParams();
        $email = explode('@', $params['email']);

        $form = new UsersForm();
        $form->load(\array_merge(
            $params,
            [
                'username' => $params['email'],
                'role' => 'user',
                'status' => User::STATUS_ACTIVE,
                'name' => $email[0],
                'password' => (new Security())->generateRandomString(8)
            ]
        ), '');

        if ($form->validate()) {
            $user = $this->userService->create($form);
            $oauth = $this->service->setAccesses($user);

            //add email notification

            return \array_merge([
                'id' => $user->id,
                'name' => $user->username,
                'email' => $user->email,
            ], $oauth);
        } else {
            return $form->errors;
        }
    }
}