<?php
<<<<<<< HEAD
use Yii\helpers\Html;
use yii\helpers\Url;
=======
use yii\helpers\Html;
>>>>>>> 2a6f6f0b8627831ae1d53b9c909b869605a6142b

/* @var $this \\Yii\web\View */
/* @var $content string */
/* @var \common\auth\Identity $identity */

$identity = \Yii::$app->user->identity;
?>

<header class="main-header">

<<<<<<< HEAD
    <?= Html::a('<span class="logo-mini">' . \Yii::$app->params['appNameMin'] . '</span><span class="logo-lg">' . \Yii::$app->params['appNameBig'] . '</span>', \Yii::$app->homeUrl, ['class' => 'logo']) ?>
=======
    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . \Yii::$app->name . '</span>', \Yii::$app->homeUrl, ['class' => 'logo']) ?>
>>>>>>> 2a6f6f0b8627831ae1d53b9c909b869605a6142b

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
<<<<<<< HEAD
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= \Yii::$app->user->identity->name ?: \Yii::$app->user->identity->username;?></span>
=======
                        <img src="<?//= $identity->getPhoto();?>" class="user-image" alt="<?= $identity->getFullName();?>"/>
                        <span class="hidden-xs"><?= $identity->getFullName();?></span>
>>>>>>> 2a6f6f0b8627831ae1d53b9c909b869605a6142b
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?//= $identity->getPhoto();?>" class="img-circle" alt="User Image"/>
                            <p>
<<<<<<< HEAD
                                <?= \Yii::$app->user->identity->name ?: \Yii::$app->user->identity->username;?>
=======
                                <?= $identity->getFullName();?> - <?= $identity->getRole();?>
>>>>>>> 2a6f6f0b8627831ae1d53b9c909b869605a6142b
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
<<<<<<< HEAD
                                <a href="<?= Url::toRoute(['users/update', 'id' => \Yii::$app->user->id])?>" class="btn btn-default btn-flat">Profile</a>
=======
                                <?= Html::a(\Yii::t('app', 'Profile'), \yii\helpers\Url::toRoute(['users/update', 'id' => $identity->getId()]), ['class' => 'btn btn-default btn-flat'])?>
>>>>>>> 2a6f6f0b8627831ae1d53b9c909b869605a6142b
                            </div>
                            <div class="pull-right">
                                <?= Html::a(
                                    \Yii::t('app', 'Sign out'),
                                    \yii\helpers\Url::toRoute(['/logout']),
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
