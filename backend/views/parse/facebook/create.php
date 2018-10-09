<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\FacebookForm */

$this->title = Yii::t('app', 'Create Facebook post');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Parse'), 'url' => ['/posts']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Facebook post'), 'url' => ['/facebook']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
            'is' => 'create'
        ]) ?>
    </div>
</div>