<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var \common\auth\Identity $identity */

$identity = \Yii::$app->user->identity;
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . \Yii::$app->name . '</span>', \Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?//= $identity->getPhoto();?>" class="user-image" alt="<?= $identity->getFullName();?>"/>
                        <span class="hidden-xs"><?= $identity->getFullName();?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?//= $identity->getPhoto();?>" class="img-circle" alt="User Image"/>
                            <p>
                                <?= $identity->getFullName();?> - <?= $identity->getRole();?>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <?= Html::a(\Yii::t('app', 'Profile'), \yii\helpers\Url::toRoute(['users/update', 'id' => $identity->getId()]), ['class' => 'btn btn-default btn-flat'])?>
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
