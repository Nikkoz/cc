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