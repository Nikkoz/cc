<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\manage\posts\TwitterForm */

$this->title = Yii::t('app', 'Create Twitter post');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Parse'), 'url' => ['/posts']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Twitter post'), 'url' => ['/twitter']];
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