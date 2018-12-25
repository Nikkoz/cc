<?php

namespace api\controllers;


use core\entities\User;
use yii\rest\Controller;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        return $this->serializeUser($this->findModel());
    }

    public function verbs(): array
    {
        return [
            'index' => ['GET'],
        ];
    }

    private function findModel(): User
    {
        return User::findOne(\Yii::$app->user->id);
    }

    private function serializeUser(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->username,
            'email' => $user->email,
        ];
    }
}

/**
{"grant_type": "password","username": "admin","password": "1q2w3e4r","client_id": "admin","client_secret": "adminpass"}
{"grant_type": "password","username": "admin","password": "1q2w3e4r","client_id": "testclient","client_secret": "testpass"}
 */