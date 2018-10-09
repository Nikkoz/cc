<?php
namespace common\bootstrap;

use core\services\auth\SignupService;
use core\services\contact\ContactService;
use yii\base\BootstrapInterface;
use core\services\auth\PasswordResetService;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class, [], [
            [\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot']
        ]);

        $container->setSingleton(SignupService::class);

        $container->setSingleton(MailerInterface::class, function() use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ContactService::class, [], [
            $app->params['supportEmail'],
            $app->params['adminEmail'],
        ]);
    }
}