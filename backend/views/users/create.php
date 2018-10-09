<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\UsersForm */

$this->title = Yii::t('app', 'Create user');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>