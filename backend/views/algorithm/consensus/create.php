<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\algorithm\EncryptionForm */

use yii\helpers\Url;

$this->title = Yii::t('app', 'Create Algorithm encryption');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Algorithm encryption'), 'url' => Url::toRoute(['/encryption'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>